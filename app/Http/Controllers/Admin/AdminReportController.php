<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminReportController extends Controller {
    public function index(Request $request) {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : now()->startOfMonth();
        $endDate   = $request->end_date   ? Carbon::parse($request->end_date)   : now()->endOfMonth();
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->with(['user','items'])
            ->whereIn('status', ['selesai','dikirim','diterima','diproses'])
            ->latest()
            ->paginate(20)
            ->withQueryString();
        $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['selesai','dikirim','diterima'])
            ->sum('total');
        return view('admin.reports.index', compact('orders','totalRevenue','startDate','endDate'));
    }

    /** Export PDF laporan */
    public function exportPdf(Request $request) {
        $startDate    = $request->start_date ? Carbon::parse($request->start_date) : now()->startOfMonth();
        $endDate      = $request->end_date   ? Carbon::parse($request->end_date)   : now()->endOfMonth();
        $orders       = Order::whereBetween('created_at', [$startDate, $endDate])
            ->with(['user','items'])
            ->whereIn('status', ['selesai','dikirim','diterima','diproses'])
            ->latest()->get();
        $totalRevenue = $orders->whereIn('status', ['selesai','dikirim','diterima'])->sum('total');

        $html = view('admin.exports.laporan-pdf', compact('orders','totalRevenue','startDate','endDate'))->render();

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->download('laporan-penjualan-' . $startDate->format('Y-m-d') . '.pdf');
        }

        // Fallback: tampilkan HTML jika DomPDF belum diinstall
        return response($html)->header('Content-Type', 'text/html');
    }

    /** Export Excel laporan */
    public function exportExcel(Request $request) {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : now()->startOfMonth();
        $endDate   = $request->end_date   ? Carbon::parse($request->end_date)   : now()->endOfMonth();
        $orders    = Order::whereBetween('created_at', [$startDate, $endDate])
            ->with(['user','items'])
            ->whereIn('status', ['selesai','dikirim','diterima','diproses'])
            ->latest()->get();

        return $this->generateExcel($orders, [
            ['No','No. Pesanan','Pelanggan','Total','Status','Metode Bayar','Tanggal'],
        ], function($order, $i) {
            return [
                $i+1,
                $order->order_number,
                $order->user->name ?? '-',
                $order->total,
                $order->status_label ?? $order->status,
                $order->payment_method,
                $order->created_at->format('d/m/Y H:i'),
            ];
        }, $orders->values(), 'laporan-penjualan-' . $startDate->format('Y-m-d') . '.xlsx');
    }

    /** Shared Excel generator */
    protected function generateExcel($rows, array $headers, callable $mapper, $collection, string $filename) {
        if (!class_exists(\PhpOffice\PhpSpreadsheet\Spreadsheet::class)) {
            return back()->with('error', 'Install PhpSpreadsheet dulu: composer require phpoffice/phpspreadsheet');
        }
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Headers
        $col = 'A';
        foreach ($headers[0] as $header) {
            $sheet->setCellValue($col . '1', $header);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $sheet->getStyle($col . '1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('F97316');
            $col++;
        }
        // Data
        foreach ($collection as $i => $row) {
            $rowData = $mapper($row, $i);
            $col = 'A';
            foreach ($rowData as $val) {
                $sheet->setCellValue($col . ($i + 2), $val);
                $col++;
            }
        }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $tmpFile = tempnam(sys_get_temp_dir(), 'xlsx_');
        $writer->save($tmpFile);
        return response()->download($tmpFile, $filename)->deleteFileAfterSend(true);
    }
}
