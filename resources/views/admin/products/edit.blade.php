@extends('layouts.admin')
@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk')
@section('page-title', isset($product) ? 'Edit Produk: ' . Str::limit($product->name,40) : 'Tambah Produk Baru')
@section('content')

<form action="{{ isset($product) ? route('admin.products.update',$product) : route('admin.products.store') }}"
  method="POST" enctype="multipart/form-data" id="product-form">
  @csrf
  @if(isset($product)) @method('PUT') @endif

  @if($errors->any())
  <div class="alert-error mb-5">
    <ul class="list-disc list-inside space-y-1 text-sm">
      @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
    </ul>
  </div>
  @endif

  <div class="grid lg:grid-cols-3 gap-6">
    {{-- LEFT: Main Info --}}
    <div class="lg:col-span-2 space-y-5">

      {{-- Informasi Produk --}}
      <div class="card p-6">
        <h3 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
          <span class="w-1 h-5 rounded-full inline-block" style="background:#f97316"></span>
          Informasi Produk
        </h3>
        <div class="space-y-4">
          <div>
            <label class="form-label">Nama Produk *</label>
            <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="form-input" required placeholder="Nama produk lengkap">
          </div>
          <div>
            <label class="form-label">Deskripsi Singkat</label>
            <textarea name="short_description" class="form-textarea text-sm" rows="2" placeholder="Deskripsi singkat 1-2 kalimat...">{{ old('short_description', $product->short_description ?? '') }}</textarea>
          </div>
          <div>
            <label class="form-label">Deskripsi Lengkap</label>
            <textarea id="prod-desc" name="description" class="form-textarea" rows="8">{{ old('description', $product->description ?? '') }}</textarea>
          </div>
        </div>
      </div>

      {{-- Harga & Stok --}}
      <div class="card p-6">
        <h3 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
          <span class="w-1 h-5 rounded-full inline-block" style="background:#f97316"></span>
          Harga & Stok
        </h3>
        <div class="grid sm:grid-cols-2 gap-4">
          <div>
            <label class="form-label">Harga Normal *</label>
            <div class="relative">
              <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-semibold">Rp</span>
              <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" class="form-input pl-10" required min="0" placeholder="0">
            </div>
          </div>
          <div>
            <label class="form-label">Harga Promo <span class="text-gray-400 font-normal">(opsional)</span></label>
            <div class="relative">
              <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-semibold">Rp</span>
              <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price ?? '') }}" class="form-input pl-10" min="0" placeholder="0">
            </div>
          </div>
          <div>
            <label class="form-label">Stok *</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" class="form-input" required min="0">
          </div>
          <div>
            <label class="form-label">SKU</label>
            <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="form-input" placeholder="BY-00001">
          </div>
          <div>
            <label class="form-label">Berat (gram) *</label>
            <input type="number" name="weight" value="{{ old('weight', $product->weight ?? 300) }}" class="form-input" required min="1" step="0.1">
          </div>
        </div>
      </div>

      {{-- Varian --}}
      <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
          <h3 class="font-bold text-gray-800 flex items-center gap-2">
            <span class="w-1 h-5 rounded-full inline-block" style="background:#f97316"></span>
            Varian Produk
          </h3>
          <button type="button" onclick="addVariant()" class="btn-outline btn-sm">+ Tambah Varian</button>
        </div>
        <div id="variants-container" class="space-y-3">
          @if(isset($product) && $product->variants->count())
            @foreach($product->variants as $v)
            <div class="grid grid-cols-4 gap-3 p-3 rounded-xl variant-row" style="background:#fff7ed;border:1px solid #fed7aa">
              <div>
                <label class="form-label text-xs">Nama</label>
                <input type="text" name="variant_name[]" value="{{ $v->name }}" class="form-input text-sm">
              </div>
              <div>
                <label class="form-label text-xs">Nilai</label>
                <input type="text" name="variant_value[]" value="{{ $v->value }}" class="form-input text-sm">
              </div>
              <div>
                <label class="form-label text-xs">+Harga</label>
                <input type="number" name="variant_price[]" value="{{ $v->price_adjustment }}" class="form-input text-sm" min="0">
              </div>
              <div class="relative">
                <label class="form-label text-xs">Stok</label>
                <input type="number" name="variant_stock[]" value="{{ $v->stock }}" class="form-input text-sm" min="0">
                <button type="button" onclick="this.closest('.variant-row').remove()"
                  class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white rounded-full text-xs flex items-center justify-center leading-none">×</button>
              </div>
            </div>
            @endforeach
          @endif
        </div>
      </div>

    </div>

    {{-- RIGHT: Sidebar --}}
    <div class="space-y-5">

      {{-- Kategori & Status --}}
      <div class="card p-5">
        <h3 class="font-bold text-gray-800 mb-4">Kategori & Status</h3>
        <div class="space-y-4">
          <div>
            <label class="form-label">Kategori *</label>
            <select name="category_id" class="form-select" required>
              <option value="">Pilih Kategori</option>
              @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('category_id', isset($product) ? $product->category_id : '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
              @endforeach
            </select>
          </div>

          {{-- Checkboxes - TIDAK menggunakan @foreach untuk menghindari konflik --}}
          <label class="flex items-center gap-2 cursor-pointer py-1">
            <input type="checkbox" name="is_active" value="1" class="form-checkbox"
              {{ old('is_active', isset($product) ? $product->is_active : true) ? 'checked' : '' }}>
            <span class="text-sm font-medium text-gray-700">Produk Aktif</span>
          </label>
          <label class="flex items-center gap-2 cursor-pointer py-1">
            <input type="checkbox" name="is_featured" value="1" class="form-checkbox"
              {{ old('is_featured', isset($product) ? $product->is_featured : false) ? 'checked' : '' }}>
            <span class="text-sm font-medium text-gray-700">⭐ Produk Unggulan</span>
          </label>
          <label class="flex items-center gap-2 cursor-pointer py-1">
            <input type="checkbox" name="is_promo" value="1" class="form-checkbox"
              {{ old('is_promo', isset($product) ? $product->is_promo : false) ? 'checked' : '' }}>
            <span class="text-sm font-medium text-gray-700">🔥 Produk Promo</span>
          </label>
          <label class="flex items-center gap-2 cursor-pointer py-1">
            <input type="checkbox" name="is_new" value="1" class="form-checkbox"
              {{ old('is_new', isset($product) ? $product->is_new : true) ? 'checked' : '' }}>
            <span class="text-sm font-medium text-gray-700">🆕 Produk Baru</span>
          </label>
        </div>
      </div>

      {{-- Foto Utama --}}
      <div class="card p-5">
        <h3 class="font-bold text-gray-800 mb-3">Foto Utama</h3>
        @if(isset($product) && $product->thumbnail)
        <img src="{{ $product->thumbnail_url }}" class="w-full h-44 object-cover rounded-xl mb-3 border" id="tp-current">
        @endif
        <input type="file" name="thumbnail" accept="image/*" class="form-input text-sm"
          onchange="previewThumb(this)">
        <img id="tp" class="hidden w-full h-44 object-cover rounded-xl mt-2 border">
      </div>

      {{-- Foto Tambahan --}}
      <div class="card p-5">
        <h3 class="font-bold text-gray-800 mb-3">Foto Tambahan</h3>
        @if(isset($product) && $product->images->count())
        <div class="flex flex-wrap gap-2 mb-3">
          @foreach($product->images as $img)
          <img src="{{ $img->image_url }}" class="w-14 h-14 object-cover rounded-lg border">
          @endforeach
        </div>
        @endif
        <input type="file" name="images[]" multiple accept="image/*" class="form-input text-sm">
        <p class="text-xs text-gray-400 mt-1">Upload beberapa foto sekaligus (maks. 2MB per foto)</p>
      </div>

      {{-- Action Buttons --}}
      <div class="flex flex-col gap-2">
        <button type="submit" class="btn-primary w-full py-3 text-base">
          {{ isset($product) ? '💾 Simpan Perubahan' : '✅ Tambah Produk' }}
        </button>
        <a href="{{ route('admin.products.index') }}" class="btn-outline w-full py-2.5 text-center">Batal</a>
      </div>

    </div>
  </div>
</form>

@endsection

@push('head-scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
@endpush

@push('scripts')
<script>
// CKEditor
ClassicEditor.create(document.querySelector('#prod-desc'), {
  toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','|','blockQuote','undo','redo']
}).catch(e => console.error(e));

// Preview thumbnail
function previewThumb(input) {
  if (!input.files || !input.files[0]) return;
  const r = new FileReader();
  r.onload = function(e) {
    const p = document.getElementById('tp');
    p.src = e.target.result;
    p.classList.remove('hidden');
    const cur = document.getElementById('tp-current');
    if (cur) cur.classList.add('hidden');
  };
  r.readAsDataURL(input.files[0]);
}

// Add variant row - NO backtick template literal, use string concat to avoid Blade conflict
function addVariant() {
  const c = document.getElementById('variants-container');
  const d = document.createElement('div');
  d.className = 'grid grid-cols-4 gap-3 p-3 rounded-xl variant-row';
  d.style.cssText = 'background:#fff7ed;border:1px solid #fed7aa';

  const html = '<div>'
    + '<label class="form-label text-xs">Nama</label>'
    + '<input type="text" name="variant_name[]" class="form-input text-sm" placeholder="Ukuran">'
    + '</div>'
    + '<div>'
    + '<label class="form-label text-xs">Nilai</label>'
    + '<input type="text" name="variant_value[]" class="form-input text-sm" placeholder="M">'
    + '</div>'
    + '<div>'
    + '<label class="form-label text-xs">+Harga</label>'
    + '<input type="number" name="variant_price[]" class="form-input text-sm" value="0" min="0">'
    + '</div>'
    + '<div class="relative">'
    + '<label class="form-label text-xs">Stok</label>'
    + '<input type="number" name="variant_stock[]" class="form-input text-sm" value="0" min="0">'
    + '<button type="button" onclick="this.closest(\'.variant-row\').remove()" '
    + 'class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white rounded-full text-xs flex items-center justify-center leading-none">×</button>'
    + '</div>';

  d.innerHTML = html;
  c.appendChild(d);
}
</script>
@endpush
