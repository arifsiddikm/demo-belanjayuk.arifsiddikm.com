<?php
namespace App\Http\Controllers;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;

class HomeController extends Controller {
    public function index() {
        $banners          = Banner::where('is_active', true)->orderBy('sort_order')->get();
        $categories       = Category::where('is_active', true)->orderBy('sort_order')->withCount(['activeProducts'])->get();
        // Featured: 30 produk untuk homepage load lebih banyak
        $featuredProducts = Product::active()->featured()->with(['category','reviews'])->inRandomOrder()->take(30)->get();
        // Flash sale: promo dengan diskon
        $flashSaleProducts = Product::active()->promo()->with(['category','reviews'])->inRandomOrder()->take(10)->get();
        $promoProducts    = Product::active()->promo()->with(['category','reviews'])->inRandomOrder()->take(8)->get();
        $newProducts      = Product::active()->where('is_new', true)->with(['category','reviews'])->latest()->take(8)->get();
        $bestSellers      = Product::active()->orderBy('sold_count', 'desc')->with(['category','reviews'])->take(10)->get();
        $latestReviews    = ProductReview::with(['user','product'])->where('is_approved', true)->latest()->take(6)->get();

        return view('pages.home', compact(
            'banners','categories','featuredProducts','flashSaleProducts',
            'promoProducts','newProducts','bestSellers','latestReviews'
        ));
    }
}
