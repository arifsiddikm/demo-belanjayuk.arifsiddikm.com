@extends('layouts.app')
@section('title','Profil - BelanjaYuk!')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
  <h1 class="text-2xl font-extrabold text-gray-900 mb-7">👤 Profil Saya</h1>
  <div class="card p-7 mb-6">
    <div class="flex items-center gap-5 mb-7">
      <img src="{{ $user->avatar_url }}" class="w-20 h-20 rounded-full object-cover border-4 border-green-200" id="av-preview">
      <div><h2 class="text-xl font-bold">{{ $user->name }}</h2><p class="text-gray-400">{{ $user->email }}</p></div>
    </div>
    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @if($errors->any())<div class="alert-error mb-4 text-sm"><ul>@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul></div>@endif
      <div class="space-y-4">
        <div><label class="form-label">Nama Lengkap</label><input type="text" name="name" value="{{ old('name',$user->name) }}" class="form-input" required></div>
        <div><label class="form-label">Email <span class="text-gray-400 font-normal">(tidak dapat diubah)</span></label><input type="email" value="{{ $user->email }}" class="form-input bg-gray-50 text-gray-400" disabled></div>
        <div><label class="form-label">No. HP</label><input type="tel" name="phone" value="{{ old('phone',$user->phone) }}" class="form-input" placeholder="08xxxxxxxxx"></div>
        <div><label class="form-label">Foto Profil</label><input type="file" name="avatar" accept="image/*" class="form-input text-sm" onchange="const r=new FileReader();r.onload=e=>document.getElementById('av-preview').src=e.target.result;r.readAsDataURL(this.files[0])"></div>
      </div>
      <button type="submit" class="btn-primary mt-5">💾 Simpan Profil</button>
    </form>
  </div>
  <div class="card p-7">
    <h3 class="font-bold text-gray-800 mb-5">🔒 Ubah Password</h3>
    <form action="{{ route('user.profile.password') }}" method="POST">
      @csrf
      <div class="space-y-4">
        <div><label class="form-label">Password Lama</label><input type="password" name="current_password" class="form-input" required>@error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Password Baru</label><input type="password" name="password" class="form-input" required></div>
        <div><label class="form-label">Konfirmasi Password Baru</label><input type="password" name="password_confirmation" class="form-input" required></div>
      </div>
      <button type="submit" class="btn-primary mt-5">🔒 Ubah Password</button>
    </form>
  </div>
</div>
@endsection