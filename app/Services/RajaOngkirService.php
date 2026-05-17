<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * RajaOngkir Komerce API Service
 *
 * DEBUGGING "Layanan tidak tersedia":
 * Penyebab utama:
 * 1. District ID kosong saat fetch ongkir (kecamatan belum dipilih)
 * 2. Format response API berbeda dari yang di-expect (cost vs price)
 * 3. API key salah atau expired
 * 4. Origin city ID tidak sesuai
 *
 * Fix: Accept district ATAU city ID sebagai destination,
 *      handle berbagai format response (cost[]/price/etc)
 */
class RajaOngkirService {
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct() {
        $this->apiKey  = config('services.rajaongkir.api_key', env('RAJAONGKIR_API_KEY', 'a1e8f7837349a954614144f9d6ab80c5'));
        $this->baseUrl = config('services.rajaongkir.base_url', 'https://rajaongkir.komerce.id/api/v1');
    }

    protected function headers(): array {
        return ['key' => $this->apiKey];
    }

    public function getProvinces(): array {
        return Cache::remember('rongkir_prov', 86400, function () {
            try {
                $r = Http::timeout(10)->withHeaders($this->headers())
                    ->get("{$this->baseUrl}/destination/province");
                if ($r->successful()) {
                    $data = $r->json('data', []);
                    Log::info('RajaOngkir provinces: ' . count($data) . ' items');
                    return $data;
                }
                Log::error('RajaOngkir provinces failed: ' . $r->status() . ' ' . $r->body());
            } catch (\Exception $e) {
                Log::error('RajaOngkir provinces exception: ' . $e->getMessage());
            }
            return [];
        });
    }

    public function getCities(string $provinceId): array {
        return Cache::remember("rongkir_city_{$provinceId}", 86400, function () use ($provinceId) {
            try {
                $r = Http::timeout(10)->withHeaders($this->headers())
                    ->get("{$this->baseUrl}/destination/city/{$provinceId}");
                if ($r->successful()) {
                    return $r->json('data', []);
                }
                Log::error('RajaOngkir cities failed: ' . $r->status() . ' ' . $r->body());
            } catch (\Exception $e) {
                Log::error('RajaOngkir cities exception: ' . $e->getMessage());
            }
            return [];
        });
    }

    public function getDistricts(string $cityId): array {
        return Cache::remember("rongkir_dist_{$cityId}", 86400, function () use ($cityId) {
            try {
                $r = Http::timeout(10)->withHeaders($this->headers())
                    ->get("{$this->baseUrl}/destination/district/{$cityId}");
                if ($r->successful()) {
                    return $r->json('data', []);
                }
                Log::error('RajaOngkir districts failed: ' . $r->status() . ' ' . $r->body());
            } catch (\Exception $e) {
                Log::error('RajaOngkir districts exception: ' . $e->getMessage());
            }
            return [];
        });
    }

    /**
     * Calculate shipping cost.
     * FIX: Endpoint district/domestic-cost membutuhkan destination berupa district_id.
     * Jika kecamatan tidak dipilih, fallback ke endpoint city/domestic-cost.
     * Handle berbagai format response: cost[].value, price, atau cost langsung.
     */
    public function calculateCost(string $origin, string $destination, int $weight, string $courier): array {
        try {
            // Coba endpoint district dulu
            $payload = [
                'origin'      => $origin,
                'destination' => $destination,
                'weight'      => $weight,
                'courier'     => $courier,
            ];

            Log::info('RajaOngkir calculateCost payload: ' . json_encode($payload));

            $r = Http::timeout(15)->withHeaders($this->headers())
                ->post("{$this->baseUrl}/calculate/district/domestic-cost", $payload);

            Log::info('RajaOngkir response status: ' . $r->status());
            Log::info('RajaOngkir response body: ' . substr($r->body(), 0, 500));

            if ($r->successful()) {
                $data = $r->json('data', []);
                if (!empty($data)) {
                    return $this->normalizeServices($data);
                }
            }

            // Fallback: coba endpoint lain jika district gagal
            $r2 = Http::timeout(15)->withHeaders($this->headers())
                ->post("{$this->baseUrl}/calculate/domestic-cost", $payload);

            Log::info('RajaOngkir fallback response: ' . $r2->status() . ' ' . substr($r2->body(), 0, 300));

            if ($r2->successful()) {
                $data2 = $r2->json('data', []);
                return $this->normalizeServices($data2);
            }

            return [];
        } catch (\Exception $e) {
            Log::error('RajaOngkir calculateCost exception: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Normalisasi format service dari API ke format konsisten:
     * [{ service, description, cost: [{ value, etd }] }]
     *
     * API Rajaongkir Komerce bisa mengembalikan berbagai format:
     * Format A: { service, description, cost: [{ value, etd, note }] }
     * Format B: { service_code, service_name, price, etd }
     * Format C: { name, price, etd }
     */
    protected function normalizeServices(array $data): array {
        if (empty($data)) return [];

        $normalized = [];

        foreach ($data as $item) {
            // Format A (Rajaongkir standard)
            if (isset($item['service']) && isset($item['cost'])) {
                $normalized[] = [
                    'service'     => $item['service'],
                    'description' => $item['description'] ?? $item['service'],
                    'cost'        => [['value' => $item['cost'][0]['value'] ?? 0, 'etd' => $item['cost'][0]['etd'] ?? '-']],
                ];
                continue;
            }

            // Format B (Komerce v1)
            if (isset($item['service_code']) || isset($item['service_name'])) {
                $normalized[] = [
                    'service'     => $item['service_code'] ?? $item['service_name'],
                    'description' => $item['service_name'] ?? $item['service_code'],
                    'cost'        => [['value' => $item['price'] ?? $item['cost'] ?? 0, 'etd' => $item['etd'] ?? '-']],
                ];
                continue;
            }

            // Format C (generic)
            if (isset($item['name']) || isset($item['price'])) {
                $normalized[] = [
                    'service'     => $item['name'] ?? $item['code'] ?? 'REG',
                    'description' => $item['description'] ?? $item['name'] ?? 'Reguler',
                    'cost'        => [['value' => $item['price'] ?? $item['cost'] ?? 0, 'etd' => $item['etd'] ?? '-']],
                ];
            }
        }

        return $normalized;
    }

    public function trackWaybill(string $awb, string $courier): array {
        try {
            $r = Http::timeout(15)->withHeaders($this->headers())
                ->post("{$this->baseUrl}/track/waybill", ['awb' => $awb, 'courier' => $courier]);
            if ($r->successful()) return $r->json('data', ['error' => 'Resi tidak ditemukan']);
            return ['error' => 'Gagal melacak resi: ' . $r->status()];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
