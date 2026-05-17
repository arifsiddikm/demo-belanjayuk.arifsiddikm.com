<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller {
    public function index(Request $request) {
        $query = User::query();
        if ($request->search) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name','like',"%{$s}%")->orWhere('email','like',"%{$s}%"));
        }
        if ($request->role) $query->where('role', $request->role);
        return view('admin.users.index', ['users' => $query->latest()->paginate(20)->withQueryString()]);
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string|max:255', 'email' => 'required|email|unique:users', 'role' => 'required|in:user,admin', 'password' => 'required|min:6']);
        User::create(['name' => $request->name, 'email' => $request->email, 'phone' => $request->phone, 'role' => $request->role, 'password' => Hash::make($request->password), 'is_active' => true]);
        return back()->with('success', 'User ditambahkan!');
    }

    public function toggleStatus(User $user) {
        if ($user->id === Auth::id()) return back()->with('error', 'Tidak bisa nonaktifkan akun sendiri');
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'Status user diperbarui');
    }

    public function destroy(User $user) {
        if ($user->id === Auth::id()) return back()->with('error', 'Tidak bisa hapus akun sendiri');
        $user->delete();
        return back()->with('success', 'User dihapus');
    }

    /** Export PDF pengguna */
    public function exportPdf() {
        $users = User::latest()->get();
        $html  = view('admin.exports.users-pdf', compact('users'))->render();
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->setPaper('a4','portrait');
            return $pdf->download('pengguna-' . now()->format('Y-m-d') . '.pdf');
        }
        return response($html)->header('Content-Type','text/html');
    }

    /** Export Excel pengguna */
    public function exportExcel() {
        if (!class_exists(\PhpOffice\PhpSpreadsheet\Spreadsheet::class))
            return back()->with('error','Install dulu: composer require phpoffice/phpspreadsheet');

        $users = User::latest()->get();
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        foreach (['No','Nama','Email','HP','Role','Status','Bergabung'] as $i => $h) {
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i+1);
            $sheet->setCellValue($col.'1', $h);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $sheet->getStyle($col.'1')->getFont()->setBold(true);
        }
        foreach ($users as $i => $user) {
            $data = [$i+1, $user->name, $user->email, $user->phone ?? '-', ucfirst($user->role), $user->is_active ? 'Aktif' : 'Nonaktif', $user->created_at->format('d/m/Y')];
            foreach ($data as $j => $val) {
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($j+1);
                $sheet->setCellValue($col.($i+2), $val);
            }
        }
        $writer  = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $tmpFile = tempnam(sys_get_temp_dir(),'xlsx_');
        $writer->save($tmpFile);
        return response()->download($tmpFile,'pengguna-'.now()->format('Y-m-d').'.xlsx')->deleteFileAfterSend(true);
    }
}
