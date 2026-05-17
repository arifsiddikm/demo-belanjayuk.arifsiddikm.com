<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\PaymentConfirmation;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StoreSetting;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller {
    public function index() {
        $totalRevenue=Order::whereIn('status',['selesai','dikirim','diterima'])->sum('total');
        $totalOrders=Order::count();$totalProducts=Product::count();$totalUsers=User::where('role','user')->count();
        $recentOrders=Order::with(['user','items'])->latest()->take(10)->get();
        $pendingPayments=PaymentConfirmation::where('status','pending')->count();
        $orderStats=['menunggu_bayar'=>Order::where('status','menunggu_bayar')->count(),'diproses'=>Order::where('status','diproses')->count(),'dikirim'=>Order::where('status','dikirim')->count(),'selesai'=>Order::where('status','selesai')->count()];
        $monthlyRevenue=[];for($i=5;$i>=0;$i--){$date=now()->subMonths($i);$rev=Order::whereIn('status',['selesai','dikirim','diterima'])->whereYear('created_at',$date->year)->whereMonth('created_at',$date->month)->sum('total');$monthlyRevenue[]=['month'=>$date->format('M Y'),'revenue'=>$rev];}
        return view('admin.dashboard',compact('totalRevenue','totalOrders','totalProducts','totalUsers','recentOrders','pendingPayments','orderStats','monthlyRevenue'));
    }
}

class AdminOrderController extends Controller {
    public function __construct(protected MailService $mailer) {}
    public function index(Request $request) {
        $query=Order::with(['user','items'])->latest();
        if($request->status) $query->where('status',$request->status);
        if($request->search){$s=$request->search;$query->where(fn($q)=>$q->where('order_number','like',"%{$s}%")->orWhereHas('user',fn($q)=>$q->where('name','like',"%{$s}%")));}
        return view('admin.orders.index',['orders'=>$query->paginate(20)->withQueryString()]);
    }
    public function show(string $n) { return view('admin.orders.show',['order'=>Order::where('order_number',$n)->with(['user','items.product','paymentConfirmation'])->firstOrFail()]); }
    public function updateStatus(Request $request,string $n) {
        $request->validate(['status'=>'required|in:menunggu_bayar,diproses,dikirim,diterima,selesai,dibatalkan','tracking_number'=>'nullable|string|max:100']);
        $order=Order::where('order_number',$n)->firstOrFail();
        $data=['status'=>$request->status];
        if($request->status==='dikirim'&&$request->tracking_number){$data['tracking_number']=$request->tracking_number;$data['shipped_at']=now();}
        elseif($request->status==='selesai'){$data['completed_at']=now();foreach($order->items as $i){if($i->product)$i->product->increment('sold_count',$i->quantity);}}
        elseif($request->status==='dibatalkan'){$data['cancelled_at']=now();foreach($order->items as $i){if($i->product)$i->product->increment('stock',$i->quantity);}}
        $order->update($data);
        try{$this->mailer->sendOrderStatusUpdate($order->load('user'));}catch(\Exception $e){Log::warning($e->getMessage());}
        return back()->with('success','Status pesanan diperbarui!');
    }
    public function confirmPayment(Request $request,int $id) {
        $request->validate(['action'=>'required|in:approved,rejected','admin_notes'=>'nullable|string']);
        $c=PaymentConfirmation::with('order')->findOrFail($id);
        $c->update(['status'=>$request->action,'admin_notes'=>$request->admin_notes]);
        if($request->action==='approved') $c->order->update(['payment_status'=>'paid','status'=>'diproses','paid_at'=>now()]);
        return back()->with('success','Konfirmasi pembayaran diperbarui!');
    }
    public function pendingPayments() { return view('admin.orders.pending-payments',['confirmations'=>PaymentConfirmation::with(['order.user'])->where('status','pending')->latest()->paginate(20)]); }
}

