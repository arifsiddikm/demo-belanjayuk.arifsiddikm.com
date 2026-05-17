<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller {
    public function index(Request $request) {
        $query = Product::with('category');
        if ($request->search) $query->where('name', 'like', "%{$request->search}%");
        if ($request->category) $query->where('category_id', $request->category);
        return view('admin.products.index', [
            'products'   => $query->latest()->paginate(20)->withQueryString(),
            'categories' => Category::all(),
        ]);
    }

    public function create() {
        return view('admin.products.create', ['categories' => Category::where('is_active', true)->get()]);
    }

    public function store(Request $request) {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'weight'      => 'required|numeric|min:0',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        $data = $request->except(['thumbnail', 'images', '_token', 'variant_name', 'variant_value', 'variant_price', 'variant_stock']);
        $data['slug'] = Str::slug($request->name) . '-' . Str::random(6);
        $data['is_active']   = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_promo']    = $request->boolean('is_promo');
        $data['is_new']      = $request->boolean('is_new');
        if ($request->hasFile('thumbnail')) $data['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        $product = Product::create($data);
        if ($request->hasFile('images'))
            foreach ($request->file('images') as $i => $img)
                $product->images()->create(['image' => $img->store('products', 'public'), 'sort_order' => $i]);
        if ($request->variant_value)
            foreach ($request->variant_value as $i => $val)
                if ($val) ProductVariant::create([
                    'product_id'       => $product->id,
                    'name'             => $request->variant_name[$i] ?? 'Ukuran',
                    'value'            => $val,
                    'price_adjustment' => $request->variant_price[$i] ?? 0,
                    'stock'            => $request->variant_stock[$i] ?? 0,
                ]);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product) {
        $product->load(['images', 'variants']);
        return view('admin.products.edit', ['product' => $product, 'categories' => Category::where('is_active', true)->get()]);
    }

    public function update(Request $request, Product $product) {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'weight'      => 'required|numeric|min:0',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        $data = $request->except(['thumbnail', 'images', '_token', '_method']);
        $data['is_active']   = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_promo']    = $request->boolean('is_promo');
        $data['is_new']      = $request->boolean('is_new');
        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail && !Str::startsWith($product->thumbnail, 'http'))
                Storage::disk('public')->delete($product->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        }
        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product) {
        if ($product->thumbnail && !Str::startsWith($product->thumbnail, 'http'))
            Storage::disk('public')->delete($product->thumbnail);
        $product->delete();
        return back()->with('success', 'Produk dihapus');
    }
}
