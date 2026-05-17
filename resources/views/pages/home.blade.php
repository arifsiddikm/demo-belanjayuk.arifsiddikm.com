@extends('layouts.app')
@section('title','BelanjaYuk! - Belanja Hemat Kualitas Terjamin')
@section('content')

{{-- ===== HERO CAROUSEL ===== --}}
<section class="relative overflow-hidden" style="background:linear-gradient(135deg,#7c2d12,#c2410c)">
  <div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full opacity-10" style="background:radial-gradient(circle,#fb923c,transparent)"></div>
    <div class="absolute -bottom-20 -left-20 w-80 h-80 rounded-full opacity-10" style="background:radial-gradient(circle,#fbbf24,transparent)"></div>
  </div>
  <div id="hero-slider" class="relative" style="min-height:460px">
    @forelse($banners as $i => $banner)
    <div class="hero-slide {{ $i===0?'active':'' }} absolute inset-0 transition-opacity duration-700"
      @if($banner->image) style="background-image:url({{ $banner->image }});background-size:cover;background-position:center" @endif>
      <div class="absolute inset-0" style="background:linear-gradient(135deg,rgba(124,45,18,.93) 0%,rgba(194,65,12,.78) 55%,rgba(251,146,60,.35) 100%)"></div>
      <div class="relative max-w-7xl mx-auto px-4 py-14 md:py-20 flex items-center min-h-[460px]">
        <div class="grid md:grid-cols-2 gap-10 items-center w-full">
          <div class="text-white z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold mb-4" style="background:rgba(255,255,255,.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.2)">
              <i class="fas fa-fire text-yellow-300"></i> {{ $banner->subtitle ?? 'Penawaran Terbatas' }}
            </div>
            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-5 text-white">{{ $banner->title ?? 'Belanja Hemat!' }}</h1>
            <div class="flex flex-wrap gap-3 mb-6">
              <a href="{{ $banner->link ?? route('produk.index') }}" class="inline-flex items-center gap-2 font-bold px-7 py-3 rounded-xl shadow-xl transition-all hover:-translate-y-0.5" style="background:linear-gradient(135deg,#fff,#fff7ed);color:#ea580c">
                {{ $banner->button_text ?? 'Belanja Sekarang' }} <i class="fas fa-arrow-right"></i>
              </a>
              <a href="{{ route('produk.index') }}" class="inline-flex items-center gap-2 font-semibold px-6 py-3 rounded-xl" style="background:rgba(255,255,255,.12);border:1.5px solid rgba(255,255,255,.3);color:#fff">
                <i class="fas fa-th-large"></i> Lihat Katalog
              </a>
            </div>
            <div class="flex gap-6">
              @foreach([['10K+','Produk'],['50K+','Pembeli'],['4.9★','Rating']] as [$n,$l])
              <div><p class="text-lg font-extrabold text-white">{{ $n }}</p><p class="text-xs text-orange-200">{{ $l }}</p></div>
              @endforeach
            </div>
          </div>
          {{-- Floating promo card --}}
          <div class="hidden md:flex justify-center items-center">
            <div class="relative w-68">
              <div class="bg-white rounded-2xl shadow-2xl p-5 relative z-10" style="width:280px">
                <div class="flex items-center gap-3 mb-4">
                  <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#f97316,#ea580c)">
                    <i class="fas fa-bolt text-white"></i>
                  </div>
                  <div><p class="font-bold text-sm text-gray-800">Flash Sale</p>
                    <div class="flex gap-1 mt-0.5">
                      @foreach(['hh','mm','ss'] as $u)
                      <span class="text-xs font-extrabold px-1.5 py-0.5 rounded" style="background:#fff7ed;color:#ea580c" id="cnt-{{ $u }}">00</span>
                      @endforeach
                    </div>
                  </div>
                </div>
                @foreach($featuredProducts->take(3) as $fp)
                <div class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-orange-50 transition-colors">
                  <img src="{{ $fp->thumbnail_url }}" class="w-10 h-10 rounded-lg object-cover" onerror="this.src='https://via.placeholder.com/40'">
                  <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-gray-700 truncate">{{ $fp->name }}</p>
                    <p class="text-xs font-bold" style="color:#f97316">Rp {{ number_format($fp->effective_price,0,',','.') }}</p>
                  </div>
                  @if($fp->discount_percent>0)<span class="text-xs font-bold text-white px-1.5 py-0.5 rounded-full flex-shrink-0" style="background:#ef4444">-{{ $fp->discount_percent }}%</span>@endif
                </div>
                @endforeach
              </div>
              <div class="absolute -top-3 -right-3 text-yellow-900 text-xs font-extrabold px-3 py-1.5 rounded-full shadow-lg z-20 animate-bounce" style="background:#fbbf24">🎉 PROMO!</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @empty
    <div class="hero-slide active" style="background:linear-gradient(135deg,#c2410c,#f97316)">
      <div class="max-w-7xl mx-auto px-4 py-24 text-white text-center min-h-[460px] flex flex-col justify-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Selamat Datang di BelanjaYuk! <i class="fas fa-shopping-bag"></i></h1>
        <a href="{{ route('produk.index') }}" class="bg-white font-bold px-8 py-3.5 rounded-xl shadow-lg inline-flex items-center gap-2 mx-auto" style="color:#ea580c">Mulai Belanja <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
    @endforelse
  </div>
  @if($banners->count()>1)
  <button onclick="prevSlide()" class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full flex items-center justify-center z-20 text-white" style="background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.25)"><i class="fas fa-chevron-left"></i></button>
  <button onclick="nextSlide()" class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full flex items-center justify-center z-20 text-white" style="background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.25)"><i class="fas fa-chevron-right"></i></button>
  <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-20">
    @foreach($banners as $i=>$b)<button onclick="goSlide({{ $i }})" class="slider-dot rounded-full transition-all {{ $i===0?'w-7 h-2.5':'w-2.5 h-2.5' }}" style="{{ $i===0?'background:#fff':'background:rgba(255,255,255,.4)' }}"></button>@endforeach
  </div>
  @endif
  <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full" preserveAspectRatio="none"><path d="M0,40 C360,0 1080,0 1440,40 L1440,40 L0,40 Z" fill="#fff8f5"/></svg></div>
