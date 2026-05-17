@extends('layouts.app')
@section('title','Wishlist Saya - BelanjaYuk!')
@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
  <div class="flex items-center justify-between mb-7">
    <h1 class="text-2xl font-extrabold text-gray-900">❤️ Wishlist Saya</h1>
    @if(!$items->isEmpty())
    <span class="text-sm text-gray-400">{{ $items->total() }} produk tersimpan</span>
    @endif
  </div>

  @if($items->isEmpty())
  <div class="text-center py-24">
    <div class="text-7xl mb-5">💔</div>
    <h2 class="text-xl font-bold text-gray-700 mb-2">Wishlist masih kosong</h2>
    <p class="text-gray-400 mb-6">Simpan produk favoritmu dengan menekan tombol ❤️ di halaman produk</p>
    <a href="{{ route('produk.index') }}" class="btn-primary px-8 py-3 text-base">Jelajahi Produk</a>
  </div>
  @else
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
    @foreach($items as $item)
      @if($item->product)
        @include('components.product-card', ['product' => $item->product])
      @endif
    @endforeach
  </div>

  @if($items->hasPages())
  <div class="mt-8 flex justify-center gap-1.5">
    @if(!$items->onFirstPage())
    <a href="{{ $items->previousPageUrl() }}" class="pagination-link">‹</a>
    @endif

    @foreach($items->getUrlRange(max(1, $items->currentPage()-2), min($items->lastPage(), $items->currentPage()+2)) as $p => $url)
    <a href="{{ $url }}" class="pagination-link {{ $p == $items->currentPage() ? 'active' : '' }}">{{ $p }}</a>
    @endforeach

    @if($items->hasMorePages())
    <a href="{{ $items->nextPageUrl() }}" class="pagination-link">›</a>
    @endif
  </div>
  @endif
  @endif
</div>
@endsection
