@extends('layouts.admin')
@section('title','Kelola Produk')
@section('page-title','Kelola Produk')
@section('content')
<div class="flex flex-wrap gap-3 mb-5">
  <a href="{{ route('admin.products.create') }}" class="btn-primary">+ Tambah Produk</a>
</div>

<div class="card overflow-hidden">
  <div class="p-5 border-b border-orange-50">
    <form method="GET" class="flex flex-wrap gap-3">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="form-input text-sm flex-1 min-w-48">
      <select name="category" class="form-select text-sm w-44">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
      </select>
      <button type="submit" class="btn-primary btn-sm">🔍 Cari</button>
      @if(request()->hasAny(['search','category']))
      <a href="{{ route('admin.products.index') }}" class="btn-outline btn-sm">Reset</a>
      @endif
    </form>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full">
      <thead>
        <tr class="bg-orange-50 text-left">
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @forelse($products as $product)
        <tr class="hover:bg-orange-50 transition-colors">
          <td class="px-4 py-3.5">
            <div class="flex items-center gap-3">
              <img src="{{ $product->thumbnail_url }}" class="w-12 h-12 rounded-lg object-cover border flex-shrink-0" onerror="this.src='https://via.placeholder.com/48?text=No'">
              <div>
                <p class="font-semibold text-sm text-gray-800 max-w-xs truncate">{{ $product->name }}</p>
                <p class="text-xs text-gray-400">{{ $product->sku }}</p>
              </div>
            </div>
          </td>
          <td class="px-4 py-3.5 text-sm text-gray-600">{{ $product->category->name ?? '-' }}</td>
          <td class="px-4 py-3.5">
            <p class="font-bold text-orange-600 text-sm">Rp {{ number_format($product->effective_price,0,',','.') }}</p>
            @if($product->sale_price)
            <p class="text-xs text-gray-400 line-through">Rp {{ number_format($product->price,0,',','.') }}</p>
            @endif
          </td>
          <td class="px-4 py-3.5">
            <span class="font-semibold text-sm {{ $product->stock < 10 ? 'text-red-600' : 'text-gray-800' }}">
              {{ $product->stock }}
            </span>
          </td>
          <td class="px-4 py-3.5">
            <div class="flex flex-wrap gap-1">
              <span class="badge {{ $product->is_active ? 'badge-green' : 'badge-red' }}">{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</span>
              @if($product->is_promo)<span class="badge badge-red">🔥 Promo</span>@endif
              @if($product->is_featured)<span class="badge badge-yellow">⭐ Unggulan</span>@endif
            </div>
          </td>
          <td class="px-4 py-3.5">
            <div class="flex gap-1.5">
              <a href="{{ route('admin.products.edit', $product) }}" class="btn-outline btn-sm">✏️ Edit</a>
              <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirmDelete(event, this)">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger btn-sm">🗑️ Hapus</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="px-4 py-16 text-center text-gray-400">
            <div class="text-4xl mb-3">📦</div>
            <p class="font-medium">Belum ada produk</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($products->hasPages())
  <div class="px-5 py-4 border-t border-orange-50">
    {{ $products->links() }}
  </div>
  @endif
</div>

@push('scripts')
<script>
function confirmDelete(e, form) {
  e.preventDefault();
  Swal.fire({
    title: 'Hapus Produk?',
    text: 'Produk akan dihapus permanen dan tidak bisa dipulihkan!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#f97316',
  }).then(r => { if (r.isConfirmed) form.submit(); });
  return false;
}
</script>
@endpush
@endsection
