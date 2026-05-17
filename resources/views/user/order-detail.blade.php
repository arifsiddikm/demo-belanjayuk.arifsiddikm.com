@extends('layouts.app')
@section('title','Pesanan #'.$order->order_number.' - BelanjaYuk!')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

  <div class="flex items-center gap-3 mb-6 flex-wrap">
    <a href="{{ route('user.orders') }}" class="flex items-center gap-1.5 text-sm font-medium hover:underline" style="color:#f97316">
      <i class="fas fa-arrow-left text-xs"></i> Pesanan Saya
    </a>
    <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
    <span class="font-mono font-bold text-gray-800 text-sm">{{ $order->order_number }}</span>
  </div>

  {{-- Status Banner --}}
  <div class="card p-5 mb-5" style="border-left:4px solid #f97316">
    <div class="flex flex-wrap items-center justify-between gap-3">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#fff7ed">
          <i class="fas fa-{{ match($order->status) {
            'menunggu_bayar'=>'clock','diproses'=>'cog','dikirim'=>'shipping-fast',
            'diterima'=>'box','selesai'=>'check-circle','dibatalkan'=>'times-circle',default=>'circle'
          } }} text-orange-500 text-lg"></i>
        </div>
        <div>
          <p class="text-xs text-gray-400">Status Pesanan</p>
          <p class="font-extrabold text-gray-800">{{ $order->status_label ?? ucfirst($order->status) }}</p>
        </div>
      </div>
      <div class="flex gap-2 flex-wrap">
        <span class="badge badge-{{ $order->status_color ?? 'gray' }} py-1.5 px-3">{{ $order->status_label ?? $order->status }}</span>
        <span class="badge {{ $order->payment_status==='paid'?'badge-green':'badge-yellow' }} py-1.5 px-3">
          {{ $order->payment_status==='paid'?'✅ Lunas':'⏳ Menunggu Bayar' }}
        </span>
      </div>
    </div>

    @php
      $steps = [['menunggu_bayar','Menunggu'],['diproses','Diproses'],['dikirim','Dikirim'],['selesai','Selesai']];
      $so    = ['menunggu_bayar'=>0,'diproses'=>1,'dikirim'=>2,'diterima'=>3,'selesai'=>3];
      $cur   = $so[$order->status] ?? -1;
    @endphp
    @if(!in_array($order->status,['dibatalkan']))
    <div class="mt-5 overflow-x-auto">
      <div class="flex items-center min-w-max gap-0">
        @foreach($steps as $i=>[$s,$label])
        <div class="flex items-center {{ $i<count($steps)-1?'flex-1':'' }}">
          <div class="flex flex-col items-center">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs {{ $cur>=$i?'text-white shadow':'bg-gray-100 text-gray-400' }}"
              style="{{ $cur>=$i?'background:linear-gradient(135deg,#f97316,#ea580c)':'' }}">
              <i class="fas fa-{{ $cur>$i?'check':'circle' }}"></i>
            </div>
            <span class="text-xs mt-1.5 font-medium whitespace-nowrap {{ $cur>=$i?'text-orange-600':'text-gray-400' }}">{{ $label }}</span>
          </div>
          @if($i<count($steps)-1)
          <div class="h-1 flex-1 mx-1 mb-4 rounded {{ $cur>$i?'bg-orange-500':'bg-gray-200' }}"></div>
          @endif
        </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>

  <div class="grid lg:grid-cols-3 gap-5">
    <div class="lg:col-span-2 space-y-5">

      {{-- Items --}}
      <div class="card overflow-hidden">
        <div class="p-4 border-b border-orange-50 flex items-center gap-2">
          <i class="fas fa-shopping-cart text-orange-500"></i>
          <h3 class="font-bold text-gray-800">Item Pesanan</h3>
        </div>

        @foreach($order->items as $item)
        <div class="p-4 border-b border-gray-50 last:border-b-0">
          <div class="flex gap-4">
            @php
              $imgSrc = $item->product_thumbnail
                ? (Str::startsWith($item->product_thumbnail,'http') ? $item->product_thumbnail : asset('storage/'.$item->product_thumbnail))
                : 'https://via.placeholder.com/64?text=No+Img';
            @endphp
            <img src="{{ $imgSrc }}" class="w-16 h-16 rounded-xl object-cover border flex-shrink-0">
            <div class="flex-1 min-w-0">
              <p class="font-semibold text-gray-800 text-sm">{{ $item->product_name }}</p>
              @if($item->variant_info)<p class="text-xs text-gray-400 mt-0.5">{{ $item->variant_info }}</p>@endif
              <p class="text-xs text-gray-400 mt-1">{{ $item->quantity }} × Rp {{ number_format($item->price,0,',','.') }}</p>
            </div>
            <p class="font-bold text-sm flex-shrink-0" style="color:#f97316">Rp {{ number_format($item->subtotal,0,',','.') }}</p>
          </div>

          {{-- Review Section (hanya jika selesai) --}}
          @if($order->status === 'selesai' && $item->product_id)
          @php $isReviewed = in_array($item->product_id, $reviewedProductIds ?? []); @endphp
          @if($isReviewed)
          <div class="mt-3 p-2.5 rounded-xl text-sm flex items-center gap-2" style="background:#f0fdf4;border:1px solid #86efac">
            <i class="fas fa-check-circle text-green-500"></i>
            <span class="text-green-700 font-medium text-xs">Ulasan sudah terkirim. Terima kasih!</span>
          </div>
          @else
          <div class="mt-3">
            {{-- BUTTON STYLE untuk Beri Ulasan --}}
            <button type="button" onclick="toggleReview({{ $item->product_id }})"
              id="btn-review-{{ $item->product_id }}"
              class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all"
              style="background:linear-gradient(135deg,#f97316,#ea580c);color:#fff;border:none;cursor:pointer;box-shadow:0 2px 8px rgba(249,115,22,.3)">
              <i class="fas fa-star"></i> Beri Ulasan
            </button>

            <div id="review-panel-{{ $item->product_id }}" class="hidden mt-3">
              <form action="{{ route('user.review.store') }}" method="POST" enctype="multipart/form-data"
                class="p-4 rounded-xl space-y-3" style="background:#fff7ed;border:1px solid #fed7aa">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="product_id" value="{{ $item->product_id }}">

                {{-- Star Rating --}}
                <div>
                  <label class="form-label text-xs mb-1">Rating *</label>
                  <div class="flex gap-1" id="stars-{{ $item->product_id }}">
                    @for($s=1;$s<=5;$s++)
                    <button type="button" onclick="setRating({{ $item->product_id }},{{ $s }})"
                      class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors leading-none"
                      data-star="{{ $s }}">★</button>
                    @endfor
                  </div>
                  <input type="hidden" name="rating" id="rating-{{ $item->product_id }}" required>
                </div>

                {{-- Komentar --}}
                <div>
                  <label class="form-label text-xs">Komentar <span class="text-gray-400 font-normal">(opsional)</span></label>
                  <textarea name="comment" class="form-textarea text-sm" rows="2"
                    placeholder="Ceritakan pengalamanmu dengan produk ini..."></textarea>
                </div>

                {{-- Upload Foto --}}
                <div>
                  <label class="form-label text-xs">Foto Ulasan <span class="text-gray-400 font-normal">(opsional, maks. 3)</span></label>
                  <input type="file" name="images[]" multiple accept="image/jpg,image/jpeg,image/png,image/webp"
                    class="form-input text-xs py-2" onchange="previewReviewImgs(this)">
                  <div id="img-preview-{{ $item->product_id }}" class="flex gap-2 mt-2 flex-wrap"></div>
                </div>

                <div class="flex gap-2 pt-1">
                  <button type="submit" class="btn-primary btn-sm">
                    <i class="fas fa-paper-plane mr-1"></i> Kirim Ulasan
                  </button>
                  <button type="button" onclick="toggleReview({{ $item->product_id }})" class="btn-outline btn-sm">
                    <i class="fas fa-times mr-1"></i> Batal
                  </button>
                </div>
              </form>
            </div>
          </div>
          @endif
          @endif
        </div>
        @endforeach

        <div class="p-4 space-y-1.5 text-sm" style="background:#fff7ed">
          <div class="flex justify-between text-gray-500"><span>Subtotal</span><span>Rp {{ number_format($order->subtotal,0,',','.') }}</span></div>
          @if($order->discount>0)<div class="flex justify-between text-green-600"><span>Diskon ({{ $order->coupon_code }})</span><span>-Rp {{ number_format($order->discount,0,',','.') }}</span></div>@endif
          <div class="flex justify-between text-gray-500"><span>Ongkir ({{ strtoupper($order->courier) }})</span><span>Rp {{ number_format($order->shipping_cost,0,',','.') }}</span></div>
          <div class="flex justify-between font-extrabold text-gray-800 border-t border-orange-200 pt-2 text-base">
            <span>Total</span><span style="color:#f97316">Rp {{ number_format($order->total,0,',','.') }}</span>
          </div>
        </div>
      </div>

      {{-- Info Pengiriman --}}
      <div class="card p-5">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
          <i class="fas fa-truck text-orange-500"></i> Info Pengiriman
        </h3>
        <div class="grid sm:grid-cols-2 gap-4 text-sm mb-4">
          <div><p class="text-gray-400 text-xs mb-0.5">Kurir</p><p class="font-semibold">{{ strtoupper($order->courier) }} — {{ $order->courier_service }}</p></div>
          <div><p class="text-gray-400 text-xs mb-0.5">Est. Tiba</p><p class="font-semibold">{{ $order->estimated_days ?? '-' }} hari</p></div>
        </div>

        @if($order->tracking_number)
        <div class="p-4 rounded-xl mb-4" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);border:1px solid #93c5fd">
          <div class="flex items-center justify-between gap-3 flex-wrap">
            <div>
              <p class="text-xs font-semibold text-blue-600 mb-0.5"><i class="fas fa-barcode mr-1"></i> Nomor Resi</p>
              <p class="font-mono font-extrabold text-blue-800 text-lg">{{ $order->tracking_number }}</p>
              <p class="text-xs text-blue-400 mt-0.5">{{ strtoupper($order->courier) }} • {{ $order->shipped_at?->format('d M Y') ?? '-' }}</p>
            </div>
            <button onclick="trackOrder()" class="btn-primary btn-sm">
              <i class="fas fa-search mr-1"></i> Lacak Paket
            </button>
          </div>
        </div>
        @else
        <div class="p-3.5 rounded-xl text-sm flex items-center gap-2 text-gray-500" style="background:#f1f5f9">
          <i class="fas fa-info-circle text-orange-400"></i>
          Nomor resi akan tersedia setelah pesanan dikirim oleh admin.
        </div>
        @endif

        <div id="tracking-result" class="hidden mt-4">
          <div id="tracking-loading" class="flex items-center gap-2 text-gray-400 text-sm">
            <div class="spinner" style="width:1rem;height:1rem"></div> Melacak paket...
          </div>
          <div id="tracking-content"></div>
        </div>
      </div>

      {{-- Upload Bukti Transfer --}}
      @if($order->payment_method==='bank_transfer' && $order->payment_status!=='paid')
      <div class="card p-5">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-upload text-orange-500"></i> Upload Bukti Transfer</h3>
        <div class="p-3.5 rounded-xl mb-4 text-sm" style="background:#fff7ed;border:1px solid #fed7aa">
          @foreach([['BCA','1234567890 a.n BelanjaYuk!'],['BNI','9876543210 a.n BelanjaYuk!'],['Mandiri','1357924680 a.n BelanjaYuk!']] as [$bank,$no])
          <p><span class="font-bold text-gray-700">{{ $bank }}:</span> <span class="font-mono text-sm">{{ $no }}</span></p>
          @endforeach
          <p class="font-extrabold mt-2" style="color:#f97316">Total: Rp {{ number_format($order->total,0,',','.') }}</p>
        </div>
        <form action="{{ route('checkout.upload-proof',$order->order_number) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
          @csrf
          <div class="grid sm:grid-cols-2 gap-3">
            <div><label class="form-label text-xs">Bank</label><select name="bank_name" class="form-select text-sm"><option>BCA</option><option>BNI</option><option>Mandiri</option></select></div>
            <div><label class="form-label text-xs">Atas Nama</label><input type="text" name="account_name" class="form-input text-sm" required></div>
            <div><label class="form-label text-xs">No. Rekening</label><input type="text" name="account_number" class="form-input text-sm" required></div>
            <div><label class="form-label text-xs">Jumlah</label><input type="number" name="amount" value="{{ $order->total }}" class="form-input text-sm" required></div>
          </div>
          <div><label class="form-label text-xs">Foto Bukti</label><input type="file" name="payment_proof" accept="image/*" class="form-input text-sm" required></div>
          <button type="submit" class="btn-primary w-full py-3"><i class="fas fa-paper-plane mr-2"></i> Kirim Konfirmasi</button>
        </form>
      </div>
      @endif

    </div>

    {{-- RIGHT --}}
    <div class="space-y-5">

      <div class="card p-5">
        <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2"><i class="fas fa-map-marker-alt text-orange-500"></i> Alamat Tujuan</h3>
        <p class="font-semibold text-gray-800 text-sm">{{ $order->recipient_name }}</p>
        <p class="text-sm text-gray-500">{{ $order->recipient_phone }}</p>
        <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ $order->recipient_address }}, {{ $order->city_name }}, {{ $order->province_name }} {{ $order->postal_code }}</p>
      </div>

      {{-- Aksi --}}
      @if($order->status === 'dikirim')
      <button onclick="confirmReceived()" class="btn-primary w-full py-3">
        <i class="fas fa-check-circle mr-2"></i> Konfirmasi Diterima & Selesai
      </button>
      <form id="received-form" action="{{ route('user.orders.received',$order->order_number) }}" method="POST" class="hidden">@csrf</form>
      @endif

      @if(in_array($order->status,['menunggu_bayar','diproses']))
      <button onclick="confirmCancel()" class="btn-outline w-full py-3">
        <i class="fas fa-times mr-2"></i> Batalkan Pesanan
      </button>
      <form id="cancel-form" action="{{ route('user.orders.cancel',$order->order_number) }}" method="POST" class="hidden">
        @csrf <input type="hidden" name="cancel_reason" id="cancel-reason-input" value="Dibatalkan oleh pembeli">
      </form>
      @endif

      <div class="card p-4">
        <h4 class="text-sm font-bold text-gray-700 mb-3"><i class="fas fa-info-circle text-orange-400 mr-1"></i> Info Pesanan</h4>
        <div class="space-y-1.5 text-xs text-gray-500">
          <div class="flex justify-between"><span>No. Pesanan</span><span class="font-mono font-bold text-gray-700">{{ $order->order_number }}</span></div>
          <div class="flex justify-between"><span>Tanggal Pesan</span><span>{{ $order->created_at->format('d M Y H:i') }}</span></div>
          <div class="flex justify-between"><span>Metode Bayar</span><span>{{ $order->payment_method==='midtrans'?'Midtrans':'Transfer Bank' }}</span></div>
          @if($order->paid_at)<div class="flex justify-between"><span>Dibayar</span><span>{{ $order->paid_at->format('d M Y') }}</span></div>@endif
          @if($order->completed_at)<div class="flex justify-between"><span>Selesai</span><span>{{ $order->completed_at->format('d M Y') }}</span></div>@endif
        </div>
      </div>

      @if($order->status === 'selesai')
      <div class="card p-4 text-center" style="background:#fff7ed;border:1px solid #fed7aa">
        <i class="fas fa-star text-yellow-400 text-2xl mb-2 block"></i>
        <p class="text-sm font-semibold text-orange-700 mb-1">Pesanan Selesai!</p>
        <p class="text-xs text-gray-500">Berikan ulasan untuk setiap produk</p>
      </div>
      @endif

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function trackOrder() {
  const r=document.getElementById('tracking-result'),l=document.getElementById('tracking-loading'),c=document.getElementById('tracking-content');
  r.classList.remove('hidden');l.classList.remove('hidden');c.innerHTML='';
  fetch('{{ route("user.orders.track",$order->order_number) }}')
    .then(res=>res.json()).then(d=>{
      l.classList.add('hidden');
      if(d.error){c.innerHTML='<p class="text-red-500 text-sm">'+d.error+'</p>';return;}
      const m=d.manifest||d.history||[];
      if(!m.length){c.innerHTML='<p class="text-gray-400 text-sm">Data belum tersedia</p>';return;}
      let html='<div class="relative mt-3"><div class="absolute left-3.5 top-0 bottom-0 w-0.5 bg-gray-200"></div><div class="space-y-3">';
      m.forEach((x,i)=>{
        const desc=x.description||x.desc||x.status||'',dt=(x.date||'')+' '+(x.time||''),isCakung=desc.includes('Cakung');
        html+='<div class="flex gap-3 items-start"><div class="flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center z-10 '+(i===0?'" style="background:#f97316"':isCakung?'" style="background:#3b82f6"':'bg-gray-100"')+'><i class="fas fa-'+(i===0?'check':isCakung?'warehouse':'circle')+' text-xs '+(i===0||isCakung?'text-white':'text-gray-400')+'"></i></div><div class="flex-1 pb-1"><p class="text-sm '+(i===0?'font-semibold text-gray-800':'text-gray-600')+'">'+desc+'</p><p class="text-xs text-gray-400 mt-0.5">'+dt+'</p></div></div>';
      });
      html+='</div></div>';c.innerHTML=html;
    }).catch(()=>{l.classList.add('hidden');c.innerHTML='<p class="text-red-500 text-sm">Gagal memuat data</p>';});
}

