<div class="card card-hover product-card cursor-pointer group">
  {{-- Badge --}}
  @if($product->discount_percent > 0)
  <div class="product-badge">-{{ $product->discount_percent }}%</div>
  @elseif($product->is_new)
  <div class="product-badge" style="background:linear-gradient(135deg,#3b82f6,#2563eb)">Baru</div>
  @elseif($product->is_featured)
  <div class="product-badge" style="background:linear-gradient(135deg,#f59e0b,#d97706)">Unggulan</div>
  @endif

  {{-- Wishlist button --}}
  <button
    onclick="toggleWishlist({{ $product->id }}, this, {{ Auth::check() ? 'true' : 'false' }})"
    class="absolute top-2 right-2 z-10 w-8 h-8 rounded-full bg-white/90 flex items-center justify-center shadow hover:shadow-md transition-all hover:scale-110"
    aria-label="Tambah ke wishlist">
    <svg class="w-4 h-4 {{ Auth::check() && Auth::user()->wishlists()->where('product_id',$product->id)->exists() ? 'text-red-500 fill-red-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
    </svg>
  </button>

  {{-- Product image --}}
  <a href="{{ route('produk.show',$product->slug) }}" class="block overflow-hidden bg-gray-50" style="aspect-ratio:1">
    <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy"
      onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'">
  </a>

  {{-- Product info --}}
  <div class="product-info">
    <a href="{{ route('produk.show',$product->slug) }}">
      <p class="product-category">{{ $product->category->name ?? '' }}</p>
      <h3 class="product-name group-hover:text-orange-600">{{ $product->name }}</h3>
    </a>

    @if($product->reviews->count() > 0)
    <div class="product-rating">
      <svg class="w-3.5 h-3.5 text-yellow-400 fill-yellow-400 flex-shrink-0" viewBox="0 0 20 20">
        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
      </svg>
      <span class="text-xs text-gray-500">{{ number_format($product->average_rating,1) }} ({{ $product->reviews->count() }})</span>
    </div>
    @endif

    <div class="flex items-center gap-2 flex-wrap mt-auto pt-1">
      <span class="product-price">Rp {{ number_format($product->effective_price,0,',','.') }}</span>
      @if($product->sale_price)
      <span class="product-price-old">Rp {{ number_format($product->price,0,',','.') }}</span>
      @endif
    </div>
    @if($product->sold_count > 0)
    <p class="product-sold">{{ number_format($product->sold_count) }} terjual</p>
    @endif
  </div>
</div>

@once
@push('scripts')
<script>
function toggleWishlist(productId, btn, isLoggedIn) {
  // Jika belum login → SweetAlert
  if (!isLoggedIn) {
    Swal.fire({
      icon: 'info',
      title: 'Login Dulu Yuk! 🔐',
      text: 'Kamu perlu login untuk menyimpan produk ke wishlist.',
      showCancelButton: true,
      confirmButtonText: 'Login Sekarang',
      cancelButtonText: 'Oke',
      confirmButtonColor: '#f97316',
      cancelButtonColor: '#6b7280',
    }).then(r => {
      if (r.isConfirmed) window.location.href = '{{ route("login") }}';
    });
    return;
  }

  const svg = btn.querySelector('svg');
  btn.disabled = true;

  fetch('{{ route("wishlist.toggle") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
    },
    body: JSON.stringify({ product_id: productId })
  })
  .then(r => r.json())
  .then(d => {
    if (d.status === 'added') {
      svg.classList.add('text-red-500', 'fill-red-500');
      svg.classList.remove('text-gray-400');
      Swal.fire({
        icon: 'success',
        title: '❤️ Ditambahkan!',
        text: 'Produk berhasil ditambahkan ke wishlist.',
        timer: 1800,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
      });
    } else {
      svg.classList.remove('text-red-500', 'fill-red-500');
      svg.classList.add('text-gray-400');
      Swal.fire({
        icon: 'info',
        title: 'Dihapus dari Wishlist',
        timer: 1500,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
      });
    }
  })
  .catch(() => {
    Swal.fire({icon:'error',title:'Oops!',text:'Terjadi kesalahan, coba lagi.',timer:2000,showConfirmButton:false});
  })
  .finally(() => { btn.disabled = false; });
}
</script>
@endpush
@endonce
