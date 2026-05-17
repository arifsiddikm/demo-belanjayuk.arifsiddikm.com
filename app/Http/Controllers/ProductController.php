<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller {
    public function index(Request $request) {
        $query=Product::active()->with('category');
        if($request->search){$s=$request->search;$query->where(fn($q)=>$q->where('name','like',"%{$s}%")->orWhere('short_description','like',"%{$s}%"));}
        if($request->category) $query->whereHas('category',fn($q)=>$q->where('slug',$request->category));
        if($request->min_price) $query->where(fn($q)=>$q->where('sale_price','>=',$request->min_price)->orWhere(fn($q2)=>$q2->whereNull('sale_price')->where('price','>=',$request->min_price)));
        if($request->max_price) $query->where(fn($q)=>$q->where('sale_price','<=',$request->max_price)->orWhere(fn($q2)=>$q2->whereNull('sale_price')->where('price','<=',$request->max_price)));
        if($request->promo) $query->promo();
        if($request->featured) $query->featured();
        switch($request->sort){
            case 'price_asc': $query->orderByRaw('COALESCE(sale_price,price) ASC');break;
            case 'price_desc': $query->orderByRaw('COALESCE(sale_price,price) DESC');break;
            case 'newest': $query->latest();break;
            case 'popular': $query->orderBy('sold_count','desc');break;
            default: $query->orderBy('is_featured','desc')->latest();
        }
        $products=       $query->paginate(20)->withQueryString();
        $categories=     Category::where('is_active',true)->withCount('activeProducts')->get();
        $currentCategory=$request->category?Category::where('slug',$request->category)->first():null;
        return view('pages.products',compact('products','categories','currentCategory'));
    }
    public function show(string $slug) {
        $product=Product::active()->with(['category','images','variants','reviews.user'])->where('slug',$slug)->firstOrFail();
        $product->increment('views');
        $relatedProducts=Product::active()->where('category_id',$product->category_id)->where('id','!=',$product->id)->inRandomOrder()->take(8)->get();
        $inWishlist=Auth::check()?Wishlist::where('user_id',Auth::id())->where('product_id',$product->id)->exists():false;
        return view('pages.product-detail',compact('product','relatedProducts','inWishlist'));
    }
    public function search(Request $request) { return redirect()->route('produk.index',['search'=>$request->q]); }
    public function category(string $slug) { Category::where('slug',$slug)->where('is_active',true)->firstOrFail();return redirect()->route('produk.index',['category'=>$slug]); }
}