function confirmReceived(){
  Swal.fire({title:'Konfirmasi Diterima?',html:'<p>Yakin pesanan sudah diterima?</p><p class="text-sm text-gray-400 mt-1">Status akan menjadi <strong>Selesai</strong></p>',icon:'question',showCancelButton:true,confirmButtonText:'✅ Ya, Sudah Diterima!',cancelButtonText:'Batal',confirmButtonColor:'#f97316'}).then(r=>{if(r.isConfirmed)document.getElementById('received-form').submit();});
}

function confirmCancel(){
  Swal.fire({title:'Batalkan Pesanan?',input:'textarea',inputLabel:'Alasan pembatalan',inputPlaceholder:'Tulis alasan...',showCancelButton:true,confirmButtonText:'Ya, Batalkan',cancelButtonText:'Tidak',confirmButtonColor:'#ef4444',cancelButtonColor:'#f97316'}).then(r=>{
    if(r.isConfirmed){document.getElementById('cancel-reason-input').value=r.value||'Dibatalkan oleh pembeli';document.getElementById('cancel-form').submit();}
  });
}

function toggleReview(pid){
  const panel=document.getElementById('review-panel-'+pid);
  const btn=document.getElementById('btn-review-'+pid);
  panel.classList.toggle('hidden');
  btn.innerHTML=panel.classList.contains('hidden')
    ?'<i class="fas fa-star mr-1"></i> Beri Ulasan'
    :'<i class="fas fa-times mr-1"></i> Tutup';
}

function setRating(pid,star){
  document.getElementById('rating-'+pid).value=star;
  document.querySelectorAll('#stars-'+pid+' .star-btn').forEach((btn,i)=>{btn.style.color=i<star?'#f59e0b':'#d1d5db';});
}

// Hover stars
document.querySelectorAll('[id^="stars-"]').forEach(container=>{
  const pid=container.id.replace('stars-','');
  const stars=container.querySelectorAll('.star-btn');
  stars.forEach((btn,i)=>{
    btn.addEventListener('mouseenter',()=>{stars.forEach((b,j)=>{b.style.color=j<=i?'#f59e0b':'#d1d5db';});});
    btn.addEventListener('mouseleave',()=>{const cur=parseInt(document.getElementById('rating-'+pid).value||0);stars.forEach((b,j)=>{b.style.color=j<cur?'#f59e0b':'#d1d5db';});});
  });
});

// Preview gambar review
function previewReviewImgs(input){
  const pid=input.closest('form').querySelector('[name=product_id]').value;
  const preview=document.getElementById('img-preview-'+pid);
  if(!preview)return;
  preview.innerHTML='';
  const files=Array.from(input.files).slice(0,3);
  files.forEach(f=>{
    const r=new FileReader();
    r.onload=e=>{
      const img=document.createElement('img');
      img.src=e.target.result;
      img.className='w-16 h-16 object-cover rounded-lg border-2 border-orange-300';
      preview.appendChild(img);
    };
    r.readAsDataURL(f);
  });
}
</script>
@endpush
