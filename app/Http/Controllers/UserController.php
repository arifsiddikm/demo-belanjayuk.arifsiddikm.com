<?php
namespace App\Http\Controllers;
use App\Models\Address;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\Wishlist;
use App\Services\FakeShippingService;
use App\Services\RajaOngkirService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller {
    public function __construct(protected FakeShippingService $fakeShipping) {}

    public function dashboard() {
        $user = Auth::user();
        return view('user.dashboard', [
            'user'           => $user,
            'totalOrders'    => Order::where('user_id',$user->id)->count(),
            'pendingOrders'  => Order::where('user_id',$user->id)->whereIn('status',['menunggu_bayar','diproses'])->count(),
            'completedOrders'=> Order::where('user_id',$user->id)->where('status','selesai')->count(),
            'recentOrders'   => Order::where('user_id',$user->id)->with('items')->latest()->take(5)->get(),
            'wishlistCount'  => Wishlist::where('user_id',$user->id)->count(),
        ]);
    }

    public function orders(Request $request) {
        $query = Order::where('user_id',Auth::id())->with('items')->latest();
        if ($request->status && $request->status !== 'semua') $query->where('status',$request->status);
        return view('user.orders',['orders'=>$query->paginate(10)->withQueryString()]);
    }

    public function orderShow(string $n) {
        $order = Order::where('order_number',$n)->where('user_id',Auth::id())
            ->with(['items.product','paymentConfirmation'])->firstOrFail();
        $reviewedProductIds = ProductReview::where('user_id',Auth::id())
            ->whereIn('product_id', $order->items->pluck('product_id'))
            ->pluck('product_id')->toArray();
        return view('user.order-detail', compact('order','reviewedProductIds'));
    }

    public function orderTrack(string $n) {
        $order = Order::where('order_number',$n)->where('user_id',Auth::id())->firstOrFail();
        if (!$order->tracking_number) return response()->json(['error'=>'Nomor resi belum tersedia']);
        // Coba real dulu, fallback ke fake jika gagal/429
        try {
            $real   = app(RajaOngkirService::class);
            $result = $real->trackWaybill($order->tracking_number, $order->courier);
            if (!isset($result['error']) && !empty($result['manifest'] ?? $result['history'] ?? [])) {
                return response()->json($result);
            }
        } catch (\Exception $e) { Log::info('Track real failed: '.$e->getMessage()); }
        return response()->json($this->fakeShipping->trackWaybill($order->tracking_number, $order->courier));
    }

    public function orderCancel(Request $request, string $n) {
        $order = Order::where('order_number',$n)->where('user_id',Auth::id())->firstOrFail();
        if (!in_array($order->status,['menunggu_bayar','diproses'])) return back()->with('error','Pesanan tidak dapat dibatalkan');
        $request->validate(['cancel_reason'=>'required|string|max:500']);
        foreach ($order->items as $item) { if ($item->product) $item->product->increment('stock',$item->quantity); }
        $order->update(['status'=>'dibatalkan','cancel_reason'=>strip_tags($request->cancel_reason),'cancelled_at'=>now()]);
        return back()->with('success','Pesanan berhasil dibatalkan');
    }

    public function orderReceived(string $n) {
        $order = Order::where('order_number',$n)->where('user_id',Auth::id())->firstOrFail();
        if ($order->status !== 'dikirim') return back()->with('error','Status pesanan tidak valid');
        $order->update(['status'=>'selesai','delivered_at'=>now(),'completed_at'=>now()]);
        foreach ($order->items as $item) {
            if ($item->product) $item->product->increment('sold_count',$item->quantity);
        }
        return back()->with('success','✅ Pesanan dikonfirmasi diterima dan selesai! Jangan lupa berikan ulasan.');
    }

    public function profile()  { return view('user.profile',['user'=>Auth::user()]); }

    public function profileUpdate(Request $request) {
        $user = Auth::user();
        $request->validate(['name'=>'required|string|max:255','phone'=>'nullable|string|max:20','avatar'=>'nullable|image|mimes:jpg,jpeg,png|max:1024']);
        $data = ['name'=>strip_tags($request->name),'phone'=>$request->phone];
        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars','public');
        }
        $user->update($data);
        return back()->with('success','Profil berhasil diperbarui!');
    }

    public function passwordUpdate(Request $request) {
        $request->validate(['current_password'=>'required','password'=>'required|min:6|confirmed']);
        if (!Hash::check($request->current_password, Auth::user()->password)) return back()->withErrors(['current_password'=>'Password lama salah']);
        Auth::user()->update(['password'=>Hash::make($request->password)]);
        return back()->with('success','Password berhasil diperbarui!');
    }

    public function addresses() {
        return view('user.addresses',['addresses'=>Address::where('user_id',Auth::id())->get(),'provinces'=>$this->fakeShipping->getProvinces()]);
    }

    public function addressStore(Request $request) {
        $request->validate(['label'=>'required|string|max:50','recipient_name'=>'required|string|max:255','phone'=>'required|string|max:20','address'=>'required|string','province_id'=>'required','province_name'=>'required','city_id'=>'required','city_name'=>'required']);
        if ($request->boolean('is_default')) Address::where('user_id',Auth::id())->update(['is_default'=>false]);
        Address::create(array_merge($request->only(['label','recipient_name','phone','address','province_id','province_name','city_id','city_name','district_id','district_name','postal_code']),['user_id'=>Auth::id(),'is_default'=>$request->boolean('is_default')]));
        return back()->with('success','Alamat berhasil ditambahkan!');
    }

    public function addressDelete(Address $address) {
        if ($address->user_id !== Auth::id()) abort(403);
        $address->delete();
        return back()->with('success','Alamat dihapus');
    }

    public function wishlist() {
        return view('user.wishlist',['items'=>Wishlist::where('user_id',Auth::id())->with('product.category')->latest()->paginate(12)]);
    }

    public function wishlistToggle(Request $request) {
        if (!Auth::check()) return response()->json(['status'=>'unauthenticated'],401);
        $request->validate(['product_id'=>'required|exists:products,id']);
        $w = Wishlist::where('user_id',Auth::id())->where('product_id',$request->product_id)->first();
        if ($w) { $w->delete(); return response()->json(['status'=>'removed']); }
        Wishlist::create(['user_id'=>Auth::id(),'product_id'=>$request->product_id]);
        return response()->json(['status'=>'added']);
    }

    /**
     * Submit ulasan per produk.
     * FIX: Cek keberadaan kolom 'images' sebelum menyimpan,
     * jika kolom belum ada (belum migrate), skip dulu tanpa error.
     * Solusi permanen: jalankan migration add_images_to_product_reviews
     */
    public function reviewStore(Request $request) {
        $request->validate([
            'order_id'   => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'nullable|string|max:1000',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images.*'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Validasi pesanan milik user dan sudah selesai
        $order = Order::where('id',$request->order_id)
            ->where('user_id',Auth::id())
            ->where('status','selesai')
            ->firstOrFail();

        // Upload gambar tunggal
        $image = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image')->store('reviews','public');
        }

        // Upload multiple images — hanya jika kolom 'images' sudah ada di DB
        $images    = [];
        $hasImgCol = Schema::hasColumn('product_reviews','images');
        if ($hasImgCol && $request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                if ($img && $img->isValid()) {
                    $images[] = $img->store('reviews','public');
                }
            }
        }

        // Data yang akan disimpan
        $reviewData = [
            'rating'      => (int)$request->rating,
            'comment'     => strip_tags($request->comment ?? ''),
            'image'       => $image,
            'is_approved' => true,
        ];

        // Tambahkan kolom images hanya jika ada di skema
        if ($hasImgCol) {
            $reviewData['images'] = !empty($images) ? $images : null;
        }

        ProductReview::updateOrCreate(
            [
                'product_id' => $request->product_id,
                'user_id'    => Auth::id(),
                'order_id'   => $request->order_id,
            ],
            $reviewData
        );

        return back()->with('success','✅ Ulasan berhasil dikirim! Terima kasih.');
    }
}
