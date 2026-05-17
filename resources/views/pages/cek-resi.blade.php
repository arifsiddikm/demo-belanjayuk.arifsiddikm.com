@extends('layouts.app')
@section('title','Cek Resi - BelanjaYuk!')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">

  {{-- Hero --}}
  <div class="text-center mb-8">
    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg" style="background:linear-gradient(135deg,#f97316,#ea580c)">
      <i class="fas fa-box-open text-white text-2xl"></i>
    </div>
    <h1 class="text-2xl font-extrabold text-gray-900 mb-1">Cek Status Pengiriman</h1>
    <p class="text-sm text-gray-400">Lacak paketmu dari berbagai ekspedisi dalam satu halaman</p>
  </div>

  <div class="card p-6 mb-6">
    {{-- Input Resi --}}
    <div class="mb-5">
      <label class="form-label">Nomor Resi</label>
      <div class="relative">
        <i class="fas fa-barcode absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        <input type="text" id="awb" placeholder="Masukkan nomor resi..." class="form-input pl-10 font-mono text-base" oninput="this.value=this.value.toUpperCase()">
      </div>
    </div>

    {{-- Autofill Resi Dummy per Kurir --}}
    <div class="mb-5 p-4 rounded-xl" style="background:#fff7ed;border:1px solid #fed7aa">
      <p class="text-xs font-bold mb-2.5 flex items-center gap-1" style="color:#c2410c">
        <i class="fas fa-bolt text-yellow-500"></i> Autofill Resi Testing:
      </p>
      <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
        @foreach([
          ['jne','JNE','JNE1234567890'],
          ['jnt','J&T','JT234567891011'],
          ['sicepat','SiCepat','000SCP1234567'],
          ['anteraja','AnterAja','ANTJ12345678'],
          ['pos','Pos','P123456789IDN'],
          ['tiki','TIKI','TIKI12345678'],
          ['ninja','Ninja','NXID1234567'],
          ['sap','SAP','SAP1234567890'],
          ['lion','Lion','LP1234567890'],
          ['wahana','Wahana','WH1234567890'],
        ] as [$code,$label,$resi])
        <button onclick="autofillResi('{{ $resi }}','{{ $code }}')"
          class="text-xs px-2 py-2 rounded-lg font-semibold hover:opacity-90 transition-all text-center"
          style="background:#f97316;color:#fff">
          {{ $label }}
        </button>
        @endforeach
      </div>
    </div>

    {{-- Pilih Kurir --}}
    <div class="mb-5">
      <label class="form-label">Pilih Kurir</label>
      <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
        @foreach($couriers as $c)
        <label id="courier-{{ $c['code'] }}" class="flex flex-col items-center gap-1.5 p-3 rounded-xl border-2 border-gray-200 cursor-pointer transition-all courier-opt text-center hover:border-orange-400">
          <input type="radio" name="courier" value="{{ $c['code'] }}" class="hidden">
          <i class="fas fa-truck text-gray-400 text-sm courier-icon"></i>
          <span class="text-xs font-bold text-gray-700">{{ $c['name'] }}</span>
        </label>
        @endforeach
      </div>
    </div>

    <button onclick="trackPkg()" class="btn-primary w-full py-3.5 text-base">
      <i class="fas fa-search mr-2"></i> Lacak Paket
    </button>
  </div>

  {{-- Result --}}
  <div id="result" class="hidden">
    <div id="loading" class="card p-8 text-center hidden">
      <div class="spinner mx-auto mb-3"></div>
      <p class="text-gray-500 text-sm">Melacak paket...</p>
    </div>
    <div id="track-result"></div>
  </div>

</div>
@endsection

@push('scripts')
<script>
// Pilih kurir click
document.querySelectorAll('.courier-opt').forEach(o => {
  o.addEventListener('click', () => {
    document.querySelectorAll('.courier-opt').forEach(x => {
      x.classList.remove('border-orange-500','bg-orange-50');
      x.style.borderColor = '';
      x.style.background  = '';
    });
    o.style.borderColor = '#f97316';
    o.style.background  = '#fff7ed';
    o.querySelector('input').checked = true;
  });
});

// Autofill resi + kurir
function autofillResi(resi, courier) {
  document.getElementById('awb').value = resi;
  // Klik label kurir yang sesuai
  const label = document.getElementById('courier-' + courier);
  if (label) {
    label.click();
    label.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }
}

function trackPkg() {
  const awb = document.getElementById('awb').value.trim();
  const c   = document.querySelector('input[name="courier"]:checked');

  if (!awb) {
    Swal.fire({ toast: true, position: 'top-end', icon: 'warning', title: 'Masukkan nomor resi!', showConfirmButton: false, timer: 2000 });
    return;
  }
  if (!c) {
    Swal.fire({ toast: true, position: 'top-end', icon: 'warning', title: 'Pilih kurir dulu!', showConfirmButton: false, timer: 2000 });
    return;
  }

  document.getElementById('result').classList.remove('hidden');
  document.getElementById('loading').classList.remove('hidden');
  document.getElementById('track-result').innerHTML = '';

  fetch('{{ route("cek-resi.track") }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
    body: JSON.stringify({ awb: awb, courier: c.value })
  })
  .then(r => r.json())
  .then(d => {
    document.getElementById('loading').classList.add('hidden');

    if (d.error) {
      document.getElementById('track-result').innerHTML = `
        <div class="card p-8 text-center">
          <i class="fas fa-times-circle text-4xl text-red-400 mb-3 block"></i>
          <p class="text-red-600 font-semibold">${d.error}</p>
        </div>`;
      return;
    }

    const manifest = d.manifest || d.history || [];
    const courier  = c.value.toUpperCase();
    const status   = d.status || 'DALAM PROSES';
    const isDelivered = status === 'DELIVERED';

    let html = `<div class="card overflow-hidden">
      <!-- Header -->
      <div class="p-5 border-b border-orange-50" style="background:linear-gradient(135deg,#fff7ed,#fff)">
        <div class="flex items-start justify-between gap-3 flex-wrap">
          <div>
            <div class="flex items-center gap-2 mb-1">
              <i class="fas fa-truck text-orange-500"></i>
              <span class="font-extrabold text-gray-900">${courier}</span>
              <span class="font-mono text-sm font-bold px-2 py-0.5 rounded" style="background:#fff7ed;color:#ea580c">${awb}</span>
            </div>
            <p class="text-xs text-gray-400">Status pengiriman real-time</p>
          </div>
          <span class="badge ${isDelivered ? 'badge-green' : 'badge-orange'} text-sm">
            <i class="fas fa-${isDelivered ? 'check-circle' : 'shipping-fast'} mr-1"></i>
            ${isDelivered ? 'Terkirim' : 'Dalam Perjalanan'}
          </span>
        </div>
      </div>
      <!-- Timeline -->
      <div class="p-5">
        <h4 class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
          <i class="fas fa-history text-orange-500"></i> Riwayat Pengiriman
        </h4>
        <div class="relative">
          <div class="absolute left-3.5 top-2 bottom-2 w-0.5 bg-gray-200"></div>`;

    if (manifest.length) {
      manifest.forEach((m, i) => {
        const desc = m.description || m.desc || m.status || '';
        const date = m.date || m.manifest_date || '';
        const time = m.time || m.manifest_time || '';
        const isFirst = i === 0;
        const isCakung = desc.includes('DC Cakung') || desc.includes('Cakung');

        html += `<div class="flex gap-4 mb-4 relative">
          <div class="flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center z-10 ${isFirst ? 'bg-orange-500' : (isCakung ? 'bg-blue-400' : 'bg-gray-200')}">
            <i class="fas fa-${isFirst ? 'check' : (isCakung ? 'warehouse' : 'circle')} text-${isFirst ? 'white' : (isCakung ? 'white' : 'gray-400')} text-xs"></i>
          </div>
          <div class="flex-1 pb-2 ${isFirst ? 'font-semibold text-gray-900' : 'text-gray-600'}">
            <p class="text-sm leading-snug">${desc}</p>
            <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
              <i class="fas fa-clock text-orange-300 text-xs"></i> ${date} ${time}
            </p>
          </div>
        </div>`;
      });
    } else {
      html += `<p class="text-gray-400 text-sm ml-10">Data pengiriman belum tersedia</p>`;
    }

    html += `</div></div>
      <div class="px-5 pb-5">
        <a href="{{ route('produk.index') }}" class="btn-primary w-full py-2.5 text-sm text-center block">
          <i class="fas fa-shopping-bag mr-2"></i> Belanja Lagi di BelanjaYuk!
        </a>
      </div>
    </div>`;

    document.getElementById('track-result').innerHTML = html;
  })
  .catch(() => {
    document.getElementById('loading').classList.add('hidden');
    document.getElementById('track-result').innerHTML = `
      <div class="card p-8 text-center">
        <i class="fas fa-wifi text-4xl text-gray-300 mb-3 block"></i>
        <p class="text-red-500 font-medium">Gagal memuat. Coba lagi.</p>
      </div>`;
  });
}
</script>
@endpush