</section>

{{-- ===== KATEGORI SHOPEE-STYLE ===== --}}
<section class="max-w-7xl mx-auto px-4 pt-8 pb-6">
  <div class="flex items-center justify-between mb-5">
    <h2 class="section-title">Kategori</h2>
    <a href="{{ route('produk.index') }}" class="text-sm font-semibold flex items-center gap-1" style="color:#f97316">Lihat Semua <i class="fas fa-chevron-right text-xs"></i></a>
  </div>
  {{-- Grid Shopee-style dengan 2 baris --}}
  <div class="bg-white rounded-2xl shadow-sm border overflow-hidden" style="border-color:#fff0e8">
    <div class="grid grid-cols-4 md:grid-cols-8 divide-x divide-y" style="border-color:#fff0e8">
      @foreach($categories as $i => $cat)
      <a href="{{ route('produk.index',['category'=>$cat->slug]) }}"
        class="group flex flex-col items-center gap-2 p-4 hover:bg-orange-50 transition-all {{ $i >= 4 ? 'border-t' : '' }}"
        style="{{ $i >= 4 ? 'border-top-color:#fff0e8' : '' }}">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl bg-gradient-to-br transition-all group-hover:scale-110" style="background:linear-gradient(135deg,#ffedd5,#fed7aa)">
          {{ $cat->icon ?? '🛍️' }}
        </div>
        <span class="text-xs font-semibold text-gray-700 text-center leading-tight">{{ $cat->name }}</span>
        @if($cat->active_products_count ?? false)
        <span class="text-xs text-gray-400">{{ $cat->active_products_count }}</span>
        @endif
      </a>
      @endforeach
    </div>
  </div>
</section>

{{-- ===== FLASH SALE ===== --}}
@if($flashSaleProducts->count())
<section class="max-w-7xl mx-auto px-4 pb-8">
  <div class="rounded-2xl overflow-hidden shadow-sm" style="background:linear-gradient(135deg,#f97316,#ef4444)">
    {{-- Header flash sale --}}
    <div class="px-5 py-3.5 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <span class="text-white font-extrabold text-lg flex items-center gap-1.5">
          <i class="fas fa-bolt text-yellow-300"></i> FLASH SALE
        </span>
        <div class="flex gap-1 items-center">
          <span class="text-xs text-orange-100 mr-1">Berakhir:</span>
          @foreach(['fs-hh','fs-mm','fs-ss'] as $id)
          <span id="{{ $id }}" class="text-sm font-extrabold px-2 py-0.5 rounded text-orange-800" style="background:#fff">00</span>
          @if(!$loop->last)<span class="text-white font-bold">:</span>@endif
          @endforeach
        </div>
      </div>
      <a href="{{ route('produk.index',['promo'=>1]) }}" class="text-sm font-semibold text-white flex items-center gap-1 hover:underline">
        Lihat Semua <i class="fas fa-chevron-right text-xs"></i>
      </a>
    </div>
    {{-- Produk flash sale - horizontal scroll --}}
    <div class="bg-white px-4 py-4">
      <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide" style="scrollbar-width:none">
        @foreach($flashSaleProducts->take(10) as $product)
        <a href="{{ route('produk.show',$product->slug) }}" class="flex-shrink-0 w-36 group">
          <div class="relative rounded-xl overflow-hidden mb-2" style="aspect-ratio:1">
            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @if($product->discount_percent>0)
            <div class="absolute top-1.5 left-1.5 text-white text-xs font-bold px-1.5 py-0.5 rounded-md" style="background:#ef4444">-{{ $product->discount_percent }}%</div>
            @endif
          </div>
          <p class="text-xs font-semibold text-gray-800 line-clamp-2 mb-1">{{ $product->name }}</p>
          <p class="text-sm font-extrabold" style="color:#f97316">Rp {{ number_format($product->effective_price,0,',','.') }}</p>
          @if($product->sale_price)<p class="text-xs text-gray-400 line-through">Rp {{ number_format($product->price,0,',','.') }}</p>@endif
        </a>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif

{{-- ===== BANNER PROMO dengan background image ===== --}}
<section class="max-w-7xl mx-auto px-4 pb-8">
  <div class="grid md:grid-cols-3 gap-4">
    {{-- Banner besar --}}
    <div class="md:col-span-2 relative overflow-hidden rounded-2xl min-h-[160px] flex items-center"
      style="background:linear-gradient(135deg,#f97316,#ef4444);background-image:url(https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=800);background-size:cover;background-position:center">
      <div class="absolute inset-0" style="background:linear-gradient(135deg,rgba(249,115,22,.88),rgba(239,68,68,.75))"></div>
      <div class="relative z-10 p-7 text-white">
        <div class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full mb-2" style="background:rgba(255,255,255,.2)">
          <i class="fas fa-bolt text-yellow-300"></i> Flash Sale
        </div>
        <h3 class="text-2xl font-extrabold mb-1">Diskon Hingga 70%!</h3>
        <p class="text-sm text-orange-100 mb-3">Produk fashion & elektronik pilihan harga gila-gilaan</p>
        <a href="{{ route('produk.index',['promo'=>1]) }}" class="inline-flex items-center gap-2 font-bold text-sm px-5 py-2.5 rounded-xl hover:bg-orange-50 transition-all" style="background:#fff;color:#ea580c">
          Belanja Sekarang <i class="fas fa-arrow-right"></i>
        </a>
      </div>
      <div class="absolute right-6 bottom-0 text-8xl opacity-30">🔥</div>
    </div>
    {{-- Banner kecil --}}
    <div class="relative overflow-hidden rounded-2xl min-h-[160px] flex items-center"
      style="background:linear-gradient(135deg,#7c3aed,#3b82f6);background-image:url(https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400);background-size:cover;background-position:center">
      <div class="absolute inset-0" style="background:linear-gradient(135deg,rgba(124,58,237,.85),rgba(59,130,246,.75))"></div>
      <div class="relative z-10 p-6 text-white">
        <i class="fas fa-star text-yellow-300 text-2xl mb-2 block"></i>
        <p class="text-xs font-bold text-blue-200 mb-1">KOLEKSI TERBARU</p>
        <h3 class="text-xl font-extrabold mb-3">New Arrival!</h3>
        <a href="{{ route('produk.index',['sort'=>'newest']) }}" class="inline-flex items-center gap-1 text-sm font-bold px-4 py-2 rounded-xl" style="background:#fff;color:#7c3aed">
          Lihat Koleksi <i class="fas fa-chevron-right text-xs"></i>
        </a>
      </div>
    </div>
  </div>
</section>

{{-- ===== PRODUK UNGGULAN (30 produk, grid penuh) ===== --}}
@if($featuredProducts->count())
<section class="max-w-7xl mx-auto px-4 pb-10">
  <div class="flex items-center justify-between mb-5">
    <div>
      <h2 class="section-title"><i class="fas fa-star text-yellow-500 mr-1"></i> Produk Unggulan</h2>
      <p class="text-sm text-gray-500 mt-1">Pilihan terbaik yang paling diminati</p>
    </div>
    <a href="{{ route('produk.index',['featured'=>1]) }}" class="text-sm font-semibold flex items-center gap-1" style="color:#f97316">Lihat Semua <i class="fas fa-chevron-right text-xs"></i></a>
  </div>
  {{-- Grid 30 produk --}}
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
    @foreach($featuredProducts as $product)
    @include('components.product-card',['product'=>$product])
    @endforeach
  </div>
  <div class="text-center mt-6">
    <a href="{{ route('produk.index') }}" class="btn-primary px-8 py-3">
      <i class="fas fa-shopping-bag mr-2"></i> Lihat Semua Produk
    </a>
  </div>
</section>
@endif

{{-- ===== TERLARIS ===== --}}
@if($bestSellers->count())
<section class="py-10" style="background:linear-gradient(to bottom right,#fff7ed,#fff)">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center justify-between mb-5">
      <h2 class="section-title"><i class="fas fa-trophy text-yellow-500 mr-1"></i> Produk Terlaris</h2>
      <a href="{{ route('produk.index',['sort'=>'bestseller']) }}" class="text-sm font-semibold flex items-center gap-1" style="color:#f97316">Lihat Semua <i class="fas fa-chevron-right text-xs"></i></a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
      @foreach($bestSellers as $product)
      @include('components.product-card',['product'=>$product])
      @endforeach
    </div>
    <div class="text-center mt-7">
      <a href="{{ route('produk.index') }}"
        class="inline-flex items-center gap-2 font-bold px-8 py-3.5 rounded-xl border-2 transition-all"
        style="border-color:#f97316;color:#ea580c"
        onmouseover="this.style.background='#f97316';this.style.color='#fff'"
        onmouseout="this.style.background='transparent';this.style.color='#ea580c'">
        <i class="fas fa-shopping-bag"></i> Lihat Produk Lainnya <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>
</section>
@endif

@endsection
@push('scripts')
<script>
// Slider
let cur=0;const slides=document.querySelectorAll('.hero-slide');const dots=document.querySelectorAll('.slider-dot');
slides.forEach((s,i)=>{s.style.opacity=i===0?'1':'0';});
function goSlide(n){slides[cur].classList.remove('active');slides[cur].style.opacity='0';if(dots[cur]){dots[cur].classList.remove('w-7');dots[cur].style.background='rgba(255,255,255,.4)';}cur=(n+slides.length)%slides.length;slides[cur].classList.add('active');slides[cur].style.opacity='1';if(dots[cur]){dots[cur].classList.add('w-7');dots[cur].style.background='#fff';}}
function nextSlide(){goSlide(cur+1);}function prevSlide(){goSlide(cur-1);}
if(slides.length>1)setInterval(nextSlide,5500);
// Countdown
function startCountdown(hhId,mmId,ssId){function upd(){const now=new Date(),end=new Date(now);end.setHours(23,59,59,0);const diff=Math.max(0,end-now);const pad=v=>String(v).padStart(2,'0');const h=document.getElementById(hhId),m=document.getElementById(mmId),s=document.getElementById(ssId);if(h)h.textContent=pad(Math.floor(diff/3600000));if(m)m.textContent=pad(Math.floor((diff%3600000)/60000));if(s)s.textContent=pad(Math.floor((diff%60000)/1000));}upd();setInterval(upd,1000);}
startCountdown('cnt-hh','cnt-mm','cnt-ss');
startCountdown('fs-hh','fs-mm','fs-ss');
</script>
@endpush
