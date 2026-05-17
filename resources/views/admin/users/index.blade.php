@extends('layouts.admin')
@section('title','Pengguna')
@section('page-title','Kelola Pengguna')
@section('content')

<div class="card overflow-hidden">
  <div class="p-5 border-b border-orange-50">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
      <h3 class="font-bold text-gray-800">Daftar Pengguna</h3>
      <div class="flex gap-2">
        <a href="{{ route('admin.users.export-excel') }}" class="btn-outline btn-sm">
          <i class="fas fa-file-excel text-green-600"></i> Excel
        </a>
        <a href="{{ route('admin.users.export-pdf') }}" class="btn-danger btn-sm">
          <i class="fas fa-file-pdf"></i> PDF
        </a>
        <button onclick="document.getElementById('modal-add-user').classList.remove('hidden')" class="btn-primary btn-sm">
          <i class="fas fa-user-plus"></i> Tambah Admin
        </button>
      </div>
    </div>
    <form method="GET" class="flex flex-wrap gap-3">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="form-input text-sm flex-1 min-w-48">
      <select name="role" class="form-select text-sm w-36">
        <option value="">Semua Role</option>
        <option value="user" {{ request('role')==='user'?'selected':'' }}>User</option>
        <option value="admin" {{ request('role')==='admin'?'selected':'' }}>Admin</option>
      </select>
      <button type="submit" class="btn-primary btn-sm"><i class="fas fa-search mr-1"></i> Cari</button>
      @if(request()->hasAny(['search','role']))<a href="{{ route('admin.users.index') }}" class="btn-outline btn-sm">Reset</a>@endif
    </form>
  </div>
  <div class="overflow-x-auto">
    <table class="w-full">
      <thead>
        <tr class="bg-orange-50 text-left">
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Pengguna</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Role</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Bergabung</th>
          <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @foreach($users as $user)
        <tr class="hover:bg-orange-50 transition-colors">
          <td class="px-4 py-3.5">
            <div class="flex items-center gap-3">
              <img src="{{ $user->avatar_url }}" class="w-9 h-9 rounded-full object-cover border-2" style="border-color:#fed7aa">
              <div>
                <p class="font-semibold text-sm text-gray-800">{{ $user->name }}</p>
                <p class="text-xs text-gray-400">{{ $user->email }}</p>
              </div>
            </div>
          </td>
          <td class="px-4 py-3.5"><span class="badge {{ $user->role==='admin'?'badge-purple':'badge-blue' }}">{{ ucfirst($user->role) }}</span></td>
          <td class="px-4 py-3.5"><span class="badge {{ $user->is_active?'badge-green':'badge-red' }}">{{ $user->is_active?'Aktif':'Nonaktif' }}</span></td>
          <td class="px-4 py-3.5 text-xs text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
          <td class="px-4 py-3.5">
            <div class="flex gap-1.5 flex-wrap">
              <form action="{{ route('admin.users.toggle-status',$user) }}" method="POST" class="inline">
                @csrf
                <button type="button" onclick="confirmToggle(event,this,'{{ $user->name }}',{{ $user->is_active?'true':'false' }})"
                  class="{{ $user->is_active?'btn-warning':'btn-primary' }} btn-sm">
                  <i class="fas fa-{{ $user->is_active?'ban':'check' }} mr-1"></i>{{ $user->is_active?'Nonaktifkan':'Aktifkan' }}
                </button>
              </form>
              @if($user->id!==Auth::id())
              <form action="{{ route('admin.users.destroy',$user) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="button" onclick="confirmDeleteUser(event,this,'{{ $user->name }}')" class="btn-danger btn-sm">
                  <i class="fas fa-trash mr-1"></i> Hapus
                </button>
              </form>
              @endif
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @if($users->hasPages())
  <div class="px-5 py-4 border-t border-orange-50 flex justify-center gap-1.5">{{ $users->links() }}</div>
  @endif
</div>

{{-- Modal tambah user --}}
<div id="modal-add-user" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
    <div class="flex justify-between items-center mb-5">
      <h3 class="text-lg font-bold text-gray-800">Tambah Admin Baru</h3>
      <button onclick="document.getElementById('modal-add-user').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
    </div>
    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
      @csrf
      <div><label class="form-label">Nama Lengkap</label><input type="text" name="name" class="form-input" required></div>
      <div><label class="form-label">Email</label><input type="email" name="email" class="form-input" required></div>
      <div><label class="form-label">No. HP</label><input type="text" name="phone" class="form-input"></div>
      <div><label class="form-label">Role</label><select name="role" class="form-select" required><option value="user">User</option><option value="admin">Admin</option></select></div>
      <div><label class="form-label">Password</label><input type="password" name="password" class="form-input" required minlength="6"></div>
      <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary flex-1">Simpan</button>
        <button type="button" onclick="document.getElementById('modal-add-user').classList.add('hidden')" class="btn-outline flex-1">Batal</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
function confirmToggle(e,btn,name,isActive){
  e.preventDefault();
  Swal.fire({title:isActive?'Nonaktifkan?':'Aktifkan?',text:name+' akan '+(isActive?'dinonaktifkan':'diaktifkan'),icon:'question',showCancelButton:true,confirmButtonText:'Ya',cancelButtonText:'Batal',confirmButtonColor:'#f97316'}).then(r=>{if(r.isConfirmed)btn.closest('form').submit();});
}
function confirmDeleteUser(e,btn,name){
  e.preventDefault();
  Swal.fire({title:'Hapus User?',text:'"'+name+'" akan dihapus permanen!',icon:'warning',showCancelButton:true,confirmButtonText:'Hapus',cancelButtonText:'Batal',confirmButtonColor:'#ef4444',cancelButtonColor:'#f97316'}).then(r=>{if(r.isConfirmed)btn.closest('form').submit();});
}
</script>
@endpush
@endsection
