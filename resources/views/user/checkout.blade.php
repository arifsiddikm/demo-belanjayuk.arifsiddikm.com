@extends('layouts.app')
@section('title','Checkout - BelanjaYuk!')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
  <h1 class="text-2xl font-extrabold text-gray-900 mb-7 flex items-center gap-2">
    <i class="fas fa-shopping-bag text-orange-500"></i> Checkout
  </h1>

  <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
    @csrf
    <div class="grid lg:grid-cols-3 gap-7">

      {{-- LEFT --}}
      <div class="lg:col-span-2 space-y-5">

        {{-- ALAMAT --}}
        <div class="card p-6">
          <h3 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i class="fas fa-map-marker-alt text-orange-500"></i> Alamat Pengiriman
          </h3>

          @if($addresses->count())
          <div class="mb-5">
            <p class="text-sm font-semibold text-gray-600 mb-3">Pilih dari alamat tersimpan:</p>
            <div class="grid sm:grid-cols-2 gap-3">
              @foreach($addresses as $addr)
              <label class="flex gap-3 p-3.5 rounded-xl border-2 cursor-pointer transition-all addr-card {{ $addr->is_default ? '' : 'border-gray-200' }}"
                style="{{ $addr->is_default ? 'border-color:#f97316;background:#fff7ed' : '' }}">
                <input type="radio" name="_aid" value="{{ $addr->id }}" {{ $addr->is_default ? 'checked' : '' }}
                  onchange="fillAddr({{ json_encode($addr) }})" class="mt-1 form-radio">
                <div class="text-sm">
                  <p class="font-semibold text-gray-800">{{ $addr->label }} — {{ $addr->recipient_name }}</p>
                  <p class="text-xs text-gray-400 mt-0.5">{{ Str::limit($addr->address,50) }}, {{ $addr->city_name }}</p>
                </div>
              </label>
              @endforeach
            </div>
            <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
              <i class="fas fa-info-circle text-orange-400"></i> atau isi manual di bawah:
            </p>
          </div>
          @endif

          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="form-label">Nama Penerima *</label>
              <input type="text" name="recipient_name" id="f_name" value="{{ old('recipient_name', Auth::user()->name) }}" class="form-input" required>
            </div>
            <div>
              <label class="form-label">No. HP *</label>
              <input type="text" name="recipient_phone" id="f_phone" value="{{ old('recipient_phone', Auth::user()->phone) }}" class="form-input" required>
            </div>

            {{-- Provinsi --}}
            <div>
              <label class="form-label">Provinsi *</label>
              <select name="province_id" id="prov" class="form-select" required onchange="onProv()">
                <option value="">-- Pilih Provinsi --</option>
                @foreach($provinces as $p)
                @php $pid = $p['province_id'] ?? $p['id']; $pname = $p['province'] ?? $p['name']; @endphp
                <option value="{{ $pid }}" data-name="{{ $pname }}" {{ old('province_id') == $pid ? 'selected' : '' }}>
                  {{ ucwords(strtolower($pname)) }}
                </option>
                @endforeach
              </select>
              <input type="hidden" name="province_name" id="prov_name">
            </div>

            {{-- Kota --}}
            <div>
              <label class="form-label">Kota *</label>
              <select name="city_id" id="city" class="form-select" required onchange="onCity()">
                <option value="">-- Pilih Kota --</option>
              </select>
              <input type="hidden" name="city_name" id="city_name">
            </div>

            {{-- Kecamatan --}}
            <div>
              <label class="form-label">Kecamatan <span class="text-xs text-gray-400">(opsional, ongkir lebih akurat)</span></label>
              <select name="district_id" id="dist" class="form-select" onchange="onDist()">
                <option value="">-- Pilih Kecamatan --</option>
              </select>
              <input type="hidden" name="district_name" id="dist_name">
            </div>

            {{-- Kode Pos --}}
            <div>
              <label class="form-label">Kode Pos</label>
              <input type="text" name="postal_code" id="f_postal" value="{{ old('postal_code') }}" class="form-input" placeholder="42414">
            </div>

            {{-- Alamat Lengkap --}}
            <div class="sm:col-span-2">
              <label class="form-label">Alamat Lengkap *</label>
              <textarea name="recipient_address" id="f_addr" class="form-textarea" rows="2" required
                placeholder="Nama jalan, no. rumah, RT/RW, kelurahan...">{{ old('recipient_address') }}</textarea>
            </div>
          </div>
        </div>

        {{-- KURIR --}}
        <div class="card p-6">
          <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
            <i class="fas fa-truck text-orange-500"></i> Pilih Kurir
          </h3>

          {{-- Info berat & asal --}}
          <div class="flex items-center gap-4 mb-4 p-3 rounded-xl text-sm" style="background:#fff7ed;border:1px solid #fed7aa">
            <div class="flex items-center gap-1.5 text-gray-600">
              <i class="fas fa-weight text-orange-400"></i>
              <span>Berat total: <strong>{{ number_format($totalWeight) }} gram ({{ number_format($totalWeight/1000,2) }} kg)</strong></span>
            </div>
            <div class="flex items-center gap-1.5 text-gray-600">
              <i class="fas fa-map-marker-alt text-orange-400"></i>
              <span>Asal: <strong>{{ $originCity }}</strong></span>
            </div>
          </div>

          <p class="text-xs text-gray-400 mb-4 flex items-center gap-1">
            <i class="fas fa-info-circle text-orange-300"></i>
            Pilih kota tujuan terlebih dahulu, lalu pilih kurir
          </p>

          {{-- Grid kurir --}}
          <div class="grid grid-cols-3 sm:grid-cols-6 gap-2 mb-5">
            @foreach(['jne'=>'JNE','jnt'=>'J&T','sicepat'=>'SiCepat','anteraja'=>'AnterAja','pos'=>'Pos','tiki'=>'TIKI'] as $code=>$label)
            <label class="flex flex-col items-center gap-1.5 p-3 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-orange-400 transition-all courier-label text-center" id="cl-{{ $code }}">
              <input type="radio" name="_courier" value="{{ $code }}" onchange="fetchOngkir('{{ $code }}')" class="hidden">
              <i class="fas fa-shipping-fast text-gray-400 text-sm"></i>
              <span class="text-xs font-bold text-gray-700">{{ $label }}</span>
            </label>
            @endforeach
          </div>

          <div id="shipping-svcs" class="hidden">
            <div id="svcs-loading" class="flex items-center gap-2 text-sm text-gray-400 mb-3 hidden">
              <div class="spinner"></div> Menghitung ongkir...
            </div>
            <div id="svcs-list" class="space-y-2"></div>
          </div>

          <input type="hidden" name="courier" id="sel-courier">
          <input type="hidden" name="courier_service" id="sel-svc">
          <input type="hidden" name="courier_service_name" id="sel-svc-name">
          <input type="hidden" name="shipping_cost" id="sel-cost" value="0">
          <input type="hidden" name="estimated_days" id="sel-days">
        </div>

        {{-- PEMBAYARAN --}}
        <div class="card p-6">
          <h3 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
            <i class="fas fa-credit-card text-orange-500"></i> Metode Pembayaran
          </h3>
          <div class="grid sm:grid-cols-2 gap-3">
            <label class="flex gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all pm-card" style="border-color:#f97316;background:#fff7ed">
              <input type="radio" name="payment_method" value="midtrans" checked class="mt-1 form-radio">
              <div>
                <p class="font-bold text-gray-800 text-sm"><i class="fas fa-bolt text-yellow-500 mr-1"></i> Midtrans</p>
                <p class="text-xs text-gray-400 mt-0.5">Transfer bank, QRIS, GoPay, OVO, dll</p>
              </div>
            </label>
            <label class="flex gap-3 p-4 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-orange-300 transition-all pm-card">
              <input type="radio" name="payment_method" value="bank_transfer" class="mt-1 form-radio">
              <div>
                <p class="font-bold text-gray-800 text-sm"><i class="fas fa-university text-blue-500 mr-1"></i> Transfer Bank Manual</p>
                <p class="text-xs text-gray-400 mt-0.5">BCA, BNI, Mandiri</p>
              </div>
            </label>
          </div>
        </div>

        {{-- CATATAN --}}
        <div class="card p-6">
          <label class="form-label flex items-center gap-2">
            <i class="fas fa-sticky-note text-orange-400"></i> Catatan <span class="text-gray-400 font-normal text-xs">(opsional)</span>
          </label>
          <textarea name="notes" class="form-textarea" rows="2" placeholder="Instruksi packing, warna preferensi...">{{ old('notes') }}</textarea>
        </div>

      </div>

      {{-- RIGHT: Ringkasan --}}
      <div>
        <div class="card p-5 sticky top-24">
          <h3 class="font-bold text-gray-800 mb-4">Ringkasan Pesanan</h3>
          <div class="divide-y divide-gray-50 mb-4">
            @foreach($cartItems as $item)
            <div class="flex gap-3 py-3">
              <img src="{{ $item->product->thumbnail_url }}" class="w-12 h-12 object-cover rounded-lg border flex-shrink-0">
              <div class="flex-1 min-w-0">
                <p class="text-xs font-medium text-gray-800 line-clamp-2">{{ $item->product->name }}</p>
                <p class="text-xs text-gray-400">×{{ $item->quantity }}</p>
              </div>
              <p class="text-xs font-bold flex-shrink-0" style="color:#f97316">Rp {{ number_format($item->subtotal,0,',','.') }}</p>
            </div>
            @endforeach
          </div>
          <div class="space-y-2 text-sm border-t border-gray-100 pt-3">
            <div class="flex justify-between text-gray-500"><span>Subtotal</span><span>Rp {{ number_format($subtotal,0,',','.') }}</span></div>
            @if($couponDiscount>0)
            <div class="flex justify-between" style="color:#f97316"><span>Kupon ({{ $couponCode }})</span><span>-Rp {{ number_format($couponDiscount,0,',','.') }}</span></div>
            @endif
            <div class="flex justify-between text-gray-500">
              <span>Ongkos Kirim</span>
              <span id="disp-ongkir" class="text-gray-400 text-xs italic">Pilih kurir dulu</span>
            </div>
            <div id="ongkir-info" class="text-xs text-gray-400 hidden"></div>
            <div class="border-t pt-3 flex justify-between font-extrabold text-gray-800">
              <span>Total</span>
              <span id="disp-total" style="color:#f97316">Rp {{ number_format($subtotal - $couponDiscount,0,',','.') }}</span>
            </div>
          </div>
          <button type="submit" id="submit-btn" class="btn-primary w-full mt-5 py-3 text-base opacity-50 cursor-not-allowed" disabled>
            <i class="fas fa-lock mr-2"></i> Buat Pesanan
          </button>
          @if($errors->any())
          <div class="mt-3 text-xs text-red-600 space-y-1">
            @foreach($errors->all() as $e)<p><i class="fas fa-exclamation-circle mr-1"></i>{{ $e }}</p>@endforeach
          </div>
          @endif
        </div>
      </div>

    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
