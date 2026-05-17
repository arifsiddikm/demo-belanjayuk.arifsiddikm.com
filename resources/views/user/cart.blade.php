@extends('layouts.app')
@section('title','Keranjang Belanja - BelanjaYuk!')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
  <h1 class="text-2xl font-extrabold text-gray-900 mb-7">🛒 Keranjang Belanja</h1>
  @if($cartItems->isEmpty())
  <div class="text-center py-24"><div class="text-7xl mb-5">🛒</div><h2 class="text-xl font-bold text-gray-700 mb-2">Keranjang kamu kosong</h2><a href="{{ route('produk.index') }}" class="btn-primary px-8 py-3 text-base mt-4">Mulai Belanja</a></div>
  @else
  <div class="grid lg:grid-cols-3 gap-7">
    <div class="lg:col-span-2 space-y-4">
      @foreach($cartItems as $item)
      <div class="card p-5 flex gap-4" id="ci-{{ $item->id }}">
        <a href="{{ route('produk.show',$item->product->slug) }}" class="flex-shrink-0"><img src="{{ $item->product->thumbnail_url }}" class="w-20 h-20 object-cover rounded-xl border" onerror="this.src='https://via.placeholder.com/80'"></a>
        <div class="flex-1 min-w-0">
          <a href="{{ route('produk.show',$item->product->slug) }}" class="font-semibold text-gray-800 hover:text-green-700 text-sm line-clamp-2">{{ $item->product->name }}</a>
          @if($item->variant)<p class="text-xs text-gray-400 mt-0.5">{{ $item->variant->name }}: {{ $item->variant->value }}</p>@endif
          <p class="font-bold text-green-700 mt-1 text-sm">Rp {{ number_format($item->product->effective_price+($item->variant?$item->variant->price_adjustment:0),0,',','.') }}</p>
          <div class="flex items-center justify-between mt-3">
            <div class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
              <button onclick="updateQty({{ $item->id }},-1)" class="w-8 h-8 flex items-center justify-center hover:bg-gray-50 font-bold text-gray-600">−</button>
              <span id="qty-{{ $item->id }}" class="w-10 text-center font-bold text-sm">{{ $item->quantity }}</span>
              <button onclick="updateQty({{ $item->id }},1)" class="w-8 h-8 flex items-center justify-center hover:bg-gray-50 font-bold text-gray-600">+</button>
            </div>
            <p class="font-extrabold text-green-700 text-sm" id="sub-{{ $item->id }}">Rp {{ number_format($item->subtotal,0,',','.') }}</p>
            <form action="{{ route('cart.remove',$item->id) }}" method="POST" class="inline">
              @csrf @method('DELETE')
              <button type="submit" class="w-8 h-8 rounded-full hover:bg-red-50 flex items-center justify-center text-gray-400 hover:text-red-500">🗑</button>
            </form>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div class="space-y-4">
      <div class="card p-5">
        <h3 class="font-bold text-gray-800 mb-3">Kode Kupon</h3>
        <div class="flex gap-2"><input type="text" id="coupon-inp" placeholder="Masukkan kode kupon" class="form-input text-sm flex-1"><button onclick="applyCoupon()" class="btn-primary btn-sm px-4" style="padding:.55rem .875rem">Pakai</button></div>
        <div id="coupon-msg" class="mt-2 text-sm hidden"></div>
        <p class="text-xs text-gray-400 mt-1.5">Coba: WELCOME10, HEMAT50, FLASH20, GRATIS25K</p>
      </div>
      <div class="card p-5">
        <h3 class="font-bold text-gray-800 mb-4">Ringkasan Belanja</h3>
        <div class="space-y-2 text-sm">
          <div class="flex justify-between text-gray-600"><span>Subtotal</span><span id="grand-sub">Rp {{ number_format($total,0,',','.') }}</span></div>
          <div id="disc-row" class="flex justify-between text-green-600 hidden"><span>Diskon Kupon</span><span id="disc-amt">-Rp 0</span></div>
          <div class="flex justify-between text-gray-400 text-xs"><span>Ongkir dihitung saat checkout</span></div>
          <div class="border-t pt-3 flex justify-between font-extrabold text-base text-gray-800"><span>Total</span><span id="grand-total" class="text-green-700">Rp {{ number_format($total,0,',','.') }}</span></div>
        </div>
        <a href="{{ route('checkout.index') }}" class="btn-primary w-full mt-5 py-3 text-base text-center block">Checkout Sekarang →</a>
        <a href="{{ route('produk.index') }}" class="block text-center text-sm text-green-600 hover:text-green-800 mt-3">← Lanjut Belanja</a>
      </div>
    </div>
  </div>
  @endif
</div>
@endsection
@push('scripts')
<script>
const baseTotal={{ $total }};let disc=0;
function updateQty(id,delta){const q=document.getElementById('qty-'+id);let qty=parseInt(q.textContent)+delta;if(qty<1)return;
fetch('/keranjang/'+id,{method:'PATCH',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},body:JSON.stringify({quantity:qty})})
.then(r=>r.json()).then(d=>{if(d.success){q.textContent=qty;document.getElementById('sub-'+id).textContent='Rp '+parseInt(d.subtotal).toLocaleString('id-ID');updateTotals();}});}
function updateTotals(){let s=0;document.querySelectorAll('[id^="sub-"]').forEach(e=>s+=parseInt(e.textContent.replace(/\D/g,'')));document.getElementById('grand-sub').textContent='Rp '+s.toLocaleString('id-ID');document.getElementById('grand-total').textContent='Rp '+(s-disc).toLocaleString('id-ID');}
function applyCoupon(){const code=document.getElementById('coupon-inp').value.trim();if(!code)return;const m=document.getElementById('coupon-msg');m.textContent='Memvalidasi...';m.className='mt-2 text-sm text-gray-400';m.classList.remove('hidden');
fetch('{{ route("cart.coupon") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},body:JSON.stringify({coupon_code:code})})
.then(r=>r.json()).then(d=>{if(d.success){disc=d.discount;m.className='mt-2 text-sm text-green-700 font-semibold';m.textContent='✓ '+d.message;document.getElementById('disc-row').classList.remove('hidden');document.getElementById('disc-amt').textContent='-'+d.discount_formatted;updateTotals();}else{m.className='mt-2 text-sm text-red-600';m.textContent='✕ '+d.message;}});}
</script>
@endpush