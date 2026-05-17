@extends('layouts.admin')
@section('title','Laporan Penjualan')
@section('page-title','Laporan Penjualan')
@section('content')

<div class="card p-5 mb-6">
  <div class="flex flex-wrap items-end justify-between gap-4">
    <form method="GET" class="flex flex-wrap gap-3 items-end flex-1">
      <div>
        <label class="form-label text-xs">Dari Tanggal</label>
        <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="form-input text-sm datepicker">
      </div>
      <div>
        <label class="form-label text-xs">Sampai Tanggal</label>
        <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="form-input text-sm datepicker">
      </div>
      <button type="submit" class="btn-primary btn-sm"><i class="fas fa-filter mr-1"></i> Filter</button>
    </form>
    <div class="flex gap-2">
      <a href="{{ route('admin.reports.export-excel', ['start_date'=>$startDate->format('Y-m-d'),'end_date'=>$endDate->format('Y-m-d')]) }}" class="btn-outline btn-sm">
        <i class="fas fa-file-excel text-green-600"></i> Excel
      </a>
      <a href="{{ route('admin.reports.export-pdf', ['start_date'=>$startDate->format('Y-m-d'),'end_date'=>$endDate->format('Y-m-d')]) }}" class="btn-danger btn-sm">
        <i class="fas fa-file-pdf"></i> PDF
      </a>
    </div>
  </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
  <div class="card p-5 flex items-center gap-4" style="border-left:4px solid #f97316">
    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background:#fff7ed">
      <i class="fas fa-coins text-2xl" style="color:#f97316"></i>
    </div>
    <div>
      <p class="text-xs text-gray-400 mb-0.5">Total Pendapatan</p>
      <p class="text-xl font-extrabold" style="color:#f97316">Rp {{ number_format($totalRevenue,0,',','.') }}</p>
      <p class="text-xs text-gray-400">{{ $startDate->format('d M') }} – {{ $endDate->format('d M Y') }}</p>
    </div>
  </div>
  <div class="card p-5 flex items-center gap-4" style="border-left:4px solid #3b82f6">
    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background:#eff6ff">
      <i class="fas fa-clipboard-list text-2xl text-blue-500"></i>
    </div>
    <div>
      <p class="text-xs text-gray-400 mb-0.5">Total Pesanan</p>
      <p class="text-xl font-extrabold text-blue-600">{{ $orders->total() }}</p>
      <p class="text-xs text-gray-400">periode ini</p>
    </div>
  </div>
  <div class="card p-5 flex items-center gap-4" style="border-left:4px solid #10b981">
    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background:#ecfdf5">
      <i class="fas fa-chart-line text-2xl text-emerald-500"></i>
    </div>
    <div>
      <p class="text-xs text-gray-400 mb-0.5">Rata-rata per Pesanan</p>
      <p class="text-xl font-extrabold text-emerald-600">Rp {{ $orders->total() > 0 ? number_format($totalRevenue/$orders->total(),0,',','.') : '0' }}</p>
    </div>
  </div>
</div>

<div class="card overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full">
      <thead>
        <tr class="bg-orange-50 text-left">
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Pesanan</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Pelanggan</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Total</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @forelse($orders as $order)
        <tr class="hover:bg-orange-50 transition-colors">
          <td class="px-4 py-3.5">
            <a href="{{ route('admin.orders.show',$order->order_number) }}" class="font-mono font-bold hover:underline text-sm" style="color:#f97316">{{ $order->order_number }}</a>
          </td>
          <td class="px-4 py-3.5 text-sm text-gray-700">{{ $order->user->name ?? '-' }}</td>
          <td class="px-4 py-3.5 font-bold text-sm" style="color:#f97316">Rp {{ number_format($order->total,0,',','.') }}</td>
          <td class="px-4 py-3.5"><span class="badge badge-{{ $order->status_color ?? 'gray' }}">{{ $order->status_label ?? $order->status }}</span></td>
          <td class="px-4 py-3.5 text-xs text-gray-400">{{ $order->created_at->format('d M Y H:i') }}</td>
        </tr>
        @empty
        <tr><td colspan="5" class="px-4 py-12 text-center text-gray-400"><i class="fas fa-chart-bar text-3xl text-gray-200 block mb-2"></i> Tidak ada data</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($orders->hasPages())
  <div class="p-4 border-t border-orange-50 flex justify-center gap-1.5">
    @if(!$orders->onFirstPage())<a href="{{ $orders->previousPageUrl() }}" class="pagination-link"><i class="fas fa-chevron-left"></i></a>@endif
    @foreach($orders->getUrlRange(max(1,$orders->currentPage()-2),min($orders->lastPage(),$orders->currentPage()+2)) as $page=>$url)
    <a href="{{ $url }}" class="pagination-link {{ $page==$orders->currentPage()?'active':'' }}">{{ $page }}</a>
    @endforeach
    @if($orders->hasMorePages())<a href="{{ $orders->nextPageUrl() }}" class="pagination-link"><i class="fas fa-chevron-right"></i></a>@endif
  </div>
  @endif
</div>
@endsection
