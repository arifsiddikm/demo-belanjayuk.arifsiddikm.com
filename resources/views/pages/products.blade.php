@extends('layouts.app')
@section('title',($currentCategory?$currentCategory->name.' - ':'').'Produk - BelanjaYuk!')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
  <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('home') }}" class="hover:text-green-600">Home</a> › <span class="text-gray-800 font-medium">{{ $currentCategory?$currentCategory->name:'Semua Produk' }}</span>
  </nav>
  <div class="flex gap-6">
    <aside class="w-60 flex-shrink-0 hidden md:block">
      <div class="card p-5 sticky top-24">
        <h3 class="font-bold text-gray-800 mb-4">Filter Produk</h3>
        <div class="mb-5">
          <h4 class="text-sm font-semibold text-gray-600 mb-3 uppercase tracking-wide">Kategori</h4>
          <ul class="space-y-1.5">
            <li><a href="{{ route('produk.index',request()->except('category')) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm {{ !request('category')?'bg-green-100 text-green-700 font-semibold':'text-gray-600 hover:bg-gray-50' }}">Semua Kategori</a></li>
            @foreach($categories as $cat)
            <li><a href="{{ route('produk.index',array_merge(request()->except('category'),['category'=>$cat->slug])) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm {{ request('category')===$cat->slug?'bg-green-100 text-green-700 font-semibold':'text-gray-600 hover:bg-gray-50' }}">
              <span>{{ $cat->icon }} {{ $cat->name }}</span><span class="text-xs bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded-full">{{ $cat->active_products_count }}</span>
            </a></li>
            @endforeach
          </ul>
        </div>
        <div class="mb-5">
          <h4 class="text-sm font-semibold text-gray-600 mb-3 uppercase tracking-wide">Harga</h4>
          <form method="GET" action="{{ route('produk.index') }}">
            @foreach(request()->except(['min_price','max_price']) as $k=>$v)<input type="hidden" name="{{ $k }}" value="{{ $v }}">@endforeach
            <div class="space-y-2">
              <input type="number" name="min_price" placeholder="Min. harga" value="{{ request('min_price') }}" class="form-input text-sm">
              <input type="number" name="max_price" placeholder="Max. harga" value="{{ request('max_price') }}" class="form-input text-sm">
            </div>
            <button type="submit" class="btn-primary w-full mt-3 text-sm py-2">Terapkan</button>
          </form>
        </div>
        <div>
          <h4 class="text-sm font-semibold text-gray-600 mb-3 uppercase tracking-wide">Filter Cepat</h4>
          <div class="space-y-2">
            <a href="{{ route('produk.index',array_merge(request()->all(),['promo'=>1])) }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm {{ request('promo')?'bg-red-50 text-red-700 font-semibold':'text-gray-600 hover:bg-gray-50' }}">🔥 Promo & Diskon</a>
            <a href="{{ route('produk.index',array_merge(request()->all(),['featured'=>1])) }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm {{ request('featured')?'bg-yellow-50 text-yellow-700 font-semibold':'text-gray-600 hover:bg-gray-50' }}">⭐ Produk Unggulan</a>
          </div>
        </div>
      </div>
    </aside>
    <div class="flex-1 min-w-0">
      <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <div><h1 class="text-xl font-bold text-gray-800">{{ $currentCategory?$currentCategory->name:'Semua Produk' }}</h1><p class="text-sm text-gray-500">{{ $products->total() }} produk</p></div>
        <div class="flex items-center gap-3">
          @if(request()->hasAny(['search','category','min_price','max_price','promo','featured']))<a href="{{ route('produk.index') }}" class="text-sm text-red-500 hover:text-red-700">✕ Reset</a>@endif
          <select onchange="const p=new URLSearchParams(window.location.search);p.set('sort',this.value);window.location='{{ route('produk.index') }}?'+p.toString()" class="form-select text-sm py-2 w-40">
            <option value="" {{ !request('sort')?'selected':'' }}>Relevansi</option>
            <option value="newest" {{ request('sort')==='newest'?'selected':'' }}>Terbaru</option>
            <option value="popular" {{ request('sort')==='popular'?'selected':'' }}>Terpopuler</option>
            <option value="price_asc" {{ request('sort')==='price_asc'?'selected':'' }}>Harga: Termurah</option>
            <option value="price_desc" {{ request('sort')==='price_desc'?'selected':'' }}>Harga: Termahal</option>
          </select>
        </div>
      </div>
      @if($products->count())
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($products as $product)@include('components.product-card',['product'=>$product])@endforeach
      </div>
      @if($products->hasPages())
      <div class="mt-8 flex justify-center gap-1.5">
        @if(!$products->onFirstPage())<a href="{{ $products->previousPageUrl() }}" class="pagination-link">‹</a>@endif
        @foreach($products->getUrlRange(max(1,$products->currentPage()-2),min($products->lastPage(),$products->currentPage()+2)) as $page=>$url)
        <a href="{{ $url }}" class="pagination-link {{ $page==$products->currentPage()?'active':'' }}">{{ $page }}</a>
        @endforeach
        @if($products->hasMorePages())<a href="{{ $products->nextPageUrl() }}" class="pagination-link">›</a>@endif
      </div>
      @endif
      @else
      <div class="text-center py-20"><div class="text-6xl mb-4">🔍</div><h3 class="text-xl font-bold text-gray-700 mb-2">Produk tidak ditemukan</h3><a href="{{ route('produk.index') }}" class="btn-primary mt-4">Lihat Semua Produk</a></div>
      @endif
    </div>
  </div>
</div>
@endsection