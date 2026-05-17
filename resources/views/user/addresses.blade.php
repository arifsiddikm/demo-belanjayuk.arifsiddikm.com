@extends('layouts.app')
@section('title','Alamat - BelanjaYuk!')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
  <div class="flex items-center justify-between mb-7"><h1 class="text-2xl font-extrabold text-gray-900">📍 Alamat Saya</h1><button onclick="document.getElementById('add-addr').classList.toggle('hidden')" class="btn-primary">+ Tambah Alamat</button></div>
  <div id="add-addr" class="card p-6 mb-6 hidden">
    <h3 class="font-bold text-gray-800 mb-5">Tambah Alamat Baru</h3>
    <form action="{{ route('user.addresses.store') }}" method="POST">
      @csrf
      <div class="grid sm:grid-cols-2 gap-4 mb-4">
        <div><label class="form-label">Label</label><input type="text" name="label" value="Rumah" class="form-input" required placeholder="Rumah/Kantor/dll"></div>
        <div><label class="form-label">Nama Penerima</label><input type="text" name="recipient_name" value="{{ Auth::user()->name }}" class="form-input" required></div>
        <div><label class="form-label">No. HP</label><input type="text" name="phone" value="{{ Auth::user()->phone }}" class="form-input" required></div>
        <div class="sm:col-span-2"><label class="form-label">Alamat Lengkap</label><textarea name="address" class="form-textarea" rows="2" required></textarea></div>
        <div><label class="form-label">Provinsi *</label>
          <select name="province_id" id="a-prov" class="form-select" required onchange="loadCities()">
            <option value="">-- Pilih Provinsi --</option>
            @foreach($provinces as $p)<option value="{{ $p['province_id']??$p['id'] }}" data-name="{{ $p['province']??$p['name'] }}">{{ $p['province']??$p['name'] }}</option>@endforeach
          </select><input type="hidden" name="province_name" id="a-prov-name"></div>
        <div><label class="form-label">Kota *</label>
          <select name="city_id" id="a-city" class="form-select" required onchange="loadDistricts()"><option value="">-- Pilih Kota --</option></select>
          <input type="hidden" name="city_name" id="a-city-name"></div>
        <div><label class="form-label">Kecamatan</label>
          <select name="district_id" id="a-dist" class="form-select" onchange="document.getElementById('a-dist-name').value=this.options[this.selectedIndex].dataset.name||''"><option value="">-- Pilih Kecamatan --</option></select>
          <input type="hidden" name="district_name" id="a-dist-name"></div>
        <div><label class="form-label">Kode Pos</label><input type="text" name="postal_code" class="form-input" placeholder="12345"></div>
      </div>
      <label class="flex items-center gap-2 cursor-pointer mb-4"><input type="checkbox" name="is_default" value="1" class="form-checkbox"><span class="text-sm font-medium">Jadikan alamat utama</span></label>
      <div class="flex gap-2"><button type="submit" class="btn-primary">Simpan Alamat</button><button type="button" onclick="document.getElementById('add-addr').classList.add('hidden')" class="btn-outline">Batal</button></div>
    </form>
  </div>
  <div class="space-y-4">
    @forelse($addresses as $addr)
    <div class="card p-5 flex gap-4 {{ $addr->is_default?'border-2 border-green-500':'' }}">
      <div class="text-2xl">{{ $addr->label==='Rumah'?'🏠':($addr->label==='Kantor'?'🏢':'📍') }}</div>
      <div class="flex-1">
        <div class="flex items-center gap-2 mb-1"><p class="font-bold text-gray-800">{{ $addr->label }}</p>@if($addr->is_default)<span class="badge badge-green text-xs">Utama</span>@endif</div>
        <p class="font-medium text-gray-700 text-sm">{{ $addr->recipient_name }} · {{ $addr->phone }}</p>
        <p class="text-sm text-gray-500 mt-1">{{ $addr->address }}, {{ $addr->city_name }}, {{ $addr->province_name }}</p>
      </div>
      <form action="{{ route('user.addresses.delete',$addr) }}" method="POST" onsubmit="return confirm('Hapus alamat ini?')">
        @csrf @method('DELETE')
        <button type="submit" class="w-8 h-8 rounded-lg hover:bg-red-50 flex items-center justify-center text-gray-400 hover:text-red-500">🗑</button>
      </form>
    </div>
    @empty
    <div class="text-center py-16"><div class="text-5xl mb-3">📍</div><p class="text-gray-500">Belum ada alamat</p><button onclick="document.getElementById('add-addr').classList.remove('hidden')" class="btn-primary mt-4">Tambah Alamat</button></div>
    @endforelse
  </div>
</div>
@endsection
@push('scripts')
<script>
function loadCities(){const s=document.getElementById('a-prov');document.getElementById('a-prov-name').value=s.options[s.selectedIndex].dataset.name;fetch('/api/cities/'+s.value).then(r=>r.json()).then(d=>{const c=document.getElementById('a-city');c.innerHTML='<option value="">-- Pilih Kota --</option>';(d.data||[]).forEach(x=>c.innerHTML+=`<option value="${x.city_id||x.id}" data-name="${x.city_name||x.name}">${x.city_name||x.name}</option>`);});}
function loadDistricts(){const s=document.getElementById('a-city');document.getElementById('a-city-name').value=s.options[s.selectedIndex].dataset.name;fetch('/api/districts/'+s.value).then(r=>r.json()).then(d=>{const di=document.getElementById('a-dist');di.innerHTML='<option value="">-- Pilih Kecamatan --</option>';(d.data||[]).forEach(x=>di.innerHTML+=`<option value="${x.subdistrict_id||x.id}" data-name="${x.subdistrict_name||x.name}">${x.subdistrict_name||x.name}</option>`);});}
</script>
@endpush