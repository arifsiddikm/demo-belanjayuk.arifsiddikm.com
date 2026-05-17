<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Admin') - BelanjaYuk!</title>
{{-- FAVICON --}}
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="shortcut icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
@stack('head-scripts')
<style>
*{font-family:'Plus Jakarta Sans',sans-serif}
body{background:#fafafa}
.sidebar{width:260px;background:linear-gradient(180deg,#9a3412,#c2410c,#ea580c);min-height:100vh}
.sidebar-link{display:flex;align-items:center;gap:.75rem;padding:.65rem 1.25rem;border-radius:.75rem;color:rgba(255,255,255,.8);font-size:.875rem;font-weight:500;transition:all .2s;margin:.1rem .5rem}
.sidebar-link:hover,.sidebar-link.active{background:rgba(255,255,255,.18);color:#fff;transform:translateX(2px)}
.sidebar-section{font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.45);padding:1rem 1.75rem .4rem}
.sidebar-btn-web{display:flex;align-items:center;justify-content:center;gap:.4rem;background:rgba(255,255,255,.15);color:#fff;font-size:.8rem;font-weight:600;padding:.55rem .9rem;border-radius:.65rem;border:1px solid rgba(255,255,255,.25);cursor:pointer;transition:all .2s;flex:1;text-decoration:none}
.sidebar-btn-web:hover{background:rgba(255,255,255,.25)}
.sidebar-btn-logout{display:flex;align-items:center;justify-content:center;gap:.4rem;background:rgba(239,68,68,.25);color:#fca5a5;font-size:.8rem;font-weight:600;padding:.55rem .9rem;border-radius:.65rem;border:1px solid rgba(239,68,68,.3);cursor:pointer;transition:all .2s;flex:1}
.sidebar-btn-logout:hover{background:rgba(239,68,68,.4);color:#fff}
.form-input{width:100%;padding:.65rem 1rem;border:2px solid #e2e8f0;border-radius:.75rem;background:#fff;font-size:.875rem;font-family:inherit;outline:none;transition:all .2s}
.form-input:focus{border-color:#f97316;box-shadow:0 0 0 3px rgba(249,115,22,.1)}
.form-select{width:100%;padding:.65rem 2.5rem .65rem 1rem;border:2px solid #e2e8f0;border-radius:.75rem;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23ea580c' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right .75rem center;font-size:.875rem;font-family:inherit;appearance:none;outline:none;transition:all .2s}
.form-select:focus{border-color:#f97316;box-shadow:0 0 0 3px rgba(249,115,22,.1)}
.form-textarea{width:100%;padding:.65rem 1rem;border:2px solid #e2e8f0;border-radius:.75rem;background:#fff;font-size:.875rem;font-family:inherit;outline:none;resize:vertical;min-height:100px;transition:all .2s}
.form-textarea:focus{border-color:#f97316;box-shadow:0 0 0 3px rgba(249,115,22,.1)}
.form-label{display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:.3rem}
.form-checkbox{width:1.1rem;height:1.1rem;border:2px solid #d1d5db;border-radius:.3rem;appearance:none;background:#fff;cursor:pointer;transition:all .15s}
.form-checkbox:checked{background:#f97316;border-color:#f97316;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='white'%3E%3Cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3E%3C/svg%3E")}
.form-radio{width:1.1rem;height:1.1rem;border:2px solid #d1d5db;border-radius:50%;appearance:none;background:#fff;cursor:pointer;transition:all .15s}
.form-radio:checked{background:#f97316;border-color:#f97316;box-shadow:inset 0 0 0 3px #fff}
.btn-primary{display:inline-flex;align-items:center;justify-content:center;gap:.375rem;background:linear-gradient(135deg,#f97316,#ea580c);color:#fff;font-weight:700;font-size:.875rem;padding:.6rem 1.25rem;border-radius:.75rem;border:none;cursor:pointer;transition:all .2s}
.btn-primary:hover{transform:translateY(-1px);box-shadow:0 4px 12px rgba(249,115,22,.35)}
.btn-danger{display:inline-flex;align-items:center;justify-content:center;gap:.375rem;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;font-weight:700;font-size:.875rem;padding:.6rem 1.25rem;border-radius:.75rem;border:none;cursor:pointer}
.btn-outline{display:inline-flex;align-items:center;justify-content:center;gap:.375rem;background:transparent;color:#ea580c;font-weight:700;font-size:.875rem;padding:.55rem 1.2rem;border-radius:.75rem;border:2px solid #f97316;cursor:pointer;transition:all .2s}
.btn-outline:hover{background:#fff7ed}
.btn-warning{display:inline-flex;align-items:center;justify-content:center;gap:.375rem;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;font-weight:700;font-size:.875rem;padding:.6rem 1.25rem;border-radius:.75rem;border:none;cursor:pointer}
.btn-sm{padding:.38rem .85rem!important;font-size:.78rem!important}
.card{background:#fff;border-radius:1rem;box-shadow:0 1px 10px rgba(0,0,0,.06);border:1px solid #fff0e8}
.badge{display:inline-flex;align-items:center;padding:.2rem .65rem;border-radius:9999px;font-size:.72rem;font-weight:600}
.badge-yellow{background:#fef9c3;color:#854d0e}.badge-blue{background:#dbeafe;color:#1e40af}
.badge-purple{background:#f3e8ff;color:#6b21a8}.badge-orange{background:#ffedd5;color:#c2410c}
.badge-green{background:#dcfce7;color:#14532d}.badge-red{background:#fee2e2;color:#991b1b}
.badge-gray{background:#f1f5f9;color:#475569}
.alert-success{background:#fff7ed;border:1px solid #fdba74;color:#c2410c;padding:.75rem 1rem;border-radius:.75rem;border-left:4px solid #f97316;font-size:.875rem}
.alert-error{background:#fff1f2;border:1px solid #fca5a5;color:#991b1b;padding:.75rem 1rem;border-radius:.75rem;border-left:4px solid #ef4444;font-size:.875rem}
.pagination-link{display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;border-radius:.5rem;border:2px solid #e2e8f0;font-size:.8rem;font-weight:600;color:#374151;transition:all .2s}
.pagination-link:hover,.pagination-link.active{border-color:#f97316;background:#f97316;color:#fff}
.flatpickr-calendar{border-radius:1rem;box-shadow:0 10px 30px rgba(0,0,0,.12);border:1px solid #fed7aa}
.flatpickr-day.selected{background:#f97316;border-color:#f97316}
</style>
</head>
<body class="flex min-h-screen">

<aside class="sidebar flex-shrink-0 fixed left-0 top-0 h-screen overflow-y-auto z-40 hidden md:flex flex-col">
  <div class="p-5 border-b border-white/10">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
      <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
        <i class="fas fa-shopping-bag text-white"></i>
      </div>
      <div>
        <p class="font-extrabold text-white text-sm">BelanjaYuk!</p>
        <p class="text-orange-200 text-xs">Admin Panel</p>
      </div>
    </a>
  </div>

  <nav class="flex-1 py-3">
    <p class="sidebar-section">Utama</p>
    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard')?'active':'' }}">
      <i class="fas fa-chart-pie w-4"></i> Dashboard
    </a>

    <p class="sidebar-section">Penjualan</p>
    <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*')?'active':'' }}">
      <i class="fas fa-box w-4"></i> Pesanan
      @php $pending=\App\Models\Order::where('status','menunggu_bayar')->count(); @endphp
      @if($pending>0)<span class="ml-auto bg-white text-orange-600 text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $pending }}</span>@endif
    </a>
    <a href="{{ route('admin.orders.pending-payments') }}" class="sidebar-link {{ request()->routeIs('admin.orders.pending-payments')?'active':'' }}">
      <i class="fas fa-credit-card w-4"></i> Konfirmasi Bayar
    </a>
    <a href="{{ route('admin.reports') }}" class="sidebar-link {{ request()->routeIs('admin.reports')?'active':'' }}">
      <i class="fas fa-chart-line w-4"></i> Laporan
    </a>

    <p class="sidebar-section">Katalog</p>
    <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*')?'active':'' }}">
      <i class="fas fa-tags w-4"></i> Produk
    </a>
    <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*')?'active':'' }}">
      <i class="fas fa-th-large w-4"></i> Kategori
    </a>

    <p class="sidebar-section">Manajemen</p>
    <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*')?'active':'' }}">
      <i class="fas fa-users w-4"></i> Pengguna
    </a>
    <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->routeIs('admin.settings')?'active':'' }}">
      <i class="fas fa-cog w-4"></i> Pengaturan
    </a>
  </nav>

  <div class="p-4 border-t border-white/10">
    <div class="flex items-center gap-3 px-2 py-2 mb-3">
      <img src="{{ Auth::user()->avatar_url }}" class="w-9 h-9 rounded-full border-2 border-white/30 object-cover">
      <div class="flex-1 min-w-0">
        <p class="text-white text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
        <p class="text-orange-200 text-xs">Administrator</p>
      </div>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('home') }}" target="_blank" class="sidebar-btn-web">
        <i class="fas fa-globe"></i> Website
      </a>
      <button onclick="confirmLogout()" class="sidebar-btn-logout">
        <i class="fas fa-sign-out-alt"></i> Keluar
      </button>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
  </div>
</aside>

<div class="flex-1 md:ml-[260px] flex flex-col min-h-screen">
  <header class="sticky top-0 z-30 bg-white border-b border-orange-100 px-6 py-3.5 flex items-center justify-between shadow-sm">
    <div>
      <h1 class="text-lg font-bold text-gray-800">@yield('page-title','Dashboard')</h1>
      <p class="text-xs text-gray-400">BelanjaYuk! Admin Panel</p>
    </div>
    <div class="flex items-center gap-3">
      <a href="{{ route('home') }}" target="_blank" class="hidden sm:flex items-center gap-1.5 text-sm font-medium hover:underline" style="color:#f97316">
        <i class="fas fa-globe"></i> Lihat Website
      </a>
      <div class="flex items-center gap-2 pl-3 border-l border-orange-100">
        <img src="{{ Auth::user()->avatar_url }}" class="w-8 h-8 rounded-full border-2 object-cover" style="border-color:#fed7aa">
        <span class="text-sm font-semibold text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
      </div>
    </div>
  </header>

  @if(session('success')||session('error'))
  <div class="px-6 pt-4">
    @if(session('success'))<div class="alert-success flex items-center gap-2"><i class="fas fa-check-circle"></i> {{ session('success') }}<button onclick="this.parentElement.remove()" class="ml-auto"><i class="fas fa-times"></i></button></div>@endif
    @if(session('error'))<div class="alert-error flex items-center gap-2"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}<button onclick="this.parentElement.remove()" class="ml-auto"><i class="fas fa-times"></i></button></div>@endif
  </div>
  @endif

  <main class="flex-1 p-6">@yield('content')</main>

  <footer class="px-6 py-3 text-xs text-gray-400 border-t border-orange-50">
    © {{ date('Y') }} BelanjaYuk! Admin Panel
  </footer>
</div>

<script>
function confirmLogout(){
  Swal.fire({title:'Keluar?',text:'Yakin mau keluar dari admin panel?',icon:'question',showCancelButton:true,confirmButtonText:'Ya, Keluar',cancelButtonText:'Batal',confirmButtonColor:'#ef4444',cancelButtonColor:'#f97316'}).then(r=>{if(r.isConfirmed)document.getElementById('logout-form').submit();});
}
document.addEventListener('DOMContentLoaded',function(){
  flatpickr('.datepicker',{locale:'id',dateFormat:'Y-m-d',altInput:true,altFormat:'d M Y',allowInput:true});
  flatpickr('.datepicker-range',{locale:'id',dateFormat:'Y-m-d',altInput:true,altFormat:'d M Y',mode:'range'});
  flatpickr('.datetimepicker',{locale:'id',enableTime:true,dateFormat:'Y-m-d H:i',altInput:true,altFormat:'d M Y H:i'});
  document.querySelectorAll('.rupiah-input').forEach(function(el){
    el.addEventListener('input',function(){let raw=this.value.replace(/\D/g,'');this.value=raw?parseInt(raw).toLocaleString('id-ID'):'';});
    el.closest('form')?.addEventListener('submit',function(){el.value=el.value.replace(/\./g,'');});
  });
});
</script>
@stack('scripts')
</body>
</html>
