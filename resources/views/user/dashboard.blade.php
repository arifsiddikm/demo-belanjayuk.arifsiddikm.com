@extends('layouts.app')
@section('title','Dashboard - BelanjaYuk!')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
  <div class="flex items-center gap-4 mb-8">
    <img src="{{ Auth::user()->avatar_url }}" class="w-16 h-16 rounded-full border-4 border-green-200 object-cover">
    <div><h1 class="text-2xl font-extrabold text-gray-900">Halo, {{ Auth::user()->name }}! 👋</h1><p class="text-gray-500">Selamat datang di dashboard BelanjaYuk!</p></div>
  </div>
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    @foreach([['📦','Total Pesanan',$totalOrders],['⏳','Diproses',$pendingOrders],['✅','Selesai',$completedOrders],['❤️','Wishlist',$wishlistCount]] as [$icon,$label,$val])
    <div class="card p-5 text-center"><div class="text-3xl mb-2">{{ $icon }}</div><p class="text-2xl font-extrabold text-gray-800">{{ $val }}</p><p class="text-sm text-gray-500">{{ $label }}</p></div>
    @endforeach
  </div>
  <div class="grid sm:grid-cols-4 gap-3 mb-8">
    @foreach([[route('user.orders'),'📋','Pesanan'],[route('user.wishlist'),'❤️','Wishlist'],[route('user.addresses'),'📍','Alamat'],[route('user.profile'),'👤','Profil']] as [$url,$icon,$label])
    <a href="{{ $url }}" class="card p-4 flex flex-col items-center gap-2 hover:shadow-md transition-shadow card-hover"><span class="text-2xl">{{ $icon }}</span><span class="text-sm font-semibold text-gray-700">{{ $label }}</span></a>
    @endforeach
  </div>
  <div class="card overflow-hidden">
    <div class="flex items-center justify-between p-5 border-b border-green-50"><h2 class="font-bold text-gray-800">Pesanan Terbaru</h2><a href="{{ route('user.orders') }}" class="text-sm text-green-600 font-semibold">Lihat Semua →</a></div>
    @forelse($recentOrders as $order)
    <div class="flex items-center gap-4 p-5 border-b border-gray-50 last:border-0 hover:bg-green-50 transition-colors">
      <div class="flex -space-x-2 flex-shrink-0">@foreach($order->items->take(3) as $item)<img src="{{ $item->product_thumbnail&&\Illuminate\Support\Str::startsWith($item->product_thumbnail,'http')?$item->product_thumbnail:($item->product_thumbnail?asset('storage/'.$item->product_thumbnail):'https://via.placeholder.com/40') }}" class="w-10 h-10 rounded-lg border-2 border-white object-cover">@endforeach</div>
      <div class="flex-1 min-w-0"><p class="font-mono font-bold text-sm text-gray-800">{{ $order->order_number }}</p><p class="text-xs text-gray-400">{{ $order->items->count() }} item · {{ $order->created_at->diffForHumans() }}</p></div>
      <div class="text-right"><p class="font-bold text-green-700 text-sm">Rp {{ number_format($order->total,0,',','.') }}</p><span class="badge badge-{{ $order->status_color }} text-xs">{{ $order->status_label }}</span></div>
      <a href="{{ route('user.orders.show',$order->order_number) }}" class="btn-outline" style="padding:.4rem .875rem;font-size:.8rem">Detail</a>
    </div>
    @empty
    <div class="p-12 text-center text-gray-400"><div class="text-4xl mb-2">📭</div><p>Belum ada pesanan</p><a href="{{ route('produk.index') }}" class="btn-primary mt-3" style="padding:.55rem 1.25rem;font-size:.875rem;display:inline-flex">Mulai Belanja</a></div>
    @endforelse
  </div>
</div>
@endsection