@extends('layouts.admin')
@section('title','Kelola Pesanan')
@section('page-title','Kelola Pesanan')
@section('content')

<div class="card overflow-hidden">
  <div class="p-5 border-b border-orange-50">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
      <h3 class="font-bold text-gray-800">Daftar Pesanan</h3>
      {{-- Export buttons --}}
      <div class="flex gap-2">
        <a href="{{ route('admin.orders.export-excel', request()->all()) }}" class="btn-outline btn-sm">
          <i class="fas fa-file-excel text-green-600"></i> Excel
        </a>
        <a href="{{ route('admin.orders.export-pdf', request()->all()) }}" class="btn-danger btn-sm">
          <i class="fas fa-file-pdf"></i> PDF
        </a>
      </div>
    </div>
    <form method="GET" class="flex flex-wrap gap-3 items-end">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. pesanan / pelanggan..." class="form-input text-sm flex-1 min-w-48">
      <select name="status" class="form-select text-sm w-44">
        <option value="">Semua Status</option>
        @foreach(['menunggu_bayar'=>'Menunggu Bayar','diproses'=>'Diproses','dikirim'=>'Dikirim','diterima'=>'Diterima','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'] as $v=>$l)
        <option value="{{ $v }}" {{ request('status')===$v?'selected':'' }}>{{ $l }}</option>
        @endforeach
      </select>
      <button type="submit" class="btn-primary btn-sm"><i class="fas fa-search mr-1"></i> Cari</button>
      @if(request()->hasAny(['search','status']))<a href="{{ route('admin.orders.index') }}" class="btn-outline btn-sm">Reset</a>@endif
    </form>
    <div class="flex gap-2 mt-3 overflow-x-auto">
      @foreach([''=>'Semua','menunggu_bayar'=>'Menunggu Bayar','diproses'=>'Diproses','dikirim'=>'Dikirim','selesai'=>'Selesai'] as $v=>$l)
      <a href="{{ route('admin.orders.index',['status'=>$v]) }}" class="flex-shrink-0 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ request('status')===$v?'text-white':'text-orange-700 hover:text-orange-900' }}" style="{{ request('status')===$v?'background:#f97316':'background:#fff7ed' }}">{{ $l }}</a>
      @endforeach
    </div>
  </div>
  <div class="overflow-x-auto">
    <table class="w-full">
      <thead>
        <tr class="bg-orange-50 text-left">
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Pesanan</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Pelanggan</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Total</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Bayar</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @forelse($orders as $order)
        <tr class="hover:bg-orange-50 transition-colors">
          <td class="px-4 py-3.5">
            <p class="font-mono text-sm font-bold text-gray-800">{{ $order->order_number }}</p>
            <p class="text-xs text-gray-400">{{ $order->items->count() }} item</p>
          </td>
          <td class="px-4 py-3.5">
            <p class="text-sm font-medium text-gray-800">{{ $order->user->name ?? '-' }}</p>
            <p class="text-xs text-gray-400">{{ $order->user->email ?? '' }}</p>
          </td>
          <td class="px-4 py-3.5 font-bold text-sm" style="color:#f97316">Rp {{ number_format($order->total,0,',','.') }}</td>
          <td class="px-4 py-3.5">
            <span class="badge {{ $order->payment_status==='paid'?'badge-green':($order->payment_status==='failed'?'badge-red':'badge-yellow') }}">
              {{ $order->payment_status==='paid'?'Lunas':($order->payment_status==='failed'?'Gagal':'Menunggu') }}
            </span>
          </td>
          <td class="px-4 py-3.5">
            <span class="badge badge-{{ $order->status_color ?? 'gray' }}">{{ $order->status_label ?? $order->status }}</span>
          </td>
          <td class="px-4 py-3.5 text-xs text-gray-400">{{ $order->created_at->format('d M Y H:i') }}</td>
          <td class="px-4 py-3.5">
            <a href="{{ route('admin.orders.show',$order->order_number) }}" class="btn-outline btn-sm">
              <i class="fas fa-eye"></i> Detail
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="px-5 py-16 text-center text-gray-400">
            <i class="fas fa-box text-4xl text-gray-200 block mb-3"></i>
            Belum ada pesanan
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($orders->hasPages())
  <div class="p-5 border-t border-orange-50 flex justify-center gap-1.5">
    @if(!$orders->onFirstPage())<a href="{{ $orders->previousPageUrl() }}" class="btn-outline btn-sm"><i class="fas fa-chevron-left"></i></a>@endif
    @foreach($orders->getUrlRange(max(1,$orders->currentPage()-2),min($orders->lastPage(),$orders->currentPage()+2)) as $page=>$url)
    <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg border-2 text-sm font-semibold {{ $page==$orders->currentPage()?'text-white':'border-gray-200 hover:border-orange-400' }}" style="{{ $page==$orders->currentPage()?'border-color:#f97316;background:#f97316':'' }}">{{ $page }}</a>
    @endforeach
    @if($orders->hasMorePages())<a href="{{ $orders->nextPageUrl() }}" class="btn-outline btn-sm"><i class="fas fa-chevron-right"></i></a>@endif
  </div>
  @endif
</div>
@endsection
