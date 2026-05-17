@extends('layouts.app')
@section('title','Daftar - BelanjaYuk!')
@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
  <div class="w-full max-w-md">
    <div class="text-center mb-8">
      <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg" style="background:linear-gradient(135deg,#22c55e,#15803d)">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
      </div>
      <h1 class="text-2xl font-extrabold text-gray-900">Buat Akun BelanjaYuk!</h1>
      <p class="text-gray-500 mt-1 text-sm">Gratis & langsung bisa belanja 🛍️</p>
    </div>
    <div class="card p-8">
      @if($errors->any())<div class="alert-error mb-5 text-sm"><ul>@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul></div>@endif
      <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <div class="space-y-4 mb-6">
          <div><label class="form-label">Nama Lengkap</label><input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap kamu" class="form-input" required></div>
          <div><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" class="form-input" required></div>
          <div><label class="form-label">No. HP <span class="text-gray-400 font-normal">(opsional)</span></label><input type="tel" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxx" class="form-input"></div>
          <div><label class="form-label">Password</label><input type="password" id="p1" name="password" placeholder="Min. 6 karakter" class="form-input" required></div>
          <div><label class="form-label">Konfirmasi Password</label><input type="password" name="password_confirmation" placeholder="Ulangi password" class="form-input" required></div>
          <label class="flex items-start gap-2 cursor-pointer"><input type="checkbox" required class="form-checkbox mt-0.5"><span class="text-sm text-gray-600">Setuju dengan <a href="#" class="text-green-600 font-semibold">Syarat & Ketentuan</a></span></label>
        </div>
        <button type="submit" class="btn-primary w-full py-3 text-base">Daftar Sekarang</button>
      </form>
      <div class="mt-5 text-center text-sm text-gray-500">Sudah punya akun? <a href="{{ route('login') }}" class="text-green-600 font-semibold">Masuk</a></div>
    </div>
  </div>
</div>
@endsection