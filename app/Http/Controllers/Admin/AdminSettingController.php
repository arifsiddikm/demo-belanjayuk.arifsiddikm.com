<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller {
    public function index() {
        return view('admin.settings.index', ['settings' => StoreSetting::all()->pluck('value', 'key')]);
    }

    public function update(Request $request) {
        foreach ($request->except(['_token', '_method']) as $key => $value)
            StoreSetting::set($key, $value);
        return back()->with('success', 'Pengaturan disimpan!');
    }
}
