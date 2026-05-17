<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentConfirmation;
use App\Services\MailService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller {
    public function __construct(protected MailService $mailer) {}

    public function index(Request $request) {
        $query = Order::with(['user','items'])->latest();
        if ($request->status) $query->where('status', $request->status);
        if ($request->search) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('order_number','like',"%{$s}%")
                ->orWhereHas('user', fn($q) => $q->where('name','like',"%{$s}%")));
        }
        return view('admin.orders.index', ['orders' => $query->paginate(20)->withQueryString()]);
    }

    public function show(string $n) {
        return view('admin.orders.show', [
            'order' => Order::where('order_number', $n)->with(['user','items.product','paymentConfirmation'])->firstOrFail(),
        ]);
    }

    public function updateStatus(Request $request, string $n) {
        $request->validate(['status' => 'required|in:menunggu_bayar,diproses,dikirim,diterima,selesai,dibatalkan', 'tracking_number' => 'nullable|string|max:100']);
        $order = Order::where('order_number', $n)->firstOrFail();
        $data  = ['status' => $request->status];
        if ($request->status === 'dikirim' && $request->tracking_number) { $data['tracking_number'] = $request->tracking_number; $data['shipped_at'] = now(); }
        elseif ($request->status === 'selesai') { $data['completed_at'] = now(); foreach ($order->items as $i) { if ($i->product) $i->product->increment('sold_count', $i->quantity); } }
        elseif ($request->status === 'dibatalkan') { $data['cancelled_at'] = now(); foreach ($order->items as $i) { if ($i->product) $i->product->increment('stock', $i->quantity); } }
        $order->update($data);
        try { $this->mailer->sendOrderStatusUpdate($order->load('user')); } catch (\Exception $e) { Log::warning($e->getMessage()); }
        return back()->with('success', 'Status pesanan diperbarui!');
    }

    public function confirmPayment(Request $request, int $id) {
        $request->validate(['action' => 'required|in:approved,rejected', 'admin_notes' => 'nullable|string']);
        $c = PaymentConfirmation::with('order')->findOrFail($id);
        $c->update(['status' => $request->action, 'admin_notes' => $request->admin_notes]);
        if ($request->action === 'approved') $c->order->update(['payment_status' => 'paid', 'status' => 'diproses', 'paid_at' => now()]);
        return back()->with('success', 'Konfirmasi pembayaran diperbarui!');
    }

    public function pendingPayments() {
        return view('admin.orders.pending-payments', [
            'confirmations' => PaymentConfirmation::with(['order.user'])->where('status','pending')->latest()->paginate(20),
        ]);
    }

    /** Export PDF pesanan */
    public function exportPdf(Request $request) {
        $query = Order::with(['user','items'])->latest();
        if ($request->status) $query->where('status', $request->status);
        $orders = $query->take(500)->get();
        $html   = view('admin.exports.pesanan-pdf', compact('orders'))->render();
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->setPaper('a4','landscape');
            return $pdf->download('pesanan-' . now()->format('Y-m-d') . '.pdf');
        }
        return response($html)->header('Content-Type','text/html');
    }

    /** Export Excel pesanan */
    public function exportExcel(Request $request) {
        if (!class_exists(\PhpOffice\PhpSpreadsheet\Spreadsheet::class))
            return back()->with('error','Install dulu: composer require phpoffice/phpspreadsheet');

        $query  = Order::with(['user','items'])->latest();
        if ($request->status) $query->where('status', $request->status);
        $orders = $query->take(1000)->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = ['No','No. Pesanan','Pelanggan','Penerima','Kota','Kurir','Subtotal','Ongkir','Total','Bayar','Status','Tanggal'];
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col.'1', $h);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $sheet->getStyle($col.'1')->getFont()->setBold(true);
            $sheet->getStyle($col.'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('F97316');
            $col++;
        }
        foreach ($orders as $i => $order) {
            $row  = $i + 2;
            $data = [
                $i+1, $order->order_number, $order->user->name ?? '-', $order->recipient_name,
                $order->city_name, strtoupper($order->courier),
                $order->subtotal, $order->shipping_cost, $order->total,
                $order->payment_method === 'midtrans' ? 'Midtrans' : 'Bank Transfer',
                $order->status_label ?? $order->status, $order->created_at->format('d/m/Y H:i'),
            ];
            $col = 'A';
            foreach ($data as $val) { $sheet->setCellValue($col.$row, $val); $col++; }
        }
        $writer  = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $tmpFile = tempnam(sys_get_temp_dir(), 'xlsx_');
        $writer->save($tmpFile);
        return response()->download($tmpFile, 'pesanan-' . now()->format('Y-m-d') . '.xlsx')->deleteFileAfterSend(true);
    }
}