class AdminProductController extends Controller {
    public function index(Request $request) {
        $query=Product::with('category');
        if($request->search) $query->where('name','like',"%{$request->search}%");
        if($request->category) $query->where('category_id',$request->category);
        return view('admin.products.index',['products'=>$query->latest()->paginate(20)->withQueryString(),'categories'=>Category::all()]);
    }
    public function create() { return view('admin.products.create',['categories'=>Category::where('is_active',true)->get()]); }
    public function store(Request $request) {
        $request->validate(['name'=>'required|string|max:255','category_id'=>'required|exists:categories,id','price'=>'required|numeric|min:0','stock'=>'required|integer|min:0','weight'=>'required|numeric|min:0','thumbnail'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048']);
        $data=$request->except(['thumbnail','images','_token','variant_name','variant_value','variant_price','variant_stock']);
        $data['slug']=Str::slug($request->name).'-'.Str::random(6);
        $data['is_active']=$request->boolean('is_active');$data['is_featured']=$request->boolean('is_featured');$data['is_promo']=$request->boolean('is_promo');$data['is_new']=$request->boolean('is_new');
        if($request->hasFile('thumbnail')) $data['thumbnail']=$request->file('thumbnail')->store('products','public');
        $product=Product::create($data);
        if($request->hasFile('images')) foreach($request->file('images') as $i=>$img) $product->images()->create(['image'=>$img->store('products','public'),'sort_order'=>$i]);
        if($request->variant_value) foreach($request->variant_value as $i=>$val) if($val) ProductVariant::create(['product_id'=>$product->id,'name'=>$request->variant_name[$i]??'Ukuran','value'=>$val,'price_adjustment'=>$request->variant_price[$i]??0,'stock'=>$request->variant_stock[$i]??0]);
        return redirect()->route('admin.products.index')->with('success','Produk berhasil ditambahkan!');
    }
    public function edit(Product $product) { $product->load(['images','variants']);return view('admin.products.edit',['product'=>$product,'categories'=>Category::where('is_active',true)->get()]); }
    public function update(Request $request,Product $product) {
        $request->validate(['name'=>'required|string|max:255','category_id'=>'required|exists:categories,id','price'=>'required|numeric|min:0','stock'=>'required|integer|min:0','weight'=>'required|numeric|min:0','thumbnail'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048']);
        $data=$request->except(['thumbnail','images','_token','_method']);
        $data['is_active']=$request->boolean('is_active');$data['is_featured']=$request->boolean('is_featured');$data['is_promo']=$request->boolean('is_promo');$data['is_new']=$request->boolean('is_new');
        if($request->hasFile('thumbnail')){if($product->thumbnail&&!Str::startsWith($product->thumbnail,'http'))Storage::disk('public')->delete($product->thumbnail);$data['thumbnail']=$request->file('thumbnail')->store('products','public');}
        $product->update($data);return redirect()->route('admin.products.index')->with('success','Produk berhasil diperbarui!');
    }
    public function destroy(Product $product) {
        if($product->thumbnail&&!Str::startsWith($product->thumbnail,'http')) Storage::disk('public')->delete($product->thumbnail);
        $product->delete();return back()->with('success','Produk dihapus');
    }
}

class AdminUserController extends Controller {
    public function index(Request $request) {
        $query=User::query();
        if($request->search){$s=$request->search;$query->where(fn($q)=>$q->where('name','like',"%{$s}%")->orWhere('email','like',"%{$s}%"));}
        if($request->role) $query->where('role',$request->role);
        return view('admin.users.index',['users'=>$query->latest()->paginate(20)->withQueryString()]);
    }
    public function store(Request $request) {
        $request->validate(['name'=>'required|string|max:255','email'=>'required|email|unique:users','role'=>'required|in:user,admin','password'=>'required|min:6']);
        User::create(['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'role'=>$request->role,'password'=>Hash::make($request->password),'is_active'=>true]);
        return back()->with('success','User ditambahkan!');
    }
    public function toggleStatus(User $user) {
        if($user->id===Auth::id()) return back()->with('error','Tidak bisa nonaktifkan akun sendiri');
        $user->update(['is_active'=>!$user->is_active]);return back()->with('success','Status user diperbarui');
    }
    public function destroy(User $user) {
        if($user->id===Auth::id()) return back()->with('error','Tidak bisa hapus akun sendiri');
        $user->delete();return back()->with('success','User dihapus');
    }
}

class AdminCategoryController extends Controller {
    public function index() { return view('admin.categories.index',['categories'=>Category::withCount('products')->orderBy('sort_order')->paginate(20)]); }
    public function store(Request $request) {
        $request->validate(['name'=>'required|string|max:255']);
        $data=$request->only(['name','slug','icon','description','sort_order']);$data['slug']=$data['slug']?:Str::slug($data['name']);$data['is_active']=$request->boolean('is_active',true);
        if($request->hasFile('image')) $data['image']=$request->file('image')->store('categories','public');
        Category::create($data);return back()->with('success','Kategori ditambahkan!');
    }
    public function update(Request $request,Category $category) {
        $data=$request->only(['name','slug','icon','description','sort_order']);$data['is_active']=$request->boolean('is_active',true);
        if($request->hasFile('image')) $data['image']=$request->file('image')->store('categories','public');
        $category->update($data);return back()->with('success','Kategori diperbarui!');
    }
    public function destroy(Category $category) { $category->delete();return back()->with('success','Kategori dihapus'); }
}

class AdminSettingController extends Controller {
    public function index() { return view('admin.settings.index',['settings'=>StoreSetting::all()->pluck('value','key')]); }
    public function update(Request $request) {
        foreach($request->except(['_token','_method']) as $key=>$value) StoreSetting::set($key,$value);
        return back()->with('success','Pengaturan disimpan!');
    }
}

class AdminReportController extends Controller {
    public function index(Request $request) {
        $startDate=$request->start_date?\Carbon\Carbon::parse($request->start_date):now()->startOfMonth();
        $endDate=$request->end_date?\Carbon\Carbon::parse($request->end_date):now()->endOfMonth();
        $orders=Order::whereBetween('created_at',[$startDate,$endDate])->with(['user','items'])->whereIn('status',['selesai','dikirim','diterima','diproses'])->latest()->paginate(20)->withQueryString();
        $totalRevenue=Order::whereBetween('created_at',[$startDate,$endDate])->whereIn('status',['selesai','dikirim','diterima'])->sum('total');
        return view('admin.reports.index',compact('orders','totalRevenue','startDate','endDate'));
    }
}
