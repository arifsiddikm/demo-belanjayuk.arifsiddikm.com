@extends('layouts.admin')
@section('title','Kategori')
@section('page-title','Kelola Kategori')
@section('content')
<div class="grid lg:grid-cols-3 gap-6">
  <div class="card p-6">
    <h3 class="font-bold text-gray-800 mb-5">Tambah Kategori</h3>
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf
      <div><label class="form-label">Nama *</label><input type="text" name="name" class="form-input" required></div>
      <div><label class="form-label">Icon Emoji</label><input type="text" name="icon" class="form-input" placeholder="🛍️"></div>
      <div><label class="form-label">Deskripsi</label><textarea name="description" class="form-textarea text-sm" rows="2"></textarea></div>
      <div><label class="form-label">Urutan</label><input type="number" name="sort_order" value="0" class="form-input"></div>
      <div><label class="form-label">Gambar</label><input type="file" name="image" accept="image/*" class="form-input text-sm"></div>
      <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" checked class="form-checkbox"><span class="text-sm font-medium">Aktif</span></label>
      <button type="submit" class="btn-primary w-full">+ Tambah</button>
    </form>
  </div>
  <div class="lg:col-span-2 card overflow-hidden">
    <div class="p-5 border-b border-green-50"><h3 class="font-bold text-gray-800">Daftar Kategori ({{ $categories->total() }})</h3></div>
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead><tr class="bg-green-50 text-left"><th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Kategori</th><th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Produk</th><th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th><th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th></tr></thead>
        <tbody class="divide-y divide-gray-50">
          @foreach($categories as $cat)
          <tr class="hover:bg-green-50 transition-colors">
            <td class="px-4 py-3"><div class="flex items-center gap-3">@if($cat->image)<img src="{{ \Illuminate\Support\Str::startsWith($cat->image,'http')?$cat->image:asset('storage/'.$cat->image) }}" class="w-10 h-10 rounded-xl object-cover border">@endif<div><p class="font-semibold text-sm text-gray-800">{{ $cat->icon }} {{ $cat->name }}</p><p class="text-xs text-gray-400">{{ $cat->slug }}</p></div></div></td>
            <td class="px-4 py-3 text-sm text-gray-600">{{ $cat->products_count }}</td>
            <td class="px-4 py-3"><span class="badge {{ $cat->is_active?'badge-green':'badge-red' }}">{{ $cat->is_active?'Aktif':'Nonaktif' }}</span></td>
            <td class="px-4 py-3"><form action="{{ route('admin.categories.destroy',$cat) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">@csrf @method('DELETE')<button type="submit" class="btn-danger btn-sm">Hapus</button></form></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection