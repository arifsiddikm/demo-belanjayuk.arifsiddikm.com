@extends('layouts.admin')
@section('title','Detail Pesanan #'.$order->order_number)
@section('page-title','Detail Pesanan')
@section('content')

<div class="mb-5">
  <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 text-sm font-medium hover:underline" style="color:#f97316">
    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan
  </a>
</div>

<div class="grid lg:grid-cols-3 gap-6">

  {{-- LEFT --}}
  <div class="lg:col-span-2 space-y-5">

    {{-- Status & Update --}}
    <div class="card p-5">
      <div class="flex flex-wrap items-center justify-between gap-4 mb-5">
        <div>
          <h2 class="text-xl font-extrabold text-gray-800 font-mono">{{ $order->order_number }}</h2>
          <p class="text-sm text-gray-400 mt-1">{{ $order->created_at->isoFormat('dddd, D MMMM Y HH:mm') }}</p>
        </div>
        <div class="flex gap-2 flex-wrap">
          <span class="badge badge-{{ $order->status_color ?? 'gray' }} text-sm py-1.5 px-3">{{ $order->status_label ?? $order->status }}</span>
          <span class="badge {{ $order->payment_status==='paid'?'badge-green':'badge-yellow' }} text-sm py-1.5 px-3">
            {{ $order->payment_status==='paid'?'✅ Lunas':'⏳ Menunggu' }}
          </span>
        </div>
      </div>

      <form action="{{ route('admin.orders.update-status',$order->order_number) }}" method="POST" class="rounded-xl p-4" style="background:#fff7ed;border:1px solid #fed7aa">
        @csrf
        <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
          <i class="fas fa-edit text-orange-500"></i> Update Status Pesanan
        </h4>
        <div class="grid sm:grid-cols-2 gap-3 mb-3">
          <div>
            <label class="form-label text-xs">Status Baru</label>
            <select name="status" id="status-sel" class="form-select text-sm"
              onchange="document.getElementById('resi-field').classList.toggle('hidden',this.value!=='dikirim')">
              @foreach(['menunggu_bayar'=>'Menunggu Bayar','diproses'=>'Diproses','dikirim'=>'🚚 Dikirim (Input Resi)','diterima'=>'Diterima','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'] as $v=>$l)
              <option value="{{ $v }}" {{ $order->status===$v?'selected':'' }}>{{ $l }}</option>
              @endforeach
            </select>
          </div>
          <div id="resi-field" class="{{ $order->status==='dikirim'?'':'hidden' }}">
            <label class="form-label text-xs">Nomor Resi <span class="text-red-500">*</span></label>
            <input type="text" name="tracking_number" value="{{ $order->tracking_number }}"
              placeholder="cth: JNE1234567890" class="form-input text-sm font-mono uppercase"
              oninput="this.value=this.value.toUpperCase()">
            <p class="text-xs text-gray-400 mt-1"><i class="fas fa-info-circle text-orange-300"></i> Resi otomatis muncul di halaman pesanan pelanggan</p>
          </div>
        </div>
        <button type="submit" class="btn-primary btn-sm"><i class="fas fa-save mr-1"></i> Update Status</button>
      </form>

      @if($order->tracking_number)
      <div class="mt-4 p-3.5 rounded-xl flex items-center gap-3" style="background:#eff6ff;border:1px solid #bfdbfe">
        <i class="fas fa-barcode text-blue-500 text-xl"></i>
        <div class="flex-1">
          <p class="text-xs text-blue-600 font-semibold">Nomor Resi Aktif</p>
          <p class="font-mono font-bold text-blue-800 text-base">{{ $order->tracking_number }}</p>
          <p class="text-xs text-blue-400">{{ strtoupper($order->courier) }} {{ $order->courier_service }}</p>
        </div>
        <button onclick="previewTracking('{{ $order->tracking_number }}','{{ $order->courier }}')" class="btn-outline btn-sm flex-shrink-0">
          <i class="fas fa-eye mr-1"></i> Preview
        </button>
      </div>
      @endif
    </div>

    {{-- Order Items --}}
    <div class="card overflow-hidden">
      <div class="p-5 border-b border-orange-50 flex items-center gap-2">
        <i class="fas fa-shopping-cart text-orange-500"></i>
        <h3 class="font-bold text-gray-800">Item Pesanan ({{ $order->items->count() }} item)</h3>
      </div>
      <div class="divide-y divide-gray-50">
        @foreach($order->items as $item)
        <div class="flex gap-4 p-5">
          @php
            $imgSrc = $item->product_thumbnail
              ? (Str::startsWith($item->product_thumbnail,'http') ? $item->product_thumbnail : asset('storage/'.$item->product_thumbnail))
              : 'https://via.placeholder.com/64?text=No';
          @endphp
          <img src="{{ $imgSrc }}" class="w-16 h-16 rounded-xl object-cover border flex-shrink-0"
            onerror="this.src='https://via.placeholder.com/64?text=No'">
          <div class="flex-1">
            <p class="font-semibold text-gray-800 text-sm">{{ $item->product_name }}</p>
            @if($item->variant_info)<p class="text-xs text-gray-400 mt-0.5">{{ $item->variant_info }}</p>@endif
            <p class="text-xs text-gray-400 mt-1">{{ $item->quantity }} × Rp {{ number_format($item->price,0,',','.') }}</p>
          </div>
          <p class="font-bold text-sm" style="color:#f97316">Rp {{ number_format($item->subtotal,0,',','.') }}</p>
        </div>
        @endforeach
      </div>
      <div class="p-5 space-y-2 text-sm" style="background:#fff7ed">
        <div class="flex justify-between text-gray-600"><span>Subtotal</span><span>Rp {{ number_format($order->subtotal,0,',','.') }}</span></div>
        @if($order->discount>0)
        <div class="flex justify-between text-green-600"><span>Diskon ({{ $order->coupon_code }})</span><span>-Rp {{ number_format($order->discount,0,',','.') }}</span></div>
        @endif
        <div class="flex justify-between text-gray-600"><span>Ongkos Kirim ({{ strtoupper($order->courier) }} {{ $order->courier_service }})</span><span>Rp {{ number_format($order->shipping_cost,0,',','.') }}</span></div>
        <div class="flex justify-between font-extrabold text-base text-gray-800 border-t border-orange-200 pt-2">
          <span>Total</span><span style="color:#f97316">Rp {{ number_format($order->total,0,',','.') }}</span>
        </div>
      </div>
    </div>

    {{-- Payment Confirmation --}}
    @if($order->paymentConfirmation)
    <div class="card p-5">
      <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
        <i class="fas fa-credit-card text-orange-500"></i> Konfirmasi Pembayaran
      </h3>
      <div class="grid sm:grid-cols-2 gap-4">
        <div class="space-y-2.5 text-sm">
          @foreach([['Bank',$order->paymentConfirmation->bank_name],['Atas Nama',$order->paymentConfirmation->account_name],['No. Rekening',$order->paymentConfirmation->account_number],['Jumlah','Rp '.number_format($order->paymentConfirmation->amount,0,',','.')]] as [$l,$v])
          <div class="flex justify-between gap-4"><span class="text-gray-400">{{ $l }}</span><span class="font-semibold text-gray-800">{{ $v }}</span></div>
          @endforeach
          <div class="flex justify-between gap-4">
            <span class="text-gray-400">Status</span>
            <span class="badge {{ $order->paymentConfirmation->status==='approved'?'badge-green':($order->paymentConfirmation->status==='rejected'?'badge-red':'badge-yellow') }}">{{ ucfirst($order->paymentConfirmation->status) }}</span>
          </div>
        </div>
        @if($order->paymentConfirmation->transfer_proof)
        <a href="{{ asset('storage/'.$order->paymentConfirmation->transfer_proof) }}" target="_blank">
          <img src="{{ asset('storage/'.$order->paymentConfirmation->transfer_proof) }}" class="w-full max-h-44 object-contain rounded-xl border cursor-pointer hover:opacity-80">
        </a>
        @endif
      </div>
      @if($order->paymentConfirmation->status==='pending')
      <form action="{{ route('admin.orders.confirm-payment',$order->paymentConfirmation->id) }}" method="POST" class="mt-4 pt-4 border-t border-orange-50">
        @csrf
        <input type="hidden" name="action" id="conf-action" value="">
        <textarea name="admin_notes" placeholder="Catatan admin (opsional)" class="form-textarea text-sm mb-3" style="min-height:70px"></textarea>
        <div class="flex gap-2">
          <button type="submit" onclick="document.getElementById('conf-action').value='approved'" class="btn-primary btn-sm"><i class="fas fa-check mr-1"></i> Konfirmasi Lunas</button>
          <button type="submit" onclick="document.getElementById('conf-action').value='rejected'" class="btn-danger btn-sm"><i class="fas fa-times mr-1"></i> Tolak</button>
        </div>
      </form>
      @endif
    </div>
    @endif

    {{-- Tracking Preview --}}
    <div id="tracking-modal" class="hidden card p-5">
      <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
        <i class="fas fa-shipping-fast text-orange-500"></i> Preview Tracking
        <span id="track-awb-label" class="font-mono text-sm text-gray-400 ml-2"></span>
      </h3>
      <div id="tracking-content"><div class="flex items-center gap-2 text-sm text-gray-400"><div class="spinner" style="width:1rem;height:1rem"></div> Memuat...</div></div>
    </div>

  </div>

  {{-- RIGHT --}}
  <div class="space-y-5">

    {{-- Pelanggan --}}
    <div class="card p-5">
      <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
        <i class="fas fa-user text-orange-500"></i> Pelanggan
      </h3>
      <div class="flex items-center gap-3 mb-4">
        <img src="{{ $order->user->avatar_url }}" class="w-12 h-12 rounded-full object-cover border-2" style="border-color:#fed7aa">
        <div>
          <p class="font-semibold text-gray-800">{{ $order->user->name }}</p>
          <p class="text-sm text-gray-400">{{ $order->user->email }}</p>
        </div>
      </div>

      {{-- WhatsApp BUTTON STYLE -- bukan plain link --}}
      @php
        $waNum = preg_replace('/[^0-9]/', '', $order->recipient_phone ?? '');
        if (str_starts_with($waNum, '0')) $waNum = '62' . substr($waNum, 1);
      @endphp
      <a href="https://wa.me/{{ $waNum }}" target="_blank"
        class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl font-semibold text-sm transition-all hover:opacity-90"
        style="background:linear-gradient(135deg,#25D366,#128C7E);color:#fff;text-decoration:none">
        <i class="fab fa-whatsapp text-lg"></i>
        <span>Chat WhatsApp</span>
        <span class="text-xs opacity-80 ml-1">{{ $order->recipient_phone }}</span>
      </a>
    </div>

    {{-- Alamat --}}
    <div class="card p-5">
      <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
        <i class="fas fa-map-marker-alt text-orange-500"></i> Alamat Pengiriman
      </h3>
      <p class="font-semibold text-gray-800 text-sm">{{ $order->recipient_name }}</p>
      <p class="text-sm text-gray-500 mt-0.5">{{ $order->recipient_phone }}</p>
      <p class="text-sm text-gray-600 mt-2 leading-relaxed">
        {{ $order->recipient_address }},<br>
        {{ $order->district_name ? $order->district_name.', ' : '' }}
        {{ $order->city_name }}, {{ $order->province_name }}
        {{ $order->postal_code }}
      </p>
    </div>

    {{-- Info Pengiriman --}}
    <div class="card p-5">
      <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2"><i class="fas fa-truck text-orange-500"></i> Info Pengiriman</h3>
      <div class="space-y-2 text-sm">
        <div class="flex justify-between gap-2"><span class="text-gray-400">Kurir</span><span class="font-semibold">{{ strtoupper($order->courier) }} {{ $order->courier_service }}</span></div>
        <div class="flex justify-between gap-2"><span class="text-gray-400">Est. Tiba</span><span class="font-semibold">{{ $order->estimated_days ?? '-' }} hari</span></div>
        <div class="flex justify-between gap-2"><span class="text-gray-400">Metode Bayar</span><span class="font-semibold">{{ $order->payment_method==='midtrans'?'Midtrans':'Transfer Bank' }}</span></div>
        @if($order->tracking_number)
        <div class="flex justify-between gap-2"><span class="text-gray-400">No. Resi</span><span class="font-mono font-bold text-blue-700">{{ $order->tracking_number }}</span></div>
        @endif
        @if($order->shipped_at)
        <div class="flex justify-between gap-2"><span class="text-gray-400">Tgl Kirim</span><span class="font-semibold">{{ $order->shipped_at->format('d M Y') }}</span></div>
        @endif
      </div>
    </div>

    {{-- Timeline --}}
    <div class="card p-5">
      <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2"><i class="fas fa-history text-orange-500"></i> Timeline</h3>
      <div class="space-y-3">
        @foreach([
          ['created_at','Pesanan Dibuat','fas fa-shopping-cart','#fff7ed','#f97316'],
          ['paid_at','Pembayaran Diterima','fas fa-credit-card','#eff6ff','#3b82f6'],
          ['shipped_at','Pesanan Dikirim','fas fa-shipping-fast','#f0fdf4','#22c55e'],
          ['completed_at','Pesanan Selesai','fas fa-check-circle','#f0fdf4','#22c55e'],
          ['cancelled_at','Pesanan Dibatalkan','fas fa-times-circle','#fff1f2','#ef4444'],
        ] as [$field,$label,$icon,$bg,$color])
        @if($order->$field)
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0" style="background:{{ $bg }}">
            <i class="{{ $icon }} text-xs" style="color:{{ $color }}"></i>
          </div>
          <div>
            <p class="text-xs font-semibold text-gray-700">{{ $label }}</p>
            <p class="text-xs text-gray-400">{{ $order->$field->format('d M Y, H:i') }}</p>
          </div>
        </div>
        @endif
        @endforeach
      </div>
    </div>

  </div>
