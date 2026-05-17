@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('content')
<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-7">
  @foreach([['💰','Pendapatan','Rp '.number_format($totalRevenue,0,',','.'),'from-green-500 to-green-600'],['📦','Total Pesanan',number_format($totalOrders),'from-blue-500 to-blue-600'],['🛍️','Produk',number_format($totalProducts),'from-purple-500 to-purple-600'],['👥','Pelanggan',number_format($totalUsers),'from-orange-400 to-orange-500']] as [$icon,$label,$val,$grad])
  <div class="card p-5"><div class="flex items-center justify-between mb-3"><div><p class="text-xs text-gray-500 font-medium">{{ $label }}</p><p class="text-2xl font-extrabold text-gray-800 mt-1">{{ $val }}</p></div><div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $grad }} flex items-center justify-center text-2xl shadow-lg">{{ $icon }}</div></div></div>
  @endforeach
</div>
<div class="grid lg:grid-cols-3 gap-6 mb-7">
  <div class="card p-5">
    <h3 class="font-bold text-gray-800 mb-4">Status Pesanan</h3>
    <div class="space-y-3">
      @foreach([['Menunggu Bayar',$orderStats['menunggu_bayar'],'badge-yellow'],['Diproses',$orderStats['diproses'],'badge-blue'],['Dikirim',$orderStats['dikirim'],'badge-purple'],['Selesai',$orderStats['selesai'],'badge-green']] as [$l,$c,$b])
      <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0"><span class="text-sm text-gray-600">{{ $l }}</span><span class="badge {{ $b }}">{{ $c }}</span></div>
      @endforeach
      @if($pendingPayments>0)<a href="{{ route('admin.orders.pending-payments') }}" class="flex items-center gap-2 mt-3 text-sm text-orange-600 font-semibold hover:text-orange-800">⚠️ {{ $pendingPayments }} konfirmasi bayar menunggu →</a>@endif
    </div>
  </div>
  <div class="card p-5 lg:col-span-2">
    <h3 class="font-bold text-gray-800 mb-4">Pendapatan 6 Bulan Terakhir</h3>
    <canvas id="revenueChart" height="120"></canvas>
  </div>
</div>
<div class="card overflow-hidden">
  <div class="flex items-center justify-between p-5 border-b border-green-50"><h3 class="font-bold text-gray-800">Pesanan Terbaru</h3><a href="{{ route('admin.orders.index') }}" class="text-sm text-green-600 font-semibold">Lihat Semua →</a></div>
  <div class="overflow-x-auto">
    <table class="w-full">
      <thead><tr class="bg-green-50 text-left"><th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Pesanan</th><th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Pelanggan</th><th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Total</th><th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th><th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th></tr></thead>
      <tbody class="divide-y divide-gray-50">
        @forelse($recentOrders as $order)
        <tr class="hover:bg-green-50 transition-colors">
          <td class="px-5 py-3.5"><p class="font-mono text-sm font-bold text-gray-800">{{ $order->order_number }}</p><p class="text-xs text-gray-400">{{ $order->items->count() }} item</p></td>
          <td class="px-5 py-3.5"><p class="text-sm font-medium text-gray-800">{{ $order->user->name }}</p><p class="text-xs text-gray-400">{{ $order->user->email }}</p></td>
          <td class="px-5 py-3.5 font-bold text-green-700 text-sm">Rp {{ number_format($order->total,0,',','.') }}</td>
          <td class="px-5 py-3.5"><span class="badge badge-{{ $order->status_color }}">{{ $order->status_label }}</span></td>
          <td class="px-5 py-3.5"><a href="{{ route('admin.orders.show',$order->order_number) }}" class="btn-outline btn-sm">Detail</a></td>
        </tr>
        @empty
        <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">Belum ada pesanan</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
@push('head-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush
@push('scripts')
<script>
new Chart(document.getElementById('revenueChart').getContext('2d'),{type:'bar',data:{labels:{!! json_encode(collect($monthlyRevenue)->pluck('month')) !!},datasets:[{label:'Pendapatan',data:{!! json_encode(collect($monthlyRevenue)->pluck('revenue')) !!},backgroundColor:'rgba(34,197,94,0.2)',borderColor:'#22c55e',borderWidth:2,borderRadius:8}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{callback:v=>'Rp '+Intl.NumberFormat('id-ID').format(v),font:{size:11}},grid:{color:'#f0fdf4'}},x:{ticks:{font:{size:11}},grid:{display:false}}}}});
</script>
@endpush