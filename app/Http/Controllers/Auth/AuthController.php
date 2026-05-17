<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller {
    public function showLogin() { if(Auth::check())return redirect()->route('home');return view('auth.login'); }
    public function login(Request $request) {
        $request->validate(['email'=>'required|email','password'=>'required|min:6'],['email.required'=>'Email wajib diisi','password.required'=>'Password wajib diisi']);
        if(Auth::attempt($request->only('email','password'),$request->boolean('remember'))){
            $request->session()->regenerate();$user=Auth::user();
            if(!$user->is_active){Auth::logout();return back()->withErrors(['email'=>'Akun dinonaktifkan.']);}
            return $user->isAdmin()?redirect()->route('admin.dashboard'):redirect()->intended(route('home'));
        }
        return back()->withErrors(['email'=>'Email atau password salah.'])->withInput($request->except('password'));
    }
    public function showRegister() { if(Auth::check())return redirect()->route('home');return view('auth.register'); }
    public function register(Request $request) {
        $request->validate(['name'=>'required|string|max:255','email'=>'required|email|unique:users','phone'=>'nullable|string|max:20','password'=>['required','confirmed',Password::min(6)]]);
        $user=User::create(['name'=>strip_tags($request->name),'email'=>$request->email,'phone'=>$request->phone,'password'=>Hash::make($request->password),'role'=>'user','is_active'=>true]);
        Auth::login($user);$request->session()->regenerate();
        return redirect()->route('home')->with('success','Selamat datang di BelanjaYuk!, '.$user->name.' 🎉');
    }
    public function logout(Request $request) {
        Auth::logout();$request->session()->invalidate();$request->session()->regenerateToken();
        return redirect()->route('home')->with('success','Berhasil logout. Sampai jumpa!');
    }
}
