@extends('layouts.admin')
@section('title','Konfirmasi Pembayaran')
@section('page-title','Konfirmasi Pembayaran')
@section('content')
<div class="space-y-5">
  @forelse($confirmations as $conf)
  <div class="card p-6">
    <div class="flex flex-wrap items-start justify-between gap-4 mb-4"><div><p class="font-mono font-bold text-gray-800">{{ $conf->order->order_number }}</p><p class="text-sm text-gray-500">{{ $conf->order->user->name }} · {{ $conf->created_at->diffForHumans() }}</p></div><span class="badge badge-yellow">Menunggu Konfirmasi</span></div>
    <div class="grid sm:grid-cols-3 gap-5">
      <div class="sm:col-span-2 grid sm:grid-cols-2 gap-3 text-sm">
        @foreach([['Bank',$conf->bank_name],['Atas Nama',$conf->account_name],['No. Rek',$conf->account_number],['Jumlah','Rp '.number_format($conf->amount,0,',','.')]] as [$l,$v])
        <div class="bg-green-50 rounded-xl p-3"><p class="text-xs text-gray-400 mb-0.5">{{ $l }}</p><p class="font-semibold text-gray-800">{{ $v }}</p></div>
        @endforeach
      </div>
      @if($conf->transfer_proof)<a href="{{ asset('storage/'.$conf->transfer_proof) }}" target="_blank"><img src="{{ asset('storage/'.$conf->transfer_proof) }}" class="w-full h-32 object-contain rounded-xl border cursor-pointer hover:opacity-80"></a>@endif
    </div>
    <form action="{{ route('admin.orders.confirm-payment',$conf->id) }}" method="POST" class="mt-4 flex flex-wrap gap-3 items-end">
      @csrf
      <div class="flex-1 min-w-48"><label class="form-label text-xs">Catatan Admin</label><input type="text" name="admin_notes" class="form-input text-sm" placeholder="Catatan (opsional)"></div>
      <input type="hidden" name="action" id="ca-{{ $conf->id }}" value="">
      <button type="submit" onclick="document.getElementById('ca-{{ $conf->id }}').value='approved'" class="btn-primary btn-sm">✓ Konfirmasi Lunas</button>
      <button type="submit" onclick="document.getElementById('ca-{{ $conf->id }}').value='rejected'" class="btn-danger btn-sm">✕ Tolak</button>
      <a href="{{ route('admin.orders.show',$conf->order->order_number) }}" class="btn-outline btn-sm">Lihat Pesanan</a>
    </form>
  </div>
  @empty
  <div class="card p-16 text-center text-gray-400"><div class="text-5xl mb-3">✅</div><p class="font-medium">Semua pembayaran sudah dikonfirmasi</p></div>
  @endforelse
</div>
@endsection