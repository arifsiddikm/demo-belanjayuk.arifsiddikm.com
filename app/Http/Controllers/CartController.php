<?php
namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller {

    public function index() {
        $cartItems = Cart::where('user_id', Auth::id())->with(['product','variant'])->get();
        return view('user.cart', ['cartItems' => $cartItems, 'total' => $cartItems->sum('subtotal')]);
    }

    public function add(Request $request) {
        $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'required|integer|min:1|max:100', 'product_variant_id' => 'nullable|exists:product_variants,id']);
        $product = Product::active()->findOrFail($request->product_id);
        if ($product->stock < $request->quantity) return back()->with('error', 'Stok tidak mencukupi!');
        $cart = Cart::where('user_id', Auth::id())->where('product_id', $request->product_id)->where('product_variant_id', $request->product_variant_id)->first();
        if ($cart) $cart->increment('quantity', $request->quantity);
        else Cart::create(['user_id' => Auth::id(), 'product_id' => $request->product_id, 'product_variant_id' => $request->product_variant_id, 'quantity' => $request->quantity]);
        if ($request->redirect_checkout) return redirect()->route('checkout.index');
        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart) {
        if ($cart->user_id !== Auth::id()) abort(403);
        $request->validate(['quantity' => 'required|integer|min:1|max:100']);
        $cart->update(['quantity' => $request->quantity]);
        return response()->json(['success' => true, 'subtotal' => $cart->subtotal]);
    }

    public function remove(Cart $cart) {
        if ($cart->user_id !== Auth::id()) abort(403);
        $cart->delete();
        return back()->with('success', 'Item dihapus');
    }

    public function applyCoupon(Request $request) {
        $coupon = Coupon::where('code', strtoupper($request->coupon_code))->first();
        if (!$coupon || !$coupon->isValid()) return response()->json(['success' => false, 'message' => 'Kode kupon tidak valid']);
        $subtotal = Cart::where('user_id', Auth::id())->with('product')->get()->sum('subtotal');
        if ($subtotal < $coupon->min_purchase) return response()->json(['success' => false, 'message' => 'Min. pembelian Rp ' . number_format($coupon->min_purchase, 0, ',', '.')]);
        $discount = $coupon->calculateDiscount($subtotal);
        session(['coupon_code' => $coupon->code, 'coupon_discount' => $discount]);
        return response()->json(['success' => true, 'message' => 'Kupon berhasil! Hemat Rp ' . number_format($discount, 0, ',', '.'), 'discount' => $discount, 'discount_formatted' => 'Rp ' . number_format($discount, 0, ',', '.')]);
    }

    /**
     * FIX: count() bukan sum('quantity')
     * Badge menampilkan jumlah ITEM berbeda di keranjang, bukan total qty.
     * Contoh: 1 produk qty 10 = badge angka 1
     */
    public function getCount() {
        return response()->json([
            'count' => Auth::check() ? Cart::where('user_id', Auth::id())->count() : 0,
        ]);
    }
}