const subtotal = {{ $subtotal }};
const disc     = {{ $couponDiscount }};
let ongkir     = 0;

// ===== PROVINCE =====
function onProv() {
  const s = document.getElementById('prov');
  const opt = s.options[s.selectedIndex];
  document.getElementById('prov_name').value = opt?.dataset.name || '';
  loadCities(s.value);
}

function loadCities(provId) {
  if (!provId) return;
  const c = document.getElementById('city');
  c.innerHTML = '<option value="">Memuat kota...</option>';
  document.getElementById('dist').innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
  fetch('/api/cities/' + provId)
    .then(r => r.json())
    .then(d => {
      c.innerHTML = '<option value="">-- Pilih Kota --</option>';
      (d.data || []).forEach(x => {
        c.innerHTML += '<option value="' + (x.city_id||x.id) + '" data-name="' + (x.city_name||x.name) + '">'
          + (x.city_name||x.name) + '</option>';
      });
    })
    .catch(() => { c.innerHTML = '<option value="">Gagal memuat kota</option>'; });
}

// ===== CITY =====
function onCity() {
  const s = document.getElementById('city');
  document.getElementById('city_name').value = s.options[s.selectedIndex]?.dataset.name || '';
  const cityId = s.value;
  if (!cityId) return;
  // Load kecamatan
  document.getElementById('dist').innerHTML = '<option value="">Memuat kecamatan...</option>';
  fetch('/api/districts/' + cityId)
    .then(r => r.json())
    .then(d => {
      const di = document.getElementById('dist');
      di.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
      (d.data || []).forEach(x => {
        di.innerHTML += '<option value="' + (x.subdistrict_id||x.id) + '" data-name="' + (x.subdistrict_name||x.name) + '">'
          + (x.subdistrict_name||x.name) + '</option>';
      });
    })
    .catch(() => { document.getElementById('dist').innerHTML = '<option value="">Gagal memuat</option>'; });
  // Re-fetch ongkir jika kurir sudah dipilih
  const courier = document.querySelector('input[name="_courier"]:checked');
  if (courier) fetchOngkir(courier.value);
}

