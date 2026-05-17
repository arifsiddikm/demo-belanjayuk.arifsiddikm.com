@extends('layouts.app')
@section('title','Pesanan Saya - BelanjaYuk!')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
  <h1 class="text-2xl font-extrabold text-gray-900 mb-6">📋 Pesanan Saya</h1>
  <div class="flex gap-2 overflow-x-auto pb-2 mb-6">
    @foreach([''=>'Semua','menunggu_bayar'=>'Menunggu Bayar','diproses'=>'Diproses','dikirim'=>'Dikirim','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'] as $val=>$label)
    <a href="{{ route('user.orders',$val?['status'=>$val]:[]) }}" class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-semibold transition-colors {{ request('status')===$val?'bg-green-600 text-white':'bg-white border-2 border-gray-200 text-gray-600 hover:border-green-400' }}">{{ $label }}</a>
    @endforeach
  </div>
  <div class="space-y-4">
    @forelse($orders as $order)
    <div class="card overflow-hidden">
      <div class="flex items-center justify-between p-4 border-b border-gray-50 bg-green-50/50">
        <div class="flex items-center gap-3"><span class="font-mono font-bold text-sm text-gray-800">{{ $order->order_number }}</span><span class="badge badge-{{ $order->status_color }}">{{ $order->status_label }}</span></div>
        <div class="text-xs text-gray-400">{{ $order->created_at->format('d M Y H:i') }}</div>
      </div>
      <div class="p-4">
        <div class="flex gap-3 mb-4">
          @foreach($order->items->take(3) as $item)
          <div class="flex items-center gap-2">
            <img src="{{ $item->product_thumbnail&&\Illuminate\Support\Str::startsWith($item->product_thumbnail,'http')?$item->product_thumbnail:($item->product_thumbnail?asset('storage/'.$item->product_thumbnail):'https://via.placeholder.com/48') }}" class="w-12 h-12 object-cover rounded-lg border">
            <div class="text-xs"><p class="font-medium text-gray-800 line-clamp-1 max-w-[100px]">{{ $item->product_name }}</p><p class="text-gray-400">×{{ $item->quantity }}</p></div>
          </div>
          @endforeach
          @if($order->items->count()>3)<div class="w-12 h-12 rounded-lg border bg-gray-100 flex items-center justify-center text-xs text-gray-500 font-bold">+{{ $order->items->count()-3 }}</div>@endif
        </div>
        <div class="flex items-center justify-between">
          <div><p class="text-xs text-gray-400">Total ({{ $order->items->sum('quantity') }} item)</p><p class="font-extrabold text-green-700">Rp {{ number_format($order->total,0,',','.') }}</p></div>
          <a href="{{ route('user.orders.show',$order->order_number) }}" class="btn-primary" style="padding:.55rem 1.25rem;font-size:.875rem">Detail Pesanan</a>
        </div>
      </div>
    </div>
    @empty
    <div class="text-center py-20"><div class="text-6xl mb-4">📭</div><h2 class="text-xl font-bold text-gray-700 mb-2">Belum ada pesanan</h2><a href="{{ route('produk.index') }}" class="btn-primary mt-4">Mulai Belanja</a></div>
    @endforelse
  </div>
</div>
@endsection