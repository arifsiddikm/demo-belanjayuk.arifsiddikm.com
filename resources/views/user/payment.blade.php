@extends('layouts.app')
@section('title','Pembayaran - BelanjaYuk!')
@section('content')
<div class="max-w-lg mx-auto px-4 py-16 text-center">
  <div class="card p-10">
    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5"><svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg></div>
    <h1 class="text-2xl font-extrabold text-gray-900 mb-2">Selesaikan Pembayaran</h1>
    <p class="text-gray-500 text-sm mb-1">Pesanan <strong class="font-mono text-gray-800">{{ $order->order_number }}</strong></p>
    <p class="text-3xl font-extrabold text-green-700 mb-7">Rp {{ number_format($order->total,0,',','.') }}</p>
    <button id="pay-btn" onclick="openSnap()" class="btn-primary w-full py-4 text-lg mb-4">💳 Bayar Sekarang</button>
    <p class="text-xs text-gray-400 mb-5">Aman & terenkripsi · Powered by Midtrans</p>
    <div class="text-left text-sm space-y-2 border-t border-gray-100 pt-5">
      @foreach($order->items as $item)<div class="flex justify-between text-gray-600"><span class="truncate max-w-xs">{{ $item->product_name }} ×{{ $item->quantity }}</span><span class="font-medium">Rp {{ number_format($item->subtotal,0,',','.') }}</span></div>@endforeach
      <div class="flex justify-between text-gray-600 border-t pt-2"><span>Ongkos Kirim</span><span>Rp {{ number_format($order->shipping_cost,0,',','.') }}</span></div>
      @if($order->discount>0)<div class="flex justify-between text-green-600"><span>Diskon</span><span>-Rp {{ number_format($order->discount,0,',','.') }}</span></div>@endif
    </div>
    <div class="mt-5 text-xs text-gray-400">Butuh bantuan? <a href="https://wa.me/{{ env('ADMIN_WHATSAPP') }}" class="text-green-600 font-semibold">Chat WA Admin</a></div>
  </div>
</div>
@endsection
@push('head-scripts')
<script src="{{ $snapJsUrl }}" data-client-key="{{ $clientKey }}"></script>
@endpush
@push('scripts')
<script>
function openSnap(){
  const btn=document.getElementById('pay-btn');btn.disabled=true;btn.textContent='Membuka gateway...';
  snap.pay('{{ $order->midtrans_snap_token }}',{
    onSuccess:()=>window.location.href='{{ route("checkout.success",$order->order_number) }}',
    onPending:()=>{Swal.fire({icon:'info',title:'Menunggu Pembayaran',text:'Selesaikan pembayaran sesuai instruksi.',confirmButtonColor:'#22c55e'}).then(()=>window.location.href='{{ route("user.orders.show",$order->order_number) }}');},
    onError:()=>{Swal.fire({icon:'error',title:'Pembayaran Gagal',text:'Silakan coba lagi.',confirmButtonColor:'#22c55e'});btn.disabled=false;btn.textContent='💳 Bayar Sekarang';},
    onClose:()=>{btn.disabled=false;btn.textContent='💳 Bayar Sekarang';}
  });
}
</script>
@endpush