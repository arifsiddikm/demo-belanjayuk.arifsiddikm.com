<?php
namespace App\Http\Controllers;
use App\Services\FakeShippingService;
use App\Services\RajaOngkirService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckResiController extends Controller {
    public function index() {
        $couriers = [
            ['code' => 'jne',      'name' => 'JNE'],
            ['code' => 'jnt',      'name' => 'J&T Express'],
            ['code' => 'sicepat',  'name' => 'SiCepat'],
            ['code' => 'anteraja', 'name' => 'AnterAja'],
            ['code' => 'pos',      'name' => 'Pos Indonesia'],
            ['code' => 'tiki',     'name' => 'TIKI'],
            ['code' => 'ninja',    'name' => 'Ninja Xpress'],
            ['code' => 'sap',      'name' => 'SAP Express'],
            ['code' => 'lion',     'name' => 'Lion Parcel'],
            ['code' => 'wahana',   'name' => 'Wahana'],
        ];
        return view('pages.cek-resi', compact('couriers'));
    }

    public function track(Request $request) {
        $request->validate(['awb' => 'required|string|max:100', 'courier' => 'required|string']);
        $awb     = trim($request->awb);
        $courier = $request->courier;

        // Coba RajaOngkir real
        try {
            $service = app(RajaOngkirService::class);
            $result  = $service->trackWaybill($awb, $courier);
            if (!isset($result['error'])) return response()->json($result);
            Log::info("RajaOngkir track failed for {$awb}: " . ($result['error'] ?? 'unknown'));
        } catch (\Exception $e) {
            Log::warning("RajaOngkir track exception: " . $e->getMessage());
        }

        // Fallback: dummy tracking
        $fake = new FakeShippingService();
        return response()->json($fake->trackWaybill($awb, $courier));
    }
}
