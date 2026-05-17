@extends('layouts.admin')
@section('title','Pengaturan')
@section('page-title','Pengaturan Toko')
@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST">
  @csrf
  <div class="grid lg:grid-cols-2 gap-6">
    {{-- Informasi Toko --}}
    <div class="card p-6 space-y-4">
      <h3 class="font-bold text-gray-800 flex items-center gap-2">
        <i class="fas fa-store text-orange-500"></i> Informasi Toko
      </h3>
      <div>
        <label class="form-label">Nama Toko</label>
        <input type="text" name="store_name" value="{{ $settings['store_name'] ?? 'BelanjaYuk!' }}" class="form-input">
      </div>
      <div>
        <label class="form-label">Tagline</label>
        <input type="text" name="store_tagline" value="{{ $settings['store_tagline'] ?? 'Belanja Hemat, Kualitas Terjamin' }}" class="form-input">
      </div>
      <div>
        <label class="form-label">Email</label>
        <input type="email" name="store_email" value="{{ $settings['store_email'] ?? 'admin@belanjayuk.com' }}" class="form-input">
      </div>
      <div>
        <label class="form-label">Telepon</label>
        <input type="text" name="store_phone" value="{{ $settings['store_phone'] ?? '021-12345678' }}" class="form-input">
      </div>
      <div>
        <label class="form-label">WhatsApp (62xxx)</label>
        <input type="text" name="store_whatsapp" value="{{ $settings['store_whatsapp'] ?? '6289514392694' }}" class="form-input" placeholder="6281234567890">
      </div>
      <div>
        <label class="form-label">Alamat</label>
        <textarea name="store_address" class="form-textarea text-sm" rows="3">{{ $settings['store_address'] ?? 'Jl. KH. Yasin Beji No. 12, Cilegon, Banten 42414' }}</textarea>
      </div>
    </div>

    <div class="space-y-6">
      {{-- Rekening Bank --}}
      <div class="card p-6 space-y-4">
        <h3 class="font-bold text-gray-800 flex items-center gap-2">
          <i class="fas fa-university text-orange-500"></i> Rekening Bank
        </h3>
        <div>
          <label class="form-label">BCA</label>
          <input type="text" name="bank_bca" value="{{ $settings['bank_bca'] ?? '1234567890 a.n BelanjaYuk!' }}" class="form-input" placeholder="No.Rek a.n Nama">
        </div>
        <div>
          <label class="form-label">BNI</label>
          <input type="text" name="bank_bni" value="{{ $settings['bank_bni'] ?? '9876543210 a.n BelanjaYuk!' }}" class="form-input" placeholder="No.Rek a.n Nama">
        </div>
        <div>
          <label class="form-label">Mandiri</label>
          <input type="text" name="bank_mandiri" value="{{ $settings['bank_mandiri'] ?? '1357924680 a.n BelanjaYuk!' }}" class="form-input" placeholder="No.Rek a.n Nama">
        </div>
      </div>

      {{-- Pengiriman --}}
      <div class="card p-6 space-y-4">
        <h3 class="font-bold text-gray-800 flex items-center gap-2">
          <i class="fas fa-truck text-orange-500"></i> Pengiriman
        </h3>
        <div>
          <label class="form-label">ID Kota Asal (RajaOngkir)</label>
          <input type="text" name="shipping_origin_city" value="{{ $settings['shipping_origin_city'] ?? '17' }}" class="form-input" placeholder="Contoh: 17 = Cilegon">
          <p class="text-xs text-gray-400 mt-1">
            <i class="fas fa-info-circle text-orange-400"></i>
            Cilegon = 17, Jakarta Pusat = 152, Bandung = 23, Surabaya = 71
          </p>
        </div>
        <div>
          <label class="form-label">Meta Description SEO</label>
          <textarea name="meta_description" class="form-textarea text-sm" rows="2">{{ $settings['meta_description'] ?? 'BelanjaYuk! - Toko Online Fashion & Elektronik Terpercaya. Belanja Hemat, Kualitas Terjamin, Pengiriman Cepat ke Seluruh Indonesia.' }}</textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="mt-6">
    <button type="submit" class="btn-primary px-8 py-3 text-base">
      <i class="fas fa-save mr-2"></i> Simpan Pengaturan
    </button>
  </div>
</form>
@endsection
