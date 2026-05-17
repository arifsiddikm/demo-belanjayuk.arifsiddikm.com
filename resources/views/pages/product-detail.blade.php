@extends('layouts.app')
@section('title',$product->name.' - BelanjaYuk!')
@push('head-scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
@endpush
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

  {{-- Breadcrumb --}}
  <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6 flex-wrap">
    <a href="{{ route('home') }}" class="hover:text-orange-600">Home</a>
    <i class="fas fa-chevron-right text-xs"></i>
    <a href="{{ route('produk.index',['category'=>$product->category->slug]) }}" class="hover:text-orange-600">{{ $product->category->name }}</a>
    <i class="fas fa-chevron-right text-xs"></i>
    <span class="text-gray-700 font-medium max-w-xs truncate">{{ $product->name }}</span>
  </nav>

  <div class="grid md:grid-cols-2 gap-10">

    {{-- ===== LEFT: IMAGE SWIPER ===== --}}
    <div>
      {{-- Main Swiper --}}
      <div class="swiper main-swiper rounded-2xl overflow-hidden border shadow-sm mb-3" style="aspect-ratio:1">
        <div class="swiper-wrapper">
          {{-- Thumbnail sebagai slide pertama --}}
          <div class="swiper-slide">
            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
          </div>
          {{-- Gambar tambahan dari product_images --}}
          @if($product->images->count())
            @foreach($product->images as $img)
            <div class="swiper-slide">
              <img src="{{ $img->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            </div>
            @endforeach
          @else
            {{-- Dummy images jika tidak ada gambar tambahan (dari Unsplash sesuai kategori) --}}
            @php
              $dummyImages = [
                $product->thumbnail_url,
                'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=600&q=80',
                'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80',
                'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=600&q=80',
              ];
            @endphp
            @foreach(array_slice($dummyImages, 1) as $dImg)
            <div class="swiper-slide">
              <img src="{{ $dImg }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            </div>
            @endforeach
          @endif
        </div>
        <div class="swiper-button-next" style="color:#f97316"></div>
        <div class="swiper-button-prev" style="color:#f97316"></div>
        <div class="swiper-pagination"></div>
      </div>

      {{-- Thumbnail Swiper (bawah) --}}
      <div class="swiper thumb-swiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide cursor-pointer rounded-xl overflow-hidden border-2 border-transparent hover:border-orange-400 transition-all" style="aspect-ratio:1">
            <img src="{{ $product->thumbnail_url }}" class="w-full h-full object-cover">
          </div>
          @if($product->images->count())
            @foreach($product->images as $img)
            <div class="swiper-slide cursor-pointer rounded-xl overflow-hidden border-2 border-transparent hover:border-orange-400 transition-all" style="aspect-ratio:1">
              <img src="{{ $img->image_url }}" class="w-full h-full object-cover">
            </div>
            @endforeach
          @else
            @php $thumbDummies = ['https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=120&q=80','https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=120&q=80','https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=120&q=80']; @endphp
            @foreach($thumbDummies as $td)
            <div class="swiper-slide cursor-pointer rounded-xl overflow-hidden border-2 border-transparent hover:border-orange-400 transition-all" style="aspect-ratio:1">
              <img src="{{ $td }}" class="w-full h-full object-cover">
            </div>
            @endforeach
          @endif
        </div>
      </div>

      {{-- Share + Wishlist Row --}}
      <div class="flex items-center justify-between mt-4">
        <div class="flex items-center gap-2">
          <span class="text-sm text-gray-500 font-medium">Share:</span>
          @php $shareUrl = urlencode(request()->url()); $shareTitle = urlencode($product->name.' - BelanjaYuk!'); @endphp
          <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank"
            class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-all text-sm">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank"
            class="w-8 h-8 rounded-full bg-black text-white flex items-center justify-center hover:bg-gray-800 transition-all text-sm">
            <i class="fab fa-x-twitter"></i>
          </a>
          <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank"
            class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center hover:bg-green-600 transition-all text-sm">
            <i class="fab fa-whatsapp"></i>
          </a>
          <a href="https://pinterest.com/pin/create/button/?url={{ $shareUrl }}&description={{ $shareTitle }}" target="_blank"
            class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center hover:bg-red-700 transition-all text-sm">
            <i class="fab fa-pinterest-p"></i>
          </a>
          <button onclick="copyLink()" class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-gray-200 transition-all text-sm" title="Salin link">
            <i class="fas fa-link"></i>
          </button>
        </div>
        {{-- Favorit count --}}
        <div class="flex items-center gap-1.5 text-gray-500 text-sm">
          <i class="fas fa-heart text-red-400"></i>
          <span>{{ rand(100, 5000) }} favorit</span>
        </div>
      </div>
    </div>

    {{-- ===== RIGHT: PRODUCT INFO ===== --}}
    <div>
      <p class="text-xs font-bold mb-2 px-2 py-0.5 rounded inline-block" style="background:#fff7ed;color:#f97316">{{ $product->category->name }}</p>
      <h1 class="text-2xl font-extrabold text-gray-900 mb-3 leading-tight">{{ $product->name }}</h1>

      {{-- Rating & Sold --}}
      <div class="flex items-center gap-4 mb-5 pb-5 border-b border-gray-100">
        @if($product->reviews->count())
        <div class="flex items-center gap-1.5">
          @for($s=1;$s<=5;$s++)
          <i class="fas fa-star text-sm {{ $s<=round($product->average_rating)?'text-yellow-400':'text-gray-200' }}"></i>
          @endfor
          <span class="text-sm font-bold text-gray-700">{{ number_format($product->average_rating,1) }}</span>
          <a href="#reviews" class="text-sm text-gray-400 hover:underline">({{ $product->reviews->count() }} ulasan)</a>
        </div>
        @endif
        <span class="text-sm text-gray-400"><i class="fas fa-shopping-bag text-orange-300 mr-1"></i>{{ number_format($product->sold_count) }} terjual</span>
        @if($product->views)<span class="text-sm text-gray-400"><i class="fas fa-eye text-orange-300 mr-1"></i>{{ number_format($product->views) }}</span>@endif
      </div>

      {{-- Harga --}}
      <div class="mb-5">
        @if($product->sale_price)
        <div class="flex items-center gap-3 flex-wrap">
          <span class="text-3xl font-extrabold" style="color:#f97316">Rp {{ number_format($product->sale_price,0,',','.') }}</span>
          <span class="text-lg text-gray-400 line-through">Rp {{ number_format($product->price,0,',','.') }}</span>
          <span class="text-sm font-bold text-white px-2.5 py-1 rounded-lg" style="background:#ef4444">-{{ $product->discount_percent }}%</span>
        </div>
        @else
        <span class="text-3xl font-extrabold" style="color:#f97316">Rp {{ number_format($product->price,0,',','.') }}</span>
        @endif
      </div>

      @if($product->short_description)
      <p class="text-gray-600 text-sm mb-5 leading-relaxed">{{ $product->short_description }}</p>
      @endif

      {{-- Varian --}}
      @if($product->variants->count())
      @foreach($product->variants->groupBy('name') as $vName=>$variants)
      <div class="mb-5">
        <label class="form-label flex items-center gap-1"><i class="fas fa-tag text-orange-400 text-xs"></i> Pilih {{ $vName }}:</label>
        <div class="flex flex-wrap gap-2">
          @foreach($variants as $v)
          <button type="button" onclick="selectVariant(this,{{ $v->id }},{{ $v->price_adjustment }})"
            class="variant-btn px-4 py-2 rounded-xl border-2 border-gray-200 text-sm font-semibold text-gray-700 hover:border-orange-400 transition-all {{ $v->stock<=0?'opacity-50 cursor-not-allowed':'' }}"
            {{ $v->stock<=0?'disabled':'' }}>
            {{ $v->value }}
            @if($v->price_adjustment>0)<span class="text-xs font-normal ml-1" style="color:#f97316">+{{ number_format($v->price_adjustment,0,',','.') }}</span>@endif
          </button>
          @endforeach
        </div>
      </div>
      @endforeach
      @endif

      {{-- Jumlah --}}
      <div class="mb-6">
        <label class="form-label flex items-center gap-1"><i class="fas fa-sort-numeric-up text-orange-400 text-xs"></i> Jumlah:</label>
        <div class="flex items-center gap-3">
          <div class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
            <button onclick="changeQty(-1)" class="w-10 h-10 flex items-center justify-center hover:bg-gray-50 text-xl font-bold text-gray-600">−</button>
            <input type="number" id="qty" value="1" min="1" max="{{ $product->stock }}"
              class="w-14 text-center font-bold text-gray-800 h-10 focus:outline-none border-x-2 border-gray-200">
            <button onclick="changeQty(1)" class="w-10 h-10 flex items-center justify-center hover:bg-gray-50 text-xl font-bold text-gray-600">+</button>
          </div>
          <span class="text-sm text-gray-500">
            Stok: <strong class="{{ $product->stock<10?'text-red-600':'text-gray-800' }}">{{ $product->stock }}</strong>
          </span>
        </div>
      </div>

      {{-- CTA Buttons --}}
      <div class="flex gap-3 mb-6">
        @auth
        <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <input type="hidden" name="product_variant_id" id="sel-variant" value="">
          <input type="hidden" name="quantity" id="cart-qty" value="1">
          <button type="submit" class="btn-outline w-full py-3 text-base">
            <i class="fas fa-shopping-cart mr-2"></i> Keranjang
          </button>
        </form>
        <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <input type="hidden" name="product_variant_id" id="sel-variant2" value="">
          <input type="hidden" name="quantity" id="buy-qty" value="1">
          <input type="hidden" name="redirect_checkout" value="1">
          <button type="submit" class="btn-primary w-full py-3 text-base">
            <i class="fas fa-bolt mr-2"></i> Beli Sekarang
          </button>
        </form>
        @else
        <a href="{{ route('login') }}" class="btn-primary flex-1 py-3 text-base text-center">
          <i class="fas fa-sign-in-alt mr-2"></i> Login untuk Beli
        </a>
        @endauth
      </div>

      {{-- Wishlist button --}}
      <button onclick="toggleWishlist({{ $product->id }}, this, {{ Auth::check() ? 'true' : 'false' }})"
        class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-red-500 transition-colors w-full justify-center py-2 rounded-xl border border-gray-200 hover:border-red-300">
        <i class="fas fa-heart {{ Auth::check() && Auth::user()->wishlists()->where('product_id',$product->id)->exists() ? 'text-red-500' : 'text-gray-300' }}"></i>
        Tambah ke Wishlist
      </button>

      {{-- Info --}}
      <div class="mt-5 pt-5 border-t border-gray-100 grid grid-cols-3 gap-3 text-center">
        @foreach([['fas fa-shield-alt','Garansi Asli'],['fas fa-undo','Return 7 hari'],['fas fa-shipping-fast','Kirim Cepat']] as [$icon,$label])
        <div class="p-2 rounded-xl" style="background:#fff7ed">
          <i class="{{ $icon }} text-orange-500 text-lg mb-1 block"></i>
          <p class="text-xs text-gray-600 font-medium">{{ $label }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  {{-- ===== DESKRIPSI & REVIEW ===== --}}
  <div class="grid lg:grid-cols-3 gap-8 mt-10">
    <div class="lg:col-span-2">
      <div class="card p-6 mb-6">
        <h3 class="text-lg font-extrabold text-gray-800 mb-4 flex items-center gap-2">
          <i class="fas fa-align-left text-orange-500"></i> Deskripsi Produk
        </h3>
        <div class="prose prose-sm max-w-none text-gray-600 text-sm leading-relaxed desc-content">
          {!! $product->description !!}
        </div>
      </div>

      {{-- Reviews --}}
      <div id="reviews" class="card p-6">
        <h3 class="text-lg font-extrabold text-gray-800 mb-2 flex items-center gap-2">
          <i class="fas fa-star text-yellow-400"></i> Ulasan Pelanggan
        </h3>
        @if($product->reviews->count())
        <div class="flex items-center gap-5 mb-6 pb-5 border-b border-gray-100">
          <div class="text-center">
            <p class="text-5xl font-extrabold" style="color:#f97316">{{ number_format($product->average_rating,1) }}</p>
            <div class="flex gap-0.5 justify-center my-1">
              @for($s=1;$s<=5;$s++)
              <i class="fas fa-star text-sm {{ $s<=round($product->average_rating)?'text-yellow-400':'text-gray-200' }}"></i>
              @endfor
            </div>
            <p class="text-xs text-gray-400">{{ $product->reviews->count() }} ulasan</p>
          </div>
          <div class="flex-1">
            @for($star=5;$star>=1;$star--)
            @php $count = $product->reviews->where('rating',$star)->count(); $pct = $product->reviews->count() ? ($count/$product->reviews->count())*100 : 0; @endphp
            <div class="flex items-center gap-2 mb-1">
              <span class="text-xs text-gray-500 w-3">{{ $star }}</span>
              <i class="fas fa-star text-yellow-400 text-xs"></i>
              <div class="flex-1 h-2 rounded-full bg-gray-100 overflow-hidden">
                <div class="h-full rounded-full" style="width:{{ $pct }}%;background:#f97316"></div>
              </div>
              <span class="text-xs text-gray-400 w-5">{{ $count }}</span>
            </div>
            @endfor
          </div>
        </div>
        <div class="space-y-5">
          @foreach($product->reviews->sortByDesc('created_at')->take(10) as $rev)
          <div class="border-b border-gray-50 pb-5 last:border-0">
            <div class="flex items-center gap-3 mb-2">
              <img src="{{ $rev->user->avatar_url }}" class="w-9 h-9 rounded-full object-cover border-2" style="border-color:#fed7aa">
              <div>
                <p class="font-semibold text-gray-800 text-sm">{{ $rev->user->name }}</p>
                <p class="text-xs text-gray-400">{{ $rev->created_at->diffForHumans() }}</p>
              </div>
              <div class="ml-auto flex gap-0.5">
                @for($s=1;$s<=5;$s++)<i class="fas fa-star text-xs {{ $s<=$rev->rating?'text-yellow-400':'text-gray-200' }}"></i>@endfor
              </div>
            </div>
            @if($rev->comment)<p class="text-sm text-gray-600 leading-relaxed">{{ $rev->comment }}</p>@endif
            {{-- Review images --}}
            @php $imgs = $rev->all_images ?? []; @endphp
            @if(!empty($imgs))
            <div class="flex gap-2 mt-2 flex-wrap">
              @foreach($imgs as $img)
              <a href="{{ Str::startsWith($img,'http') ? $img : asset('storage/'.$img) }}" target="_blank">
                <img src="{{ Str::startsWith($img,'http') ? $img : asset('storage/'.$img) }}"
                  class="w-16 h-16 object-cover rounded-lg border cursor-pointer hover:opacity-80 transition-opacity">
              </a>
              @endforeach
            </div>
            @endif
          </div>
          @endforeach
        </div>
        @else
        <div class="text-center py-10 text-gray-400">
          <i class="fas fa-comment-slash text-3xl mb-3 block text-gray-200"></i>
          <p class="text-sm">Belum ada ulasan untuk produk ini</p>
          <p class="text-xs mt-1">Jadilah yang pertama membeli & mengulas!</p>
        </div>
        @endif
      </div>
    </div>

    {{-- Produk Serupa --}}
    <div>
      <h3 class="text-base font-extrabold text-gray-800 mb-4 flex items-center gap-2">
        <i class="fas fa-th-large text-orange-500"></i> Produk Serupa
      </h3>
      <div class="space-y-3">
        @foreach($relatedProducts->take(5) as $rp)
        <a href="{{ route('produk.show',$rp->slug) }}" class="flex gap-3 p-3 rounded-xl hover:bg-orange-50 transition-all card-hover card">
          <img src="{{ $rp->thumbnail_url }}" class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
          <div class="flex-1 min-w-0">
            <p class="text-xs font-semibold text-gray-800 line-clamp-2">{{ $rp->name }}</p>
            @if($rp->reviews->count())
            <div class="flex gap-0.5 my-1">@for($s=1;$s<=5;$s++)<i class="fas fa-star text-xs {{ $s<=round($rp->average_rating)?'text-yellow-400':'text-gray-200' }}"></i>@endfor</div>
            @endif
            <p class="text-sm font-extrabold" style="color:#f97316">Rp {{ number_format($rp->effective_price,0,',','.') }}</p>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
// ===== SWIPER INIT =====
const thumbSwiper = new Swiper('.thumb-swiper', {
  spaceBetween: 8,
  slidesPerView: 5,
  freeMode: true,
  watchSlidesProgress: true,
});
const mainSwiper = new Swiper('.main-swiper', {
  spaceBetween: 0,
  navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
  pagination: { el: '.swiper-pagination', clickable: true },
  thumbs: { swiper: thumbSwiper },
  loop: false,
});

// ===== VARIANT =====
let selectedVariant = null;
let basePrice = {{ $product->effective_price }};
function selectVariant(btn, id, adj) {
  document.querySelectorAll('.variant-btn').forEach(b => {
    b.style.borderColor = ''; b.style.background = ''; b.style.color = '';
  });
  btn.style.borderColor = '#f97316'; btn.style.background = '#fff7ed'; btn.style.color = '#ea580c';
  selectedVariant = id;
  document.getElementById('sel-variant').value  = id;
  document.getElementById('sel-variant2').value = id;
}

// ===== QTY =====
function changeQty(delta) {
  const inp = document.getElementById('qty');
  const max = parseInt(inp.max) || 99;
  const newVal = Math.max(1, Math.min(max, parseInt(inp.value||1) + delta));
  inp.value = newVal;
  document.getElementById('cart-qty').value = newVal;
  document.getElementById('buy-qty').value  = newVal;
}
document.getElementById('qty')?.addEventListener('input', function() {
  document.getElementById('cart-qty').value = this.value;
  document.getElementById('buy-qty').value  = this.value;
});

// ===== WISHLIST =====
function toggleWishlist(productId, btn, isLoggedIn) {
  if (!isLoggedIn) {
    Swal.fire({
      icon: 'info', title: 'Login Dulu! 🔐',
      text: 'Kamu perlu login untuk menyimpan ke wishlist.',
      showCancelButton: true, confirmButtonText: 'Login Sekarang', cancelButtonText: 'Oke',
      confirmButtonColor: '#f97316', cancelButtonColor: '#6b7280',
    }).then(r => { if (r.isConfirmed) window.location.href = '{{ route("login") }}'; });
    return;
  }
  btn.disabled = true;
  const icon = btn.querySelector('i');
  fetch('{{ route("wishlist.toggle") }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
    body: JSON.stringify({ product_id: productId })
  })
  .then(r => r.json())
  .then(d => {
    if (d.status === 'added') {
      icon.classList.add('text-red-500'); icon.classList.remove('text-gray-300');
      Swal.fire({ icon:'success', title:'❤️ Ditambahkan!', toast:true, position:'top-end', timer:1800, showConfirmButton:false });
    } else {
      icon.classList.remove('text-red-500'); icon.classList.add('text-gray-300');
      Swal.fire({ icon:'info', title:'Dihapus dari wishlist', toast:true, position:'top-end', timer:1500, showConfirmButton:false });
    }
  })
  .catch(() => { Swal.fire({icon:'error',title:'Oops!',text:'Coba lagi.',timer:2000,showConfirmButton:false}); })
  .finally(() => { btn.disabled = false; });
}

// ===== COPY LINK =====
function copyLink() {
  navigator.clipboard.writeText(window.location.href).then(() => {
    Swal.fire({ icon:'success', title:'Link disalin!', toast:true, position:'top-end', timer:1500, showConfirmButton:false });
  });
}

// Style Swiper thumbs active
document.querySelectorAll('.thumb-swiper .swiper-slide').forEach((slide, i) => {
  slide.addEventListener('click', () => mainSwiper.slideTo(i));
});
mainSwiper.on('slideChange', () => {
  document.querySelectorAll('.thumb-swiper .swiper-slide').forEach((s, i) => {
    s.style.borderColor = i === mainSwiper.activeIndex ? '#f97316' : '';
  });
});
// Set first thumb active
if (document.querySelector('.thumb-swiper .swiper-slide')) {
  document.querySelector('.thumb-swiper .swiper-slide').style.borderColor = '#f97316';
}
</script>
@endpush
