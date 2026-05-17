<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller {
    public function index() {
        return view('admin.categories.index', [
            'categories' => Category::withCount('products')->orderBy('sort_order')->paginate(20),
        ]);
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string|max:255']);
        $data = $request->only(['name', 'slug', 'icon', 'description', 'sort_order']);
        $data['slug']      = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('categories', 'public');
        Category::create($data);
        return back()->with('success', 'Kategori ditambahkan!');
    }

    public function update(Request $request, Category $category) {
        $data = $request->only(['name', 'slug', 'icon', 'description', 'sort_order']);
        $data['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('categories', 'public');
        $category->update($data);
        return back()->with('success', 'Kategori diperbarui!');
    }

    public function destroy(Category $category) {
        $category->delete();
        return back()->with('success', 'Kategori dihapus');
    }
}
