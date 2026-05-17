<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\FakeShippingService;
use App\Services\RajaOngkirService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * RajaOngkirController
 * Pakai FakeShippingService sebagai primary (selalu tersedia)
 * Coba RajaOngkir real sebagai opsional jika konfigurasi ada
 *
 * Kenapa 422 error di cek resi:
 * - RajaOngkir Komerce API butuh format AWB yang valid
 * - Error 422 = Unprocessable Entity, biasanya berarti format AWB tidak dikenali
 * - Solusi: pakai FakeShippingService untuk demo
 */
class RajaOngkirController extends Controller {
    protected FakeShippingService $fake;
    protected ?RajaOngkirService $real;

    public function __construct() {
        $this->fake = new FakeShippingService();
        $this->real = null;
        // Coba init real service jika ada API key
        try {
            if (config('services.rajaongkir.api_key') || env('RAJAONGKIR_API_KEY')) {
                $this->real = app(RajaOngkirService::class);
            }
        } catch (\Exception $e) {
            Log::warning('RajaOngkir init: ' . $e->getMessage());
        }
    }

    public function provinces() {
        // Coba API real, fallback ke fake
        if ($this->real) {
            try {
                $data = $this->real->getProvinces();
                if (!empty($data)) return response()->json(['data' => $this->sortFormat($data, 'province')]);
            } catch (\Exception $e) { Log::warning('RajaOngkir provinces: '.$e->getMessage()); }
        }
        return response()->json(['data' => $this->fake->getProvinces()]);
    }

    public function cities(string $provinceId) {
        if ($this->real) {
            try {
                $data = $this->real->getCities($provinceId);
                if (!empty($data)) return response()->json(['data' => $this->sortFormat($data, 'city')]);
            } catch (\Exception $e) { Log::warning('RajaOngkir cities: '.$e->getMessage()); }
        }
        return response()->json(['data' => $this->fake->getCities($provinceId)]);
    }

    public function districts(string $cityId) {
        if ($this->real) {
            try {
                $data = $this->real->getDistricts($cityId);
                if (!empty($data)) return response()->json(['data' => $this->sortFormat($data, 'district')]);
            } catch (\Exception $e) { Log::warning('RajaOngkir districts: '.$e->getMessage()); }
        }
        return response()->json(['data' => $this->fake->getDistricts($cityId)]);
    }

    public function cost(Request $request) {
        $origin      = $request->origin ?? config('services.rajaongkir.origin_city', '17');
        $destination = $request->destination;
        $weight      = max(100, (int)$request->weight);
        $courier     = $request->courier;

        // Coba API real dulu
        if ($this->real && $destination) {
            try {
                $data = $this->real->calculateCost($origin, $destination, $weight, $courier);
                if (!empty($data)) return response()->json(['data' => $data]);
            } catch (\Exception $e) { Log::warning('RajaOngkir cost: '.$e->getMessage()); }
        }

        // Fallback: fake shipping
        // Ekstrak province_id dari destination string (format: "provinceId" atau "cityId")
        $provinceId = strlen($destination) <= 2 ? $destination : substr($destination, 0, 1);
        $data = $this->fake->calculateCost($origin, $provinceId, $weight, $courier);
        return response()->json(['data' => $data]);
    }

    public function track(Request $request) {
        $awb     = $request->awb;
        $courier = $request->courier;

        // Coba API real dulu
        if ($this->real && $awb) {
            try {
                $data = $this->real->trackWaybill($awb, $courier);
                if (!isset($data['error'])) return response()->json($data);
                Log::warning('RajaOngkir track error: ' . ($data['error'] ?? 'unknown'));
            } catch (\Exception $e) { Log::warning('RajaOngkir track exception: '.$e->getMessage()); }
        }

        // Fallback: fake tracking
        return response()->json($this->fake->trackWaybill($awb, $courier));
    }

    protected function sortFormat(array $data, string $type): array {
        $keyMap = ['province' => 'province', 'city' => 'city_name', 'district' => 'subdistrict_name'];
        $key = $keyMap[$type] ?? 'name';
        return collect($data)->map(fn($item) => array_merge($item, [$key => ucwords(strtolower($item[$key] ?? ''))]))
            ->sortBy($key)->values()->toArray();
    }
}