// ===== DISTRICT =====
function onDist() {
  const s = document.getElementById('dist');
  document.getElementById('dist_name').value = s.options[s.selectedIndex]?.dataset.name || '';
  const courier = document.querySelector('input[name="_courier"]:checked');
  if (courier) fetchOngkir(courier.value);
}

// ===== FETCH ONGKIR (pakai FakeShippingService via CheckoutController) =====
function fetchOngkir(courier) {
  const cityId = document.getElementById('city').value;
  if (!cityId) {
    Swal.fire({ toast:true, position:'top-end', icon:'warning', title:'Pilih kota tujuan dulu!', showConfirmButton:false, timer:2500 });
    return;
  }

  // Highlight kurir terpilih
  document.querySelectorAll('.courier-label').forEach(l => {
    l.style.borderColor = ''; l.style.background = '';
  });
  const activeLabel = document.querySelector('input[name="_courier"]:checked')?.closest('.courier-label');
  if (activeLabel) { activeLabel.style.borderColor = '#f97316'; activeLabel.style.background = '#fff7ed'; }

  document.getElementById('shipping-svcs').classList.remove('hidden');
  document.getElementById('svcs-loading').classList.remove('hidden');
  document.getElementById('svcs-list').innerHTML = '';
  document.getElementById('sel-courier').value = courier;

  fetch('{{ route("checkout.shipping-cost") }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
    body: JSON.stringify({ destination: cityId, courier: courier })
  })
  .then(r => r.json())
  .then(d => {
    document.getElementById('svcs-loading').classList.add('hidden');
    const svcs = d.data || [];
    const el   = document.getElementById('svcs-list');

    // Info kalkulasi
    if (d.weight_gram) {
      document.getElementById('ongkir-info').textContent =
        'Berat: ' + d.weight_gram + 'g (' + d.weight_kg + 'kg) | Asal: ' + (d.origin_city||'Cilegon');
      document.getElementById('ongkir-info').classList.remove('hidden');
    }

    if (!svcs.length) {
      el.innerHTML = '<p class="text-sm text-orange-600 p-3 rounded-xl" style="background:#fff7ed">'
        + '<i class="fas fa-info-circle mr-1"></i> Tidak ada layanan tersedia.</p>';
      return;
    }

    svcs.forEach(s => {
      const cost = s.cost?.[0]?.value || s.price || 0;
      const etd  = s.cost?.[0]?.etd  || s.etd   || '-';
      const name = s.service || s.name || 'REG';
      const desc = s.description || name;

      el.innerHTML += '<label class="flex justify-between items-center p-3 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-orange-400 transition-all svc-label">'
        + '<div class="flex items-center gap-2.5">'
        + '<input type="radio" name="_svc" onchange="selectSvc(\'' + courier + '\',\'' + name + '\',\'' + desc + '\',' + parseInt(cost) + ',' + (parseInt(etd)||2) + ')" class="form-radio">'
        + '<div>'
        + '<p class="text-sm font-semibold text-gray-800">' + name + ' <span class="text-xs text-gray-400 font-normal">— ' + desc + '</span></p>'
        + '<p class="text-xs text-gray-400"><i class="fas fa-clock text-orange-300 mr-0.5"></i> Est. ' + etd + ' hari</p>'
        + '</div>'
        + '</div>'
        + '<span class="font-bold text-sm" style="color:#f97316">Rp ' + parseInt(cost).toLocaleString('id-ID') + '</span>'
        + '</label>';
    });
  })
  .catch(err => {
    document.getElementById('svcs-loading').classList.add('hidden');
    document.getElementById('svcs-list').innerHTML =
      '<p class="text-red-500 text-sm"><i class="fas fa-times-circle mr-1"></i>Gagal memuat. Coba lagi.</p>';
    console.error('Ongkir error:', err);
  });
}

// ===== SELECT SERVICE =====
function selectSvc(courier, svc, svcName, cost, days) {
  ongkir = cost;
  document.getElementById('sel-courier').value    = courier;
  document.getElementById('sel-svc').value        = svc;
  document.getElementById('sel-svc-name').value   = svcName;
  document.getElementById('sel-cost').value       = cost;
  document.getElementById('sel-days').value       = days;
  document.getElementById('disp-ongkir').textContent = 'Rp ' + cost.toLocaleString('id-ID');
  document.getElementById('disp-ongkir').style.color = '#374151';
  document.getElementById('disp-ongkir').classList.remove('italic');
  document.getElementById('disp-total').textContent =
    'Rp ' + (subtotal - disc + cost).toLocaleString('id-ID');

  // Enable submit
  const btn = document.getElementById('submit-btn');
  btn.disabled = false;
  btn.classList.remove('opacity-50','cursor-not-allowed');

  // Highlight service terpilih
  document.querySelectorAll('.svc-label').forEach(l => {
    l.style.borderColor = ''; l.style.background = '';
  });
  if (event?.currentTarget?.closest) {
    const label = event.currentTarget.closest('.svc-label');
    if (label) { label.style.borderColor = '#f97316'; label.style.background = '#fff7ed'; }
  }
}

