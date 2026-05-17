@extends('layouts.app')
@section('title','Pesanan Berhasil! - BelanjaYuk!')
@section('content')
<div class="max-w-lg mx-auto px-4 py-16 text-center">
  <div class="card p-10">
    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5 shadow-lg" style="background:linear-gradient(135deg,#f97316,#ea580c)">
      <i class="fas fa-check text-white text-3xl"></i>
    </div>
    <h1 class="text-2xl font-extrabold mb-2" style="color:#ea580c">Pesanan Berhasil!</h1>
    <p class="text-gray-500 mb-1">Terima kasih telah berbelanja di BelanjaYuk!</p>
    <p class="font-mono font-bold text-lg text-gray-800 mb-6">{{ $order->order_number }}</p>

    <div class="rounded-2xl p-5 text-left text-sm space-y-3 mb-7" style="background:#fff7ed">
      <div class="flex justify-between">
        <span class="text-gray-500">Total</span>
        <span class="font-extrabold text-base" style="color:#f97316">Rp {{ number_format($order->total,0,',','.') }}</span>
      </div>
      <div class="flex justify-between">
        <span class="text-gray-500">Metode Bayar</span>
        <span class="font-medium">{{ $order->payment_method==='midtrans'?'Midtrans':'Transfer Bank' }}</span>
      </div>
      <div class="flex justify-between">
        <span class="text-gray-500">Status</span>
        <span class="badge badge-{{ $order->status_color ?? 'yellow' }}">{{ $order->status_label ?? $order->status }}</span>
      </div>
      <div class="flex justify-between">
        <span class="text-gray-500">Kurir</span>
        <span class="font-medium">{{ strtoupper($order->courier) }} {{ $order->courier_service }}</span>
      </div>
      <div class="flex justify-between">
        <span class="text-gray-500">Tujuan</span>
        <span class="font-medium">{{ $order->city_name }}, {{ $order->province_name }}</span>
      </div>
    </div>

    {{-- Bank Transfer Info - FIX: tidak pakai @foreach di dalam @if, pisah tiap baris --}}
    @if($order->payment_method === 'bank_transfer' && $order->payment_status !== 'paid')
    <div class="rounded-xl p-4 mb-5 text-left text-sm" style="background:#fffbeb;border:1px solid #fde68a">
      <p class="font-semibold text-amber-800 mb-3 flex items-center gap-1.5">
        <i class="fas fa-university text-amber-500"></i> Transfer ke salah satu rekening:
      </p>
      @php
        $settings = \App\Models\StoreSetting::all()->pluck('value','key');
        $bankList  = ['bank_bca' => 'BCA', 'bank_bni' => 'BNI', 'bank_mandiri' => 'Mandiri'];
      @endphp
      @foreach($bankList as $key => $bankName)
        @if(isset($settings[$key]) && $settings[$key])
        <div class="flex items-center gap-2 mb-1.5">
          <span class="font-bold text-amber-800 w-16">{{ $bankName }}</span>
          <span class="font-mono text-amber-700">{{ $settings[$key] }}</span>
        </div>
        @endif
      @endforeach
      <p class="text-amber-600 text-xs mt-3 flex items-center gap-1">
        <i class="fas fa-info-circle"></i>
        Transfer tepat <strong class="mx-1">Rp {{ number_format($order->total,0,',','.') }}</strong>
        lalu upload bukti di detail pesanan
      </p>
    </div>
    @endif

    <div class="flex flex-col gap-2">
      <a href="{{ route('user.orders.show',$order->order_number) }}" class="btn-primary py-3">
        <i class="fas fa-clipboard-list mr-2"></i> Lihat Detail Pesanan
      </a>
      <a href="{{ route('produk.index') }}" class="btn-outline py-2.5">
        <i class="fas fa-shopping-bag mr-2"></i> Lanjut Belanja
      </a>
    </div>
  </div>
</div>
@endsection
