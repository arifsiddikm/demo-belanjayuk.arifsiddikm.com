<?php
namespace App\Http\Controllers;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentConfirmation;
use App\Models\StoreSetting;
use App\Services\FakeShippingService;
use App\Services\MidtransService;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller {
    // Middleware sudah di route group (Laravel 11)
    public function __construct(
        protected MidtransService $midtrans,
        protected FakeShippingService $shipping,  // pakai FakeShippingService sebagai primary
        protected MailService $mailer
    ) {}

    public function index() {
        $cartItems = Cart::where('user_id', Auth::id())->with(['product','variant'])->get();
        if ($cartItems->isEmpty()) return redirect()->route('cart.index')->with('error','Keranjang kosong!');
        $addresses      = Address::where('user_id', Auth::id())->get();
        $provinces      = $this->shipping->getProvinces(); // sorted ascending, ucwords
        $subtotal       = $cartItems->sum('subtotal');
        $couponDiscount = session('coupon_discount', 0);
        $couponCode     = session('coupon_code', null);

        // Info berat total
        $totalWeight = $cartItems->sum(fn($i) => ($i->product->weight ?? 300) * $i->quantity);
        $originCity  = 'Cilegon, Banten';

        return view('user.checkout', compact('cartItems','addresses','provinces','subtotal','couponDiscount','couponCode','totalWeight','originCity'));
    }

    /**
     * GET /checkout/shipping-cost
     * Pakai FakeShippingService — selalu berhasil
     */
    public function getShippingCost(Request $request) {
        $request->validate(['destination'=>'required|string','courier'=>'required|string']);

        $origin    = StoreSetting::get('shipping_origin_city', '17'); // 17 = Cilegon
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        $weight    = max((int)$cartItems->sum(fn($i) => ($i->product->weight ?? 300) * $i->quantity), 100);
        $courier   = strtolower($request->courier);

        $data = $this->shipping->calculateCost($origin, $request->destination, $weight, $courier);

        // Include info berat dan asal
        return response()->json([
            'data'         => $data,
            'weight_gram'  => $weight,
            'weight_kg'    => round($weight / 1000, 2),
            'origin_city'  => 'Cilegon, Banten',
            'destination'  => $request->destination,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'recipient_name'    => 'required|string|max:255',
            'recipient_phone'   => 'required|string|max:20',
            'recipient_address' => 'required|string',
            'province_id'       => 'required',
            'province_name'     => 'required',
            'city_id'           => 'required',
            'city_name'         => 'required',
            'courier'           => 'required|string',
            'courier_service'   => 'required|string',
            'shipping_cost'     => 'required|integer|min:0',
            'payment_method'    => 'required|in:bank_transfer,midtrans',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with(['product','variant'])->get();
        if ($cartItems->isEmpty()) return redirect()->route('cart.index')->with('error','Keranjang kosong!');

        foreach ($cartItems as $item) {
            if (!$item->product || !$item->product->is_active) return back()->with('error','Produk tidak tersedia.');
            if ($item->product->stock < $item->quantity) return back()->with('error',"Stok {$item->product->name} tidak mencukupi.");
        }

        $subtotal       = $cartItems->sum('subtotal');
        $couponDiscount = 0;
        $couponCode     = null;

        if (session('coupon_code')) {
            $coupon = Coupon::where('code', session('coupon_code'))->first();
            if ($coupon && $coupon->isValid()) {
                $couponDiscount = $coupon->calculateDiscount($subtotal);
                $couponCode     = $coupon->code;
                $coupon->increment('used_count');
            }
            session()->forget(['coupon_code','coupon_discount']);
        }

        $total = max(0, $subtotal + $request->shipping_cost - $couponDiscount);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_number'         => Order::generateOrderNumber(),
                'user_id'              => Auth::id(),
                'recipient_name'       => strip_tags($request->recipient_name),
                'recipient_phone'      => $request->recipient_phone,
                'recipient_address'    => strip_tags($request->recipient_address),
                'province_name'        => $request->province_name,
                'city_name'            => $request->city_name,
                'district_name'        => $request->district_name,
                'postal_code'          => $request->postal_code,
                'courier'              => $request->courier,
                'courier_service'      => $request->courier_service,
                'courier_service_name' => $request->courier_service_name ?? strtoupper($request->courier).' '.$request->courier_service,
                'shipping_cost'        => $request->shipping_cost,
                'estimated_days'       => $request->estimated_days,
                'subtotal'             => $subtotal,
                'discount'             => $couponDiscount,
                'coupon_code'          => $couponCode,
                'total'                => $total,
                'payment_method'       => $request->payment_method,
                'payment_status'       => 'pending',
                'status'               => 'menunggu_bayar',
                'notes'                => strip_tags($request->notes ?? ''),
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_id'         => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'product_name'       => $item->product->name,
                    'product_thumbnail'  => $item->product->thumbnail,
                    'variant_info'       => $item->variant ? $item->variant->name.': '.$item->variant->value : null,
                    'quantity'           => $item->quantity,
                    'price'              => $item->product->effective_price + ($item->variant?->price_adjustment ?? 0),
                    'subtotal'           => $item->subtotal,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }

            Cart::where('user_id', Auth::id())->delete();
            DB::commit();

            try { $this->mailer->sendOrderConfirmation($order->load(['items','user'])); } catch (\Exception $e) { Log::warning('Email: '.$e->getMessage()); }
            try { $this->mailer->notifyAdminNewOrder($order); } catch (\Exception $e) { Log::warning('Admin email: '.$e->getMessage()); }

            return $request->payment_method === 'midtrans'
                ? redirect()->route('checkout.payment', $order->order_number)
                : redirect()->route('checkout.success', $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout: '.$e->getMessage());
            return back()->with('error','Terjadi kesalahan. Coba lagi.');
        }
    }

    public function payment(string $orderNumber) {
        $order = Order::where('order_number', $orderNumber)->where('user_id', Auth::id())->with('items')->firstOrFail();
        if ($order->payment_status === 'paid') return redirect()->route('checkout.success', $order->order_number);
        if (!$order->midtrans_snap_token) {
            $result = $this->midtrans->getSnapToken([
                'order_id'    => $order->order_number,
                'total_harga' => (int)$order->total,
                'nama'        => Auth::user()->name,
                'email'       => Auth::user()->email,
                'notelp'      => Auth::user()->phone ?? '0',
                'namaproduk'  => $order->items->pluck('product_name')->take(2)->implode(', '),
            ]);
            if ($result['status'] ?? false) $order->update(['midtrans_snap_token' => $result['snaptoken']]);
            else return redirect()->route('user.orders.show', $order->order_number)->with('error','Gagal membuat token: '.($result['message'] ?? 'Error'));
        }
        return view('user.payment', ['order'=>$order,'snapJsUrl'=>$this->midtrans->getSnapJsUrl(),'clientKey'=>$this->midtrans->getClientKey()]);
    }

    public function midtransCallback(Request $request) {
        $key = $request->header('X-Callback-Key') ?? $request->input('callback_key');
        if (!$this->midtrans->verifyCallbackKey($key)) return response()->json(['status'=>'error'], 401);
        $order = Order::where('order_number', $request->order_id)->first();
        if (!$order) return response()->json(['status'=>'error'], 404);
        $s = $request->transaction_status;
        $f = $request->fraud_status ?? 'accept';
        if (in_array($s,['capture','settlement']) && $f === 'accept')
            $order->update(['payment_status'=>'paid','status'=>'diproses','paid_at'=>now()]);
        elseif (in_array($s,['cancel','deny','expire']))
            $order->update(['payment_status'=>'failed']);
        $order->update(['midtrans_transaction_id'=>$request->transaction_id,'midtrans_response'=>json_encode($request->all())]);
        return response()->json(['status'=>'ok']);
    }

    public function success(string $orderNumber) {
        $order = Order::where('order_number', $orderNumber)->where('user_id', Auth::id())->with('items')->firstOrFail();
        return view('user.checkout-success', compact('order'));
    }

    public function uploadProof(Request $request, string $orderNumber) {
        $request->validate(['payment_proof'=>'required|image|mimes:jpg,jpeg,png|max:2048','bank_name'=>'required|string','account_name'=>'required|string','account_number'=>'required|string','amount'=>'required|numeric']);
        $order = Order::where('order_number', $orderNumber)->where('user_id', Auth::id())->firstOrFail();
        $path  = $request->file('payment_proof')->store('payment_proofs', 'public');
        $order->update(['payment_proof'=>$path]);
        PaymentConfirmation::create(['order_id'=>$order->id,'user_id'=>Auth::id(),'bank_name'=>$request->bank_name,'account_name'=>$request->account_name,'account_number'=>$request->account_number,'amount'=>$request->amount,'transfer_proof'=>$path,'status'=>'pending']);
        try { $this->mailer->notifyAdminPaymentProof($order); } catch (\Exception $e) { Log::warning($e->getMessage()); }
        return back()->with('success','Bukti transfer berhasil dikirim!');
    }
}
