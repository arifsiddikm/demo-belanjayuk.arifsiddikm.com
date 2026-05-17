<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
  @page { margin: 12mm; size: A4 landscape; }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { margin: 2rem; font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #1f2937; background: #fff; }
  .doc-header { background-color: #ea580c; color: #fff; padding: 14px 20px; border-radius: 8px; margin-bottom: 14px; }
  .header-inner { display: flex; justify-content: space-between; align-items: center; }
  .brand-name { font-size: 20px; font-weight: 900; color: #fff; }
  .brand-sub  { font-size: 9px; color: rgba(255,255,255,.85); margin-top: 3px; }
  .doc-meta   { text-align: right; font-size: 8.5px; color: rgba(255,255,255,.9); line-height: 1.7; }
  .doc-meta b { font-size: 11px; display: block; color: #fff; }
  .period-bar { background: rgba(255,255,255,.2); border-radius: 4px; padding: 5px 12px; font-size: 9px; color: #fff; margin-top: 6px; text-align: center; }
  .accent-bar { height: 4px; background-color: #f97316; border-radius: 2px; margin-bottom: 12px; }

  .kpi-row { display: flex; gap: 10px; margin-bottom: 12px; }
  .kpi { flex: 1; padding: 9px 12px; border-radius: 6px; border: 1px solid #e5e7eb; border-left: 4px solid #f97316; }
  .kpi.blue  { border-left-color: #3b82f6; }
  .kpi.green { border-left-color: #22c55e; }
  .kpi.purple{ border-left-color: #7c3aed; }
  .kpi-label { font-size: 7px; text-transform: uppercase; letter-spacing: .07em; color: #6b7280; margin-bottom: 3px; }
  .kpi-val   { font-size: 15px; font-weight: 900; color: #ea580c; }
  .kpi-val.blue   { color: #2563eb; }
  .kpi-val.green  { color: #16a34a; }
  .kpi-val.purple { color: #7c3aed; }
  .kpi-sub { font-size: 7px; color: #9ca3af; margin-top: 2px; }

  .section-title { font-size: 10px; font-weight: 700; color: #374151; margin-bottom: 7px; padding: 5px 8px; background: #fff7ed; border-left: 3px solid #f97316; border-radius: 0 4px 4px 0; }

  table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
  thead tr { background-color: #ea580c; }
  thead th { color: #fff; padding: 6px 7px; text-align: left; font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; }
  tbody tr:nth-child(even) { background-color: #fff7ed; }
  tbody td { padding: 5px 7px; border-bottom: 1px solid #f0f0f0; font-size: 8.5px; vertical-align: middle; }
  .amount { font-weight: 700; color: #ea580c; }
  .mono   { font-family: 'Courier New', monospace; font-size: 8px; font-weight: 700; }
  .badge  { display: inline-block; padding: 2px 6px; border-radius: 10px; font-size: 7.5px; font-weight: 700; }
  .badge-green  { background: #dcfce7; color: #15803d; }
  .badge-yellow { background: #fef9c3; color: #854d0e; }
  .badge-blue   { background: #dbeafe; color: #1e40af; }
  .badge-orange { background: #ffedd5; color: #c2410c; }
  .badge-red    { background: #fee2e2; color: #991b1b; }
  .badge-gray   { background: #f1f5f9; color: #475569; }

  .summary-box { margin-left: auto; width: 250px; border: 1px solid #e5e7eb; border-radius: 6px; overflow: hidden; margin-bottom: 12px; }
  .summary-row { display: flex; justify-content: space-between; padding: 5px 10px; font-size: 8.5px; border-bottom: 1px solid #f0f0f0; }
  .summary-row.total { background: #ea580c; color: #fff; font-weight: 900; font-size: 9.5px; border-bottom: none; }

  .doc-footer { padding-top: 8px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; }
  .doc-footer div { font-size: 7.5px; color: #9ca3af; line-height: 1.6; }
</style>
</head>
<body>

<div class="doc-header">
  <div class="header-inner">
    <div>
      <div class="brand-name">&#128200; BelanjaYuk!</div>
      <div class="brand-sub">Laporan Penjualan — Toko Online Terpercaya</div>
    </div>
    <div class="doc-meta">
      <b>{{ now()->format('d M Y, H:i') }} WIB</b>
      Dicetak oleh Admin
    </div>
  </div>
  <div class="period-bar">
    Periode: {{ $startDate->format('d M Y') }} &mdash; {{ $endDate->format('d M Y') }}
  </div>
</div>

<div class="accent-bar"></div>

@php
  $totalRev   = collect($orders)->whereIn('status',['selesai','dikirim','diterima'])->sum('total');
  $totalAll   = count($orders);
  $selesai    = collect($orders)->where('status','selesai')->count();
  $avgOrder   = $totalAll > 0 ? $totalRev/$totalAll : 0;
@endphp

<div class="kpi-row">
  <div class="kpi">
    <div class="kpi-label">Total Revenue</div>
    <div class="kpi-val">Rp {{ number_format($totalRev,0,',','.') }}</div>
    <div class="kpi-sub">Pesanan terkonfirmasi</div>
  </div>
  <div class="kpi blue">
    <div class="kpi-label">Total Pesanan</div>
    <div class="kpi-val blue">{{ $totalAll }}</div>
    <div class="kpi-sub">Semua status</div>
  </div>
  <div class="kpi green">
    <div class="kpi-label">Pesanan Selesai</div>
    <div class="kpi-val green">{{ $selesai }}</div>
    <div class="kpi-sub">{{ $totalAll > 0 ? round($selesai/$totalAll*100) : 0 }}% konversi</div>
  </div>
  <div class="kpi purple">
    <div class="kpi-label">Avg per Pesanan</div>
    <div class="kpi-val purple">Rp {{ number_format($avgOrder,0,',','.') }}</div>
    <div class="kpi-sub">Average order value</div>
  </div>
</div>

<div class="section-title">&#128203; Rincian Pesanan</div>

<table>
  <thead>
    <tr>
      <th style="width:22px">No</th>
      <th>No. Pesanan</th>
      <th>Pelanggan</th>
      <th>Subtotal</th>
      <th>Ongkir</th>
      <th>Diskon</th>
      <th>Total</th>
      <th>Status</th>
      <th>Tanggal</th>
    </tr>
  </thead>
  <tbody>
    @php $statusMap = ['menunggu_bayar'=>['Menunggu','badge-yellow'],'diproses'=>['Diproses','badge-blue'],'dikirim'=>['Dikirim','badge-orange'],'diterima'=>['Diterima','badge-green'],'selesai'=>['Selesai','badge-green'],'dibatalkan'=>['Dibatalkan','badge-red']]; @endphp
    @forelse($orders as $i => $order)
    <tr>
      <td style="text-align:center;color:#9ca3af">{{ $i+1 }}</td>
      <td class="mono">{{ $order->order_number }}</td>
      <td>{{ $order->user->name ?? '-' }}</td>
      <td>Rp {{ number_format($order->subtotal,0,',','.') }}</td>
      <td>Rp {{ number_format($order->shipping_cost,0,',','.') }}</td>
      <td style="color:#16a34a">{{ $order->discount > 0 ? '-Rp '.number_format($order->discount,0,',','.') : '-' }}</td>
      <td class="amount">Rp {{ number_format($order->total,0,',','.') }}</td>
      <td>
        @php [$lbl,$cls] = $statusMap[$order->status] ?? [$order->status,'badge-gray']; @endphp
        <span class="badge {{ $cls }}">{{ $lbl }}</span>
      </td>
      <td style="color:#6b7280">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
    </tr>
    @empty
    <tr><td colspan="9" style="text-align:center;padding:20px;color:#9ca3af">Tidak ada data</td></tr>
    @endforelse
  </tbody>
</table>

<div class="summary-box">
  <div class="summary-row"><span>Total Subtotal</span><span>Rp {{ number_format(collect($orders)->sum('subtotal'),0,',','.') }}</span></div>
  <div class="summary-row"><span>Total Ongkir</span><span>Rp {{ number_format(collect($orders)->sum('shipping_cost'),0,',','.') }}</span></div>
  <div class="summary-row total"><span>GRAND TOTAL</span><span>Rp {{ number_format(collect($orders)->sum('total'),0,',','.') }}</span></div>
</div>

<div class="doc-footer">
  <div>Dokumen ini digenerate otomatis oleh sistem BelanjaYuk!<br>Tidak memerlukan tanda tangan untuk validasi digital.</div>
  <div style="text-align:right">BelanjaYuk! &copy; {{ date('Y') }}<br>admin@belanjayuk.com | Cilegon, Banten</div>
</div>
</body>
</html>
