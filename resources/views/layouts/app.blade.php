<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','BelanjaYuk!')</title>
<meta name="description" content="BelanjaYuk! - Toko Online Fashion, Elektronik & Kebutuhan Sehari-hari Terpercaya.">

{{-- FAVICON - multiple format untuk kompatibilitas semua browser --}}
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="shortcut icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
{{-- FontAwesome 6 Free --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous">
<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config={theme:{extend:{colors:{primary:{'50':'#fff7ed','100':'#ffedd5','500':'#f97316','600':'#ea580c','700':'#c2410c'}},fontFamily:{sans:['Plus Jakarta Sans','sans-serif']}}}}</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('head-scripts')
<style>
*{font-family:'Plus Jakarta Sans',sans-serif}
body{background:#fff8f5}
::-webkit-scrollbar{width:5px}::-webkit-scrollbar-thumb{background:#f97316;border-radius:10px}
.scrollbar-hide::-webkit-scrollbar{display:none}
.btn-primary{display:inline-flex;align-items:center;justify-content:center;gap:.375rem;background:linear-gradient(135deg,#f97316,#ea580c);color:#fff;font-weight:700;padding:.65rem 1.5rem;border-radius:.75rem;border:none;cursor:pointer;transition:all .2s;box-shadow:0 4px 14px rgba(249,115,22,.3)}
.btn-primary:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(249,115,22,.4)}
.btn-outline{display:inline-flex;align-items:center;justify-content:center;gap:.375rem;background:transparent;color:#ea580c;font-weight:700;padding:.6rem 1.4rem;border-radius:.75rem;border:2px solid #f97316;cursor:pointer;transition:all .2s}
.btn-outline:hover{background:#fff7ed}
.btn-danger{display:inline-flex;align-items:center;justify-content:center;gap:.375rem;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;font-weight:700;padding:.65rem 1.5rem;border-radius:.75rem;border:none;cursor:pointer}
.btn-wa{display:inline-flex;align-items:center;justify-content:center;gap:.5rem;background:linear-gradient(135deg,#25D366,#128C7E);color:#fff;font-weight:700;padding:.6rem 1.4rem;border-radius:.75rem;border:none;cursor:pointer;transition:all .2s}
.form-input{width:100%;padding:.75rem 1rem;border:2px solid #e2e8f0;border-radius:.75rem;background:#fff;font-size:.9rem;font-family:inherit;outline:none;transition:all .2s}
.form-input:focus{border-color:#f97316;box-shadow:0 0 0 3px rgba(249,115,22,.1)}
.form-select{width:100%;padding:.75rem 2.5rem .75rem 1rem;border:2px solid #e2e8f0;border-radius:.75rem;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23ea580c' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right .75rem center;font-size:.9rem;font-family:inherit;appearance:none;outline:none;transition:all .2s}
.form-select:focus{border-color:#f97316;box-shadow:0 0 0 3px rgba(249,115,22,.1)}
.form-textarea{width:100%;padding:.75rem 1rem;border:2px solid #e2e8f0;border-radius:.75rem;background:#fff;font-size:.9rem;font-family:inherit;outline:none;resize:vertical;min-height:100px;transition:all .2s}
.form-textarea:focus{border-color:#f97316;box-shadow:0 0 0 3px rgba(249,115,22,.1)}
.form-label{display:block;font-size:.875rem;font-weight:600;color:#374151;margin-bottom:.375rem}
.form-checkbox{width:1.1rem;height:1.1rem;border:2px solid #d1d5db;border-radius:.3rem;appearance:none;background:#fff;cursor:pointer;transition:all .15s}
.form-checkbox:checked{background:#f97316;border-color:#f97316;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='white'%3E%3Cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3E%3C/svg%3E")}
.form-radio{width:1.1rem;height:1.1rem;border:2px solid #d1d5db;border-radius:50%;appearance:none;background:#fff;cursor:pointer;transition:all .15s}
.form-radio:checked{background:#f97316;border-color:#f97316;box-shadow:inset 0 0 0 3px #fff}
.card{background:#fff;border-radius:1rem;box-shadow:0 1px 12px rgba(0,0,0,.07);border:1px solid #fff0e8;overflow:hidden}
.card-hover{transition:all .25s}.card-hover:hover{transform:translateY(-4px);box-shadow:0 12px 32px rgba(249,115,22,.15)}
.product-card{position:relative;overflow:hidden;display:flex;flex-direction:column}
.product-card img{transition:transform .4s}
.product-card:hover img{transform:scale(1.06)}
.product-badge{position:absolute;top:.5rem;left:.5rem;z-index:10;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;font-size:.7rem;font-weight:700;padding:.2rem .55rem;border-radius:.4rem}
.product-info{padding:.6rem;flex:1;display:flex;flex-direction:column;gap:.15rem}
.product-category{font-size:.65rem;font-weight:600;color:#f97316;text-transform:uppercase;letter-spacing:.04em}
.product-name{font-size:.82rem;font-weight:700;color:#1f2937;line-height:1.3;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.product-name:hover{color:#ea580c}
.product-price{font-size:.95rem;font-weight:800;color:#ea580c}
.product-price-old{font-size:.72rem;color:#9ca3af;text-decoration:line-through}
.product-sold{font-size:.68rem;color:#9ca3af}
.section-title{font-size:1.35rem;font-weight:800;color:#c2410c;position:relative;padding-bottom:.6rem}
.section-title::after{content:'';position:absolute;bottom:0;left:0;width:2.5rem;height:3px;background:linear-gradient(90deg,#f97316,#fbbf24);border-radius:2px}
.badge{display:inline-flex;align-items:center;padding:.25rem .65rem;border-radius:9999px;font-size:.72rem;font-weight:600}
.badge-yellow{background:#fef9c3;color:#854d0e}.badge-blue{background:#dbeafe;color:#1e40af}
.badge-purple{background:#f3e8ff;color:#6b21a8}.badge-orange{background:#ffedd5;color:#c2410c}
.badge-green{background:#dcfce7;color:#14532d}.badge-red{background:#fee2e2;color:#991b1b}
.badge-gray{background:#f1f5f9;color:#475569}
.alert-success{background:#fff7ed;border:1px solid #fdba74;color:#c2410c;padding:.875rem 1rem;border-radius:.75rem;border-left:4px solid #f97316;font-size:.875rem}
.alert-error{background:#fff1f2;border:1px solid #fca5a5;color:#991b1b;padding:.875rem 1rem;border-radius:.75rem;border-left:4px solid #ef4444;font-size:.875rem}
.cart-badge{position:absolute;top:-5px;right:-5px;background:#ef4444;color:#fff;font-size:.6rem;font-weight:700;min-width:1rem;height:1rem;border-radius:9999px;display:flex;align-items:center;justify-content:center;padding:0 .2rem}
.hero-slide{display:none}.hero-slide.active{display:block}
.pagination-link{display:inline-flex;align-items:center;justify-content:center;width:2.25rem;height:2.25rem;border-radius:.6rem;border:2px solid #e2e8f0;font-size:.875rem;font-weight:600;color:#374151;transition:all .2s}
.pagination-link:hover,.pagination-link.active{border-color:#f97316;background:#f97316;color:#fff}
.spinner{width:1.5rem;height:1.5rem;border:3px solid rgba(249,115,22,.2);border-top-color:#f97316;border-radius:50%;animation:spin .7s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}
@keyframes fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
.animate-fade-up{animation:fadeUp .4s ease forwards}
</style>
</head>
<body class="min-h-screen flex flex-col">

{{-- HEADER --}}
<header class="sticky top-0 z-50" style="background:rgba(255,255,255,.97);backdrop-filter:blur(12px);border-bottom:1px solid rgba(249,115,22,.12);box-shadow:0 2px 10px rgba(249,115,22,.07)">
  <div class="text-white text-xs text-center py-1.5 font-medium hidden sm:block" style="background:linear-gradient(135deg,#f97316,#ea580c)">
    <i class="fas fa-fire text-yellow-300"></i> Flash Sale Tiap Hari &nbsp;|&nbsp;
    <i class="fas fa-shield-alt text-yellow-200"></i> Transaksi 100% Aman &nbsp;|&nbsp;
    <a href="https://wa.me/{{ env('ADMIN_WHATSAPP','6289514392694') }}" class="underline font-bold">CS WhatsApp</a>
  </div>

  <nav class="max-w-7xl mx-auto px-3 py-2.5">
    <div class="flex items-center gap-3">
      <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center shadow" style="background:linear-gradient(135deg,#f97316,#ea580c)">
          <i class="fas fa-shopping-bag text-white text-sm"></i>
        </div>
        <span class="font-extrabold text-lg hidden sm:block" style="color:#ea580c">Belanja<span style="color:#f97316">Yuk!</span></span>
      </a>

      <form action="{{ route('produk.search') }}" method="GET" class="flex-1 hidden md:flex justify-center">
        <div class="relative w-full max-w-xl">
          <input type="text" name="q" placeholder="Cari produk, merek, atau kategori..." value="{{ request('q') }}"
            class="w-full pl-4 pr-12 py-2.5 rounded-xl text-sm"
            style="border:2px solid #fed7aa;background:#fff7ed;outline:none"
            onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='#fed7aa'">
          <button type="submit" class="absolute right-0 top-0 bottom-0 px-3.5 text-white rounded-r-xl" style="background:linear-gradient(135deg,#f97316,#ea580c)">
            <i class="fas fa-search text-sm"></i>
          </button>
        </div>
      </form>

      <div class="flex items-center gap-1.5 ml-auto">
        @auth
        <a href="{{ route('cart.index') }}" class="relative p-2 rounded-xl hover:bg-orange-50">
          <i class="fas fa-shopping-cart text-gray-600 text-lg"></i>
          <span id="cart-count-badge" class="cart-badge hidden">0</span>
        </a>
        <div class="relative" x-data="{open:false}" @click.away="open=false">
          <button @click="open=!open" class="flex items-center gap-1.5 p-1.5 rounded-xl hover:bg-orange-50">
            <img src="{{ Auth::user()->avatar_url }}" class="w-8 h-8 rounded-full object-cover border-2" style="border-color:#fed7aa">
            <span class="text-sm font-semibold text-gray-700 hidden lg:block max-w-[90px] truncate">{{ Auth::user()->name }}</span>
            <i class="fas fa-chevron-down text-gray-400 text-xs hidden lg:block"></i>
          </button>
          <div x-show="open" x-transition class="absolute right-0 top-full mt-2 w-52 bg-white rounded-xl shadow-xl border py-2 z-50" style="border-color:#ffedd5">
            @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 font-medium"><i class="fas fa-cog text-orange-500 w-4"></i> Admin Panel</a>
            <hr class="my-1" style="border-color:#ffedd5">
            @endif
            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50"><i class="fas fa-home text-orange-400 w-4"></i> Dashboard</a>
            <a href="{{ route('user.orders') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50"><i class="fas fa-clipboard-list text-orange-400 w-4"></i> Pesanan Saya</a>
            <a href="{{ route('user.wishlist') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50"><i class="fas fa-heart text-orange-400 w-4"></i> Wishlist</a>
            <a href="{{ route('user.profile') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50"><i class="fas fa-user text-orange-400 w-4"></i> Profil</a>
            <a href="{{ route('user.addresses') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50"><i class="fas fa-map-marker-alt text-orange-400 w-4"></i> Alamat</a>
            <hr class="my-1" style="border-color:#ffedd5">
            <button onclick="confirmLogout()" class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50"><i class="fas fa-sign-out-alt w-4"></i> Keluar</button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
          </div>
        </div>
        @endauth
        @guest
        <a href="{{ route('login') }}" class="btn-outline py-2 px-3 text-sm hidden sm:flex"><i class="fas fa-sign-in-alt mr-1"></i> Masuk</a>
        <a href="{{ route('register') }}" class="btn-primary py-2 px-3 text-sm hidden sm:flex"><i class="fas fa-user-plus mr-1"></i> Daftar</a>
        @endguest
        <button class="p-2 rounded-xl hover:bg-orange-50 md:hidden" id="mobile-menu-btn" onclick="toggleMobileMenu()">
          <i class="fas fa-bars text-gray-600 text-lg"></i>
        </button>
      </div>
    </div>

    <form action="{{ route('produk.search') }}" method="GET" class="mt-2 md:hidden">
      <div class="relative">
        <input type="text" name="q" placeholder="Cari produk..." value="{{ request('q') }}"
          class="w-full pl-4 pr-12 py-2.5 rounded-xl text-sm"
          style="border:2px solid #fed7aa;background:#fff7ed;outline:none">
        <button type="submit" class="absolute right-0 top-0 bottom-0 px-3.5 text-white rounded-r-xl" style="background:#f97316">
          <i class="fas fa-search text-sm"></i>
        </button>
      </div>
    </form>

    <div class="hidden md:flex items-center gap-0.5 mt-2 overflow-x-auto pb-1 scrollbar-hide">
      <a href="{{ route('produk.index') }}" class="flex-shrink-0 px-3 py-1 rounded-lg text-sm font-medium {{ !request('category')&&request()->routeIs('produk.index')?'bg-orange-100 text-orange-700':'text-gray-600 hover:text-orange-600 hover:bg-orange-50' }}">Semua</a>
      @foreach(\App\Models\Category::where('is_active',true)->orderBy('sort_order')->take(8)->get() as $navCat)
      <a href="{{ route('produk.index',['category'=>$navCat->slug]) }}" class="flex-shrink-0 px-3 py-1 rounded-lg text-sm font-medium whitespace-nowrap {{ request('category')===$navCat->slug?'bg-orange-100 text-orange-700':'text-gray-600 hover:text-orange-600 hover:bg-orange-50' }}">
        {{ $navCat->icon }} {{ $navCat->name }}
      </a>
      @endforeach
      <a href="{{ route('cek-resi') }}" class="flex-shrink-0 px-3 py-1 rounded-lg text-sm font-medium text-blue-600 hover:bg-blue-50">
        <i class="fas fa-box-open mr-1"></i> Cek Resi
      </a>
    </div>
  </nav>

  <div id="mobile-menu" class="hidden md:hidden border-t bg-white" style="border-color:#ffedd5">
    <div class="px-4 py-3 space-y-1">
      @guest
      <div class="flex gap-2 mb-3">
        <a href="{{ route('login') }}" class="btn-outline py-2 px-4 text-sm flex-1 text-center"><i class="fas fa-sign-in-alt mr-1"></i> Masuk</a>
        <a href="{{ route('register') }}" class="btn-primary py-2 px-4 text-sm flex-1 text-center"><i class="fas fa-user-plus mr-1"></i> Daftar</a>
      </div>
      @endguest
      @auth
      <div class="flex items-center gap-3 p-3 rounded-xl mb-2" style="background:#fff7ed">
        <img src="{{ Auth::user()->avatar_url }}" class="w-10 h-10 rounded-full object-cover border-2" style="border-color:#fed7aa">
        <div><p class="font-bold text-gray-800 text-sm">{{ Auth::user()->name }}</p><p class="text-xs text-gray-400">{{ Auth::user()->email }}</p></div>
      </div>
      @if(Auth::user()->isAdmin())
      <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm text-gray-700 hover:bg-orange-50"><i class="fas fa-cog text-orange-500 w-5"></i> Admin Panel</a>
      @endif
      <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm text-gray-700 hover:bg-orange-50"><i class="fas fa-home text-orange-400 w-5"></i> Dashboard</a>
      <a href="{{ route('user.orders') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm text-gray-700 hover:bg-orange-50"><i class="fas fa-clipboard-list text-orange-400 w-5"></i> Pesanan</a>
      <a href="{{ route('cart.index') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm text-gray-700 hover:bg-orange-50"><i class="fas fa-shopping-cart text-orange-400 w-5"></i> Keranjang</a>
      <button onclick="confirmLogout()" class="flex items-center gap-2 w-full px-3 py-2.5 rounded-lg text-sm text-red-600 hover:bg-red-50"><i class="fas fa-sign-out-alt w-5"></i> Keluar</button>
      @endauth
      <hr class="my-2" style="border-color:#ffedd5">
      <div class="grid grid-cols-2 gap-1">
        @foreach(\App\Models\Category::where('is_active',true)->orderBy('sort_order')->take(8)->get() as $mc)
        <a href="{{ route('produk.index',['category'=>$mc->slug]) }}" class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-orange-50">{{ $mc->icon }} {{ $mc->name }}</a>
        @endforeach
      </div>
    </div>
  </div>
</header>

@if(session('success')||session('error'))
<div class="max-w-7xl mx-auto px-4 pt-3">
  @if(session('success'))<div class="alert-success flex items-center gap-2 animate-fade-up"><i class="fas fa-check-circle"></i> {{ session('success') }}<button onclick="this.parentElement.remove()" class="ml-auto"><i class="fas fa-times"></i></button></div>@endif
  @if(session('error'))<div class="alert-error flex items-center gap-2 animate-fade-up"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}<button onclick="this.parentElement.remove()" class="ml-auto"><i class="fas fa-times"></i></button></div>@endif
</div>
@endif

<main class="flex-1">@yield('content')</main>

<footer class="bg-gray-900 text-white mt-16">
  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-4 gap-8">
    <div>
      <div class="flex items-center gap-2 mb-4">
        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:linear-gradient(135deg,#f97316,#ea580c)">
          <i class="fas fa-shopping-bag text-white text-sm"></i>
        </div>
        <span class="font-extrabold">Belanja<span class="text-orange-400">Yuk!</span></span>
      </div>
      <p class="text-gray-400 text-sm mb-4">Toko online terpercaya. Belanja mudah, cepat, aman & terjamin.</p>
      <a href="https://wa.me/{{ env('ADMIN_WHATSAPP','6289514392694') }}" class="btn-wa text-sm">
        <i class="fab fa-whatsapp text-lg"></i> Chat Admin WA
      </a>
    </div>
    <div>
      <h4 class="font-bold text-sm uppercase tracking-wider text-gray-400 mb-4">Kategori</h4>
      <ul class="space-y-2">
        @foreach(\App\Models\Category::where('is_active',true)->take(6)->get() as $fc)
        <li><a href="{{ route('produk.index',['category'=>$fc->slug]) }}" class="text-gray-300 text-sm hover:text-orange-400">{{ $fc->icon }} {{ $fc->name }}</a></li>
        @endforeach
      </ul>
    </div>
    <div>
      <h4 class="font-bold text-sm uppercase tracking-wider text-gray-400 mb-4">Layanan</h4>
      <ul class="space-y-2">
        <li><a href="{{ route('cek-resi') }}" class="text-gray-300 text-sm hover:text-orange-400"><i class="fas fa-box mr-1"></i> Cek Resi</a></li>
        @auth
        <li><a href="{{ route('user.orders') }}" class="text-gray-300 text-sm hover:text-orange-400"><i class="fas fa-clipboard-list mr-1"></i> Pesanan Saya</a></li>
        @else
        <li><a href="{{ route('login') }}" class="text-gray-300 text-sm hover:text-orange-400"><i class="fas fa-sign-in-alt mr-1"></i> Login</a></li>
        @endauth
        <li><a href="{{ route('produk.index',['promo'=>1]) }}" class="text-gray-300 text-sm hover:text-orange-400"><i class="fas fa-fire mr-1"></i> Promo</a></li>
        <li><a href="https://wa.me/{{ env('ADMIN_WHATSAPP','6289514392694') }}" class="text-gray-300 text-sm hover:text-orange-400"><i class="fas fa-comments mr-1"></i> Kontak Kami</a></li>
      </ul>
    </div>
    <div>
      <h4 class="font-bold text-sm uppercase tracking-wider text-gray-400 mb-3">Metode Bayar</h4>
      <div class="grid grid-cols-2 gap-1.5 mb-4">
        @foreach(['BCA','BNI','Mandiri','QRIS'] as $b)
        <div class="bg-gray-800 rounded-lg px-2 py-1.5 text-xs text-center text-gray-300">{{ $b }}</div>
        @endforeach
      </div>
      <h4 class="font-bold text-sm uppercase tracking-wider text-gray-400 mb-3">Kurir</h4>
      <div class="grid grid-cols-3 gap-1">
        @foreach(['JNE','J&T','SiCepat','Anteraja','TIKI','Pos'] as $k)
        <div class="bg-gray-800 rounded-lg px-1.5 py-1 text-xs text-center text-gray-400">{{ $k }}</div>
        @endforeach
      </div>
    </div>
  </div>
  <div class="border-t border-gray-800 py-4 text-center">
    <p class="text-gray-500 text-xs">© {{ date('Y') }} BelanjaYuk! — Made with <i class="fas fa-heart text-orange-500"></i> in Indonesia</p>
  </div>
</footer>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function toggleMobileMenu(){
  const m=document.getElementById('mobile-menu');
  const btn=document.getElementById('mobile-menu-btn');
  m.classList.toggle('hidden');
  btn.innerHTML=m.classList.contains('hidden')
    ?'<i class="fas fa-bars text-gray-600 text-lg"></i>'
    :'<i class="fas fa-times text-gray-600 text-lg"></i>';
}
function confirmLogout(){
  Swal.fire({title:'Keluar?',text:'Yakin mau keluar dari BelanjaYuk?',icon:'question',showCancelButton:true,confirmButtonText:'Ya, Keluar',cancelButtonText:'Batal',confirmButtonColor:'#ef4444',cancelButtonColor:'#f97316'})
  .then(r=>{if(r.isConfirmed)document.getElementById('logout-form').submit()});
}
function updateCartBadge(){
  @auth
  fetch('{{ route("cart.count") }}').then(r=>r.json()).then(d=>{
    const b=document.getElementById('cart-count-badge');
    if(b){if(d.count>0){b.textContent=d.count>99?'99+':d.count;b.classList.remove('hidden');}else b.classList.add('hidden');}
  }).catch(()=>{});
  @endauth
}
updateCartBadge();
</script>
@stack('scripts')
</body>
</html>
