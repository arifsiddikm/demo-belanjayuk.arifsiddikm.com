<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
  @page { margin: 12mm; size: A4; }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { margin: 2rem; font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #1f2937; background: #fff; }
  .doc-header { background-color: #ea580c; color: #fff; padding: 14px 20px; border-radius: 8px; margin-bottom: 12px; }
  .header-inner { display: flex; justify-content: space-between; align-items: center; }
  .brand-name { font-size: 20px; font-weight: 900; color: #fff; }
  .brand-sub  { font-size: 9px; color: rgba(255,255,255,.85); margin-top: 2px; }
  .doc-meta   { text-align: right; font-size: 8.5px; color: rgba(255,255,255,.9); line-height: 1.7; }
  .doc-meta b { font-size: 12px; display: block; color: #fff; }
  .accent-bar { height: 4px; background-color: #f97316; border-radius: 2px; margin-bottom: 12px; }
  .kpi-row { display: flex; gap: 10px; margin-bottom: 12px; }
  .kpi { flex: 1; padding: 9px 12px; border-radius: 6px; border: 1px solid #e5e7eb; border-left: 4px solid #f97316; }
  .kpi.blue   { border-left-color: #3b82f6; }
  .kpi.purple { border-left-color: #7c3aed; }
  .kpi.green  { border-left-color: #22c55e; }
  .kpi-label { font-size: 7px; text-transform: uppercase; letter-spacing: .07em; color: #6b7280; margin-bottom: 3px; }
  .kpi-val   { font-size: 18px; font-weight: 900; color: #ea580c; }
  .kpi-val.blue   { color: #2563eb; }
  .kpi-val.purple { color: #7c3aed; }
  .kpi-val.green  { color: #16a34a; }
  .kpi-sub { font-size: 7px; color: #9ca3af; margin-top: 2px; }
  .section-title { font-size: 10px; font-weight: 700; color: #374151; margin-bottom: 7px; padding: 5px 8px; background: #fff7ed; border-left: 3px solid #f97316; border-radius: 0 4px 4px 0; }
  table { width: 100%; border-collapse: collapse; }
  thead tr { background-color: #ea580c; }
  thead th { color: #fff; padding: 6px 8px; text-align: left; font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; }
  tbody tr:nth-child(even) { background-color: #fff7ed; }
  tbody td { padding: 6px 8px; border-bottom: 1px solid #f0f0f0; font-size: 8.5px; vertical-align: middle; }
  .badge  { display: inline-block; padding: 2px 7px; border-radius: 10px; font-size: 7.5px; font-weight: 700; }
  .badge-green  { background: #dcfce7; color: #15803d; }
  .badge-red    { background: #fee2e2; color: #991b1b; }
  .badge-purple { background: #f3e8ff; color: #6b21a8; }
  .badge-blue   { background: #dbeafe; color: #1e40af; }
  .avatar-circle { display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: #ea580c; color: #fff; text-align: center; line-height: 20px; font-size: 8px; font-weight: 700; margin-right: 4px; vertical-align: middle; }
  .doc-footer { margin-top: 16px; padding-top: 8px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; }
  .doc-footer div { font-size: 7.5px; color: #9ca3af; line-height: 1.6; }
</style>
</head>
<body>

<div class="doc-header">
  <div class="header-inner">
    <div>
      <div class="brand-name">&#128101; BelanjaYuk!</div>
      <div class="brand-sub">Laporan Data Pengguna</div>
    </div>
    <div class="doc-meta">
      <b>{{ now()->format('d M Y, H:i') }} WIB</b>
      Total {{ count($users) }} Pengguna
    </div>
  </div>
</div>

<div class="accent-bar"></div>

@php
  $adminCnt  = collect($users)->where('role','admin')->count();
  $userCnt   = collect($users)->where('role','user')->count();
  $activeCnt = collect($users)->where('is_active',true)->count();
@endphp

<div class="kpi-row">
  <div class="kpi">
    <div class="kpi-label">Total Pengguna</div>
    <div class="kpi-val">{{ count($users) }}</div>
    <div class="kpi-sub">Semua role</div>
  </div>
  <div class="kpi blue">
    <div class="kpi-label">Aktif</div>
    <div class="kpi-val blue">{{ $activeCnt }}</div>
    <div class="kpi-sub">Dapat login</div>
  </div>
  <div class="kpi purple">
    <div class="kpi-label">Admin</div>
    <div class="kpi-val purple">{{ $adminCnt }}</div>
    <div class="kpi-sub">Panel access</div>
  </div>
  <div class="kpi green">
    <div class="kpi-label">User Biasa</div>
    <div class="kpi-val green">{{ $userCnt }}</div>
    <div class="kpi-sub">Pembeli</div>
  </div>
</div>

<div class="section-title">&#128203; Daftar Pengguna</div>

<table>
  <thead>
    <tr>
      <th style="width:22px">No</th>
      <th>Nama</th>
      <th>Email</th>
      <th>No. HP</th>
      <th>Role</th>
      <th>Status</th>
      <th>Bergabung</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $i => $user)
    <tr>
      <td style="text-align:center;color:#9ca3af">{{ $i+1 }}</td>
      <td>
        <span class="avatar-circle">{{ strtoupper(substr($user->name,0,1)) }}</span>
        <strong>{{ $user->name }}</strong>
      </td>
      <td style="color:#2563eb">{{ $user->email }}</td>
      <td>{{ $user->phone ?? '-' }}</td>
      <td><span class="badge {{ $user->role==='admin'?'badge-purple':'badge-blue' }}">{{ ucfirst($user->role) }}</span></td>
      <td><span class="badge {{ $user->is_active?'badge-green':'badge-red' }}">{{ $user->is_active?'Aktif':'Nonaktif' }}</span></td>
      <td style="color:#6b7280">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

<div class="doc-footer">
  <div>Dokumen ini digenerate otomatis oleh sistem BelanjaYuk!<br>Tidak memerlukan tanda tangan untuk validasi digital.</div>
  <div style="text-align:right">BelanjaYuk! &copy; {{ date('Y') }}<br>admin@belanjayuk.com | Cilegon, Banten</div>
</div>
</body>
</html>
