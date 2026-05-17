<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
  @page { margin: 12mm; size: A4 landscape; }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { margin: 2rem; font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #1f2937; background: #fff; }

  /* ===== HEADER ===== */
  .doc-header {
    background-color: #ea580c; /* solid orange - DomPDF support */
    color: #fff;
    padding: 14px 20px;
    border-radius: 8px;
    margin-bottom: 14px;
  }
  .doc-header-inner { display: flex; justify-content: space-between; align-items: center; }
  .doc-header .brand-name { font-size: 22px; font-weight: 900; color: #fff; letter-spacing: -0.5px; }
  .doc-header .brand-sub  { font-size: 10px; color: rgba(255,255,255,.85); margin-top: 2px; }
  .doc-header .doc-meta   { text-align: right; font-size: 9px; color: rgba(255,255,255,.9); line-height: 1.7; }
  .doc-header .doc-meta b { font-size: 12px; color: #fff; display: block; }

  /* Orange accent divider */
  .accent-bar { height: 4px; background-color: #f97316; border-radius: 2px; margin-bottom: 12px; }

  /* ===== KPI BOXES ===== */
  .kpi-row { display: flex; gap: 10px; margin-bottom: 12px; }
  .kpi {
    flex: 1; padding: 10px 12px; border-radius: 6px;
    border: 1px solid #e5e7eb; border-left: 4px solid #f97316;
  }
  .kpi.blue  { border-left-color: #3b82f6; }
  .kpi.green { border-left-color: #22c55e; }
  .kpi-label { font-size: 7px; text-transform: uppercase; letter-spacing: .07em; color: #6b7280; margin-bottom: 3px; }
  .kpi-val   { font-size: 16px; font-weight: 900; color: #ea580c; }
  .kpi-val.blue  { color: #2563eb; }
  .kpi-val.green { color: #16a34a; }
  .kpi-sub   { font-size: 7px; color: #9ca3af; margin-top: 2px; }

  /* ===== TABLE ===== */
  .section-title {
    font-size: 10px; font-weight: 700; color: #374151;
    margin-bottom: 7px; padding: 5px 8px;
    background: #fff7ed; border-left: 3px solid #f97316;
    border-radius: 0 4px 4px 0;
  }
  table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
  thead tr { background-color: #ea580c; }
  thead th { color: #fff; padding: 6px 7px; text-align: left; font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; }
  tbody tr:nth-child(even) { background-color: #fff7ed; }
  tbody tr:nth-child(odd)  { background-color: #fff; }
  tbody td { padding: 5px 7px; border-bottom: 1px solid #f0f0f0; font-size: 8.5px; vertical-align: middle; }

  /* Badges */
  .badge { display: inline-block; padding: 2px 6px; border-radius: 10px; font-size: 7.5px; font-weight: 700; }
  .badge-green  { background: #dcfce7; color: #15803d; }
  .badge-yellow { background: #fef9c3; color: #854d0e; }
  .badge-blue   { background: #dbeafe; color: #1e40af; }
  .badge-orange { background: #ffedd5; color: #c2410c; }
  .badge-red    { background: #fee2e2; color: #991b1b; }
  .badge-gray   { background: #f1f5f9; color: #475569; }
  .amount { font-weight: 700; color: #ea580c; }
  .mono   { font-family: 'Courier New', monospace; font-size: 8px; font-weight: 700; }

  /* Summary box */
  .summary-box { margin-left: auto; width: 250px; border: 1px solid #e5e7eb; border-radius: 6px; overflow: hidden; margin-bottom: 12px; }
  .summary-row { display: flex; justify-content: space-between; padding: 5px 10px; font-size: 9px; border-bottom: 1px solid #f0f0f0; }
  .summary-row.total { background: #ea580c; color: #fff; font-weight: 900; font-size: 10px; border-bottom: none; }

  /* Footer */
  .doc-footer { padding-top: 8px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; }
  .doc-footer div { font-size: 7.5px; color: #9ca3af; line-height: 1.6; }
</style>
</head>
<body>

{{-- HEADER --}}
<div class="doc-header">
  <div class="doc-header-inner">
    <div>
      <div class="brand-name">&#128722; BelanjaYuk!</div>
      <div class="brand-sub">Laporan Data Pesanan — Toko Online Terpercaya</div>
    </div>
    <div class="doc-meta">
      <b>{{ now()->format('d M Y, H:i') }} WIB</b>
      Total {{ count($orders) }} Pesanan &nbsp;|&nbsp; Dicetak oleh Admin
    </div>
  </div>
</div>

<div class="accent-bar"></div>

{{-- KPI --}}
@php
  $totalRev     = collect($orders)->whereIn('status',['selesai','dikirim','diterima'])->sum('total');
  $totalAll     = count($orders);
  $selesaiCount = collect($orders)->where('status','selesai')->count();
@endphp
<div class="kpi-row">
  <div class="kpi">
    <div class="kpi-label">&#128178; Total Revenue</div>
    <div class="kpi-val">Rp {{ number_format($totalRev,0,',','.') }}</div>
    <div class="kpi-sub">Pesanan terkonfirmasi bayar</div>
  </div>
  <div class="kpi blue">
    <div class="kpi-label">&#128203; Total Pesanan</div>
    <div class="kpi-val blue">{{ $totalAll }}</div>
    <div class="kpi-sub">Semua status</div>
  </div>
  <div class="kpi green">
    <div class="kpi-label">&#10003; Pesanan Selesai</div>
    <div class="kpi-val green">{{ $selesaiCount }}</div>
    <div class="kpi-sub">{{ $totalAll > 0 ? round($selesaiCount/$totalAll*100) : 0 }}% konversi</div>
  </div>
  <div class="kpi">
    <div class="kpi-label">&#128181; Avg per Pesanan</div>
    <div class="kpi-val">Rp {{ $totalAll > 0 ? number_format($totalRev/$totalAll,0,',','.') : '0' }}</div>
    <div class="kpi-sub">Average order value</div>
  </div>
</div>

<div class="section-title">&#128230; Rincian Pesanan</div>

<table>
  <thead>
    <tr>
      <th style="width:24px">No</th>
      <th>No. Pesanan</th>
      <th>Pelanggan</th>
      <th>Kota Tujuan</th>
      <th>Kurir</th>
      <th>Subtotal</th>
      <th>Ongkir</th>
      <th>Total</th>
      <th>Bayar</th>
      <th>Status</th>
      <th>Tanggal</th>
    </tr>
  </thead>
  <tbody>
    @php
      $statusMap = [
        'menunggu_bayar' => ['Menunggu','badge-yellow'],
        'diproses'       => ['Diproses','badge-blue'],
        'dikirim'        => ['Dikirim','badge-orange'],
        'diterima'       => ['Diterima','badge-green'],
        'selesai'        => ['Selesai','badge-green'],
        'dibatalkan'     => ['Dibatalkan','badge-red'],
      ];
    @endphp
    @forelse($orders as $i => $order)
    <tr>
      <td style="text-align:center;color:#9ca3af">{{ $i+1 }}</td>
      <td class="mono">{{ $order->order_number }}</td>
      <td>{{ $order->user->name ?? '-' }}</td>
      <td>{{ $order->city_name ?? '-' }}</td>
      <td style="font-weight:600;text-transform:uppercase;font-size:8px">{{ $order->courier }}</td>
      <td>Rp {{ number_format($order->subtotal,0,',','.') }}</td>
      <td>Rp {{ number_format($order->shipping_cost,0,',','.') }}</td>
      <td class="amount">Rp {{ number_format($order->total,0,',','.') }}</td>
      <td style="font-size:7.5px">{{ $order->payment_method==='midtrans'?'Midtrans':'Bank Transfer' }}</td>
      <td>
        @php [$lbl,$cls] = $statusMap[$order->status] ?? [$order->status,'badge-gray']; @endphp
        <span class="badge {{ $cls }}">{{ $lbl }}</span>
      </td>
      <td style="color:#6b7280">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
    </tr>
    @empty
    <tr><td colspan="11" style="text-align:center;padding:20px;color:#9ca3af">Tidak ada data pesanan</td></tr>
    @endforelse
  </tbody>
</table>

{{-- Summary Total --}}
@if(count($orders) > 0)
<div class="summary-box">
  <div class="summary-row"><span>Total Subtotal</span><span>Rp {{ number_format(collect($orders)->sum('subtotal'),0,',','.') }}</span></div>
  <div class="summary-row"><span>Total Ongkir</span><span>Rp {{ number_format(collect($orders)->sum('shipping_cost'),0,',','.') }}</span></div>
  <div class="summary-row total"><span>GRAND TOTAL</span><span>Rp {{ number_format(collect($orders)->sum('total'),0,',','.') }}</span></div>
</div>
@endif

<div class="doc-footer">
  <div>Dokumen ini digenerate otomatis oleh sistem BelanjaYuk!<br>Tidak memerlukan tanda tangan untuk validasi digital.</div>
  <div style="text-align:right">BelanjaYuk! &copy; {{ date('Y') }}<br>admin@belanjayuk.com | Cilegon, Banten</div>
</div>

</body>
</html>