</div>

@push('scripts')
<script>
function previewTracking(awb, courier) {
  const modal=document.getElementById('tracking-modal');
  document.getElementById('track-awb-label').textContent=awb;
  document.getElementById('tracking-content').innerHTML='<div class="flex items-center gap-2 text-sm text-gray-400"><div class="spinner" style="width:1rem;height:1rem"></div> Melacak...</div>';
  modal.classList.remove('hidden');
  modal.scrollIntoView({behavior:'smooth',block:'start'});
  fetch('/api/track',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},body:JSON.stringify({awb,courier})})
    .then(r=>r.json()).then(d=>{
      const m=d.manifest||d.history||[];
      if(!m.length){document.getElementById('tracking-content').innerHTML='<p class="text-gray-400 text-sm">Data belum tersedia</p>';return;}
      let html='<div class="relative"><div class="absolute left-3.5 top-0 bottom-0 w-0.5 bg-gray-200"></div><div class="space-y-3">';
      m.forEach((x,i)=>{
        const desc=x.description||x.desc||x.status||'',dt=(x.date||'')+' '+(x.time||''),isCakung=desc.includes('Cakung');
        html+='<div class="flex gap-3 items-start"><div class="flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center z-10 '+(i===0?'" style="background:#f97316"':isCakung?'" style="background:#3b82f6"':'bg-gray-100"')+'><i class="fas fa-'+(i===0?'check':isCakung?'warehouse':'circle')+' text-xs '+(i===0||isCakung?'text-white':'text-gray-400')+'"></i></div><div class="flex-1 pb-1"><p class="text-sm '+(i===0?'font-semibold text-gray-800':'text-gray-600')+'">'+desc+'</p><p class="text-xs text-gray-400 mt-0.5">'+dt+'</p></div></div>';
      });
      html+='</div></div>';document.getElementById('tracking-content').innerHTML=html;
    }).catch(()=>{document.getElementById('tracking-content').innerHTML='<p class="text-red-500 text-sm">Gagal memuat</p>';});
}
</script>
@endpush
@endsection