// ===== FILL ADDRESS FROM SAVED =====
function fillAddr(a) {
  document.getElementById('f_name').value   = a.recipient_name || '';
  document.getElementById('f_phone').value  = a.phone || '';
  document.getElementById('f_addr').value   = a.address || '';
  document.getElementById('f_postal').value = a.postal_code || '';

  // Highlight selected
  document.querySelectorAll('.addr-card').forEach(c => { c.style.borderColor = ''; c.style.background = ''; });
  event?.currentTarget?.closest('.addr-card') && (
    event.currentTarget.closest('.addr-card').style.borderColor = '#f97316',
    event.currentTarget.closest('.addr-card').style.background  = '#fff7ed'
  );

  // Load province → city
  if (a.province_id) {
    const prov = document.getElementById('prov');
    prov.value = a.province_id;
    document.getElementById('prov_name').value = a.province_name || '';
    loadCities(a.province_id);
    // Delay untuk load kota lalu set nilai
    setTimeout(() => {
      if (a.city_id) {
        document.getElementById('city').value = a.city_id;
        document.getElementById('city_name').value = a.city_name || '';
        // Load kecamatan
        if (a.city_id) {
          fetch('/api/districts/' + a.city_id).then(r=>r.json()).then(d=>{
            const di=document.getElementById('dist');
            di.innerHTML='<option value="">-- Pilih Kecamatan --</option>';
            (d.data||[]).forEach(x=>{di.innerHTML+='<option value="'+(x.subdistrict_id||x.id)+'" data-name="'+(x.subdistrict_name||x.name)+'">'+(x.subdistrict_name||x.name)+'</option>';});
            if(a.district_id){di.value=a.district_id;document.getElementById('dist_name').value=a.district_name||'';}
          });
        }
      }
    }, 600);
  }
}

// Payment method style
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('input[name="payment_method"]').forEach(r => {
    r.addEventListener('change', () => {
      document.querySelectorAll('.pm-card').forEach(c => { c.style.borderColor = ''; c.style.background = ''; });
      const card = r.closest('.pm-card');
      if (card) { card.style.borderColor = '#f97316'; card.style.background = '#fff7ed'; }
    });
  });

  // Auto-fill default address on load
  const defaultRadio = document.querySelector('input[name="_aid"]:checked');
  if (defaultRadio) {
    const event = new Event('change');
    defaultRadio.dispatchEvent(event);
  }
});
</script>
@endpush
