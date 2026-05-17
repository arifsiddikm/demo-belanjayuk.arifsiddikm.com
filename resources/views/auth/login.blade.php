@extends('layouts.app')
@section('title','Masuk - BelanjaYuk!')
@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
  <div class="w-full max-w-md">
    <div class="text-center mb-8">
      <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg" style="background:linear-gradient(135deg,#f97316,#ea580c)">
        <i class="fas fa-shopping-bag text-white text-2xl"></i>
      </div>
      <h1 class="text-2xl font-extrabold text-gray-900">Masuk ke BelanjaYuk!</h1>
      <p class="text-gray-500 mt-1 text-sm">Selamat datang kembali! 👋</p>
    </div>
    <div class="card p-8">
      @if($errors->any())<div class="alert-error mb-5 text-sm">{{ $errors->first() }}</div>@endif
      <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="space-y-4 mb-6">
          <div>
            <label class="form-label">Email</label>
            <div class="relative">
              <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
              <input type="email" name="email" id="login-email" value="{{ old('email') }}" placeholder="nama@email.com" class="form-input pl-10" required autofocus>
            </div>
          </div>
          <div>
            <label class="form-label">Password</label>
            <div class="relative">
              <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
              <input type="password" id="pwd" name="password" placeholder="Password kamu" class="form-input pl-10 pr-10" required>
              <button type="button" onclick="const i=document.getElementById('pwd');i.type=i.type==='password'?'text':'password'" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>
          <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="remember" class="form-checkbox">
            <span class="text-sm text-gray-600">Ingat saya</span>
          </label>
        </div>
        <button type="submit" class="btn-primary w-full py-3 text-base">
          <i class="fas fa-sign-in-alt mr-2"></i> Masuk Sekarang
        </button>
      </form>

      {{-- Quick Login - HANYA Admin dan User Demo (Arif) --}}
      <div class="mt-4 p-3.5 rounded-xl" style="background:#fff7ed;border:1px solid #fed7aa">
        <p class="text-xs font-bold mb-2.5 flex items-center gap-1" style="color:#c2410c">
          <i class="fas fa-bolt text-yellow-500"></i> Quick Login (Testing):
        </p>
        <div class="grid grid-cols-2 gap-2">
          <button onclick="autofill('admin@belanjayuk.com','admin123')"
            class="text-xs px-3 py-2.5 rounded-lg font-semibold hover:opacity-90 transition-all flex items-center justify-center gap-1.5"
            style="background:linear-gradient(135deg,#f97316,#ea580c);color:#fff">
            <i class="fas fa-cog"></i> Admin
          </button>
          {{-- Label "User Demo" tapi pakai email Arif --}}
          <button onclick="autofill('arifsiddikmuharam@gmail.com','arif123')"
            class="text-xs px-3 py-2.5 rounded-lg font-semibold hover:opacity-90 transition-all flex items-center justify-center gap-1.5"
            style="background:linear-gradient(135deg,#8b5cf6,#7c3aed);color:#fff">
            <i class="fas fa-user"></i> User Demo
          </button>
        </div>
      </div>

      <div class="mt-5 text-center text-sm text-gray-500">
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-semibold hover:underline" style="color:#f97316">Daftar Gratis</a>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
function autofill(email, pass) {
  document.getElementById('login-email').value = email;
  document.getElementById('pwd').value = pass;
}
</script>
@endpush
