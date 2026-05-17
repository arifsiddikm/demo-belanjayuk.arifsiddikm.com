<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckResiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Api\RajaOngkirController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('produk')->name('produk.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('/kategori/{slug}', [ProductController::class, 'category'])->name('category');
    Route::get('/{slug}', [ProductController::class, 'show'])->name('show');
});

Route::get('/cek-resi', [CheckResiController::class, 'index'])->name('cek-resi');
Route::post('/cek-resi/track', [CheckResiController::class, 'track'])->name('cek-resi.track');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->prefix('dashboard')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/pesanan', [UserController::class, 'orders'])->name('orders');
    Route::get('/pesanan/{orderNumber}', [UserController::class, 'orderShow'])->name('orders.show');
    Route::post('/pesanan/{orderNumber}/cancel', [UserController::class, 'orderCancel'])->name('orders.cancel');
    Route::post('/pesanan/{orderNumber}/received', [UserController::class, 'orderReceived'])->name('orders.received');
    Route::get('/pesanan/{orderNumber}/track', [UserController::class, 'orderTrack'])->name('orders.track');
    Route::get('/profil', [UserController::class, 'profile'])->name('profile');
    Route::post('/profil', [UserController::class, 'profileUpdate'])->name('profile.update');
    Route::post('/profil/password', [UserController::class, 'passwordUpdate'])->name('profile.password');
    Route::get('/alamat', [UserController::class, 'addresses'])->name('addresses');
    Route::post('/alamat', [UserController::class, 'addressStore'])->name('addresses.store');
    Route::delete('/alamat/{address}', [UserController::class, 'addressDelete'])->name('addresses.delete');
    Route::get('/wishlist', [UserController::class, 'wishlist'])->name('wishlist');
    Route::post('/review', [UserController::class, 'reviewStore'])->name('review.store');
});

Route::middleware('auth')->prefix('keranjang')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/tambah', [CartController::class, 'add'])->name('add');
    Route::patch('/{cart}', [CartController::class, 'update'])->name('update');
    Route::delete('/{cart}', [CartController::class, 'remove'])->name('remove');
    Route::post('/kupon', [CartController::class, 'applyCoupon'])->name('coupon');
    Route::get('/count', [CartController::class, 'getCount'])->name('count');
});

Route::post('/wishlist/toggle', [UserController::class, 'wishlistToggle'])->name('wishlist.toggle')->middleware('auth');

Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
    Route::post('/shipping-cost', [CheckoutController::class, 'getShippingCost'])->name('shipping-cost');
    Route::get('/bayar/{orderNumber}', [CheckoutController::class, 'payment'])->name('payment');
    Route::get('/sukses/{orderNumber}', [CheckoutController::class, 'success'])->name('success');
    Route::post('/upload-bukti/{orderNumber}', [CheckoutController::class, 'uploadProof'])->name('upload-proof');
});

Route::post('/midtrans/callback', [CheckoutController::class, 'midtransCallback'])->name('midtrans.callback');

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/provinces', [RajaOngkirController::class, 'provinces'])->name('provinces');
    Route::get('/cities/{provinceId}', [RajaOngkirController::class, 'cities'])->name('cities');
    Route::get('/districts/{cityId}', [RajaOngkirController::class, 'districts'])->name('districts');
    Route::post('/shipping-cost', [RajaOngkirController::class, 'cost'])->name('shipping-cost');
    Route::post('/track', [RajaOngkirController::class, 'track'])->name('track');
});

Route::middleware(['auth','admin'])->prefix('webmin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('pesanan')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/konfirmasi-bayar', [AdminOrderController::class, 'pendingPayments'])->name('pending-payments');
        Route::get('/export-excel', [AdminOrderController::class, 'exportExcel'])->name('export-excel');
        Route::get('/export-pdf', [AdminOrderController::class, 'exportPdf'])->name('export-pdf');
        Route::get('/{orderNumber}', [AdminOrderController::class, 'show'])->name('show');
        Route::post('/{orderNumber}/status', [AdminOrderController::class, 'updateStatus'])->name('update-status');
        Route::post('/konfirmasi-bayar/{id}', [AdminOrderController::class, 'confirmPayment'])->name('confirm-payment');
    });

    Route::prefix('produk')->name('products.')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('index');
        Route::get('/buat', [AdminProductController::class, 'create'])->name('create');
        Route::post('/', [AdminProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [AdminProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [AdminProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [AdminProductController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('kategori')->name('categories.')->group(function () {
        Route::get('/', [AdminCategoryController::class, 'index'])->name('index');
        Route::post('/', [AdminCategoryController::class, 'store'])->name('store');
        Route::put('/{category}', [AdminCategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [AdminCategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('pengguna')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::post('/', [AdminUserController::class, 'store'])->name('store');
        Route::post('/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
        Route::get('/export-excel', [AdminUserController::class, 'exportExcel'])->name('export-excel');
        Route::get('/export-pdf', [AdminUserController::class, 'exportPdf'])->name('export-pdf');
    });

    Route::get('/pengaturan', [AdminSettingController::class, 'index'])->name('settings');
    Route::post('/pengaturan', [AdminSettingController::class, 'update'])->name('settings.update');

    Route::get('/laporan', [AdminReportController::class, 'index'])->name('reports');
    Route::get('/laporan/export-excel', [AdminReportController::class, 'exportExcel'])->name('reports.export-excel');
    Route::get('/laporan/export-pdf', [AdminReportController::class, 'exportPdf'])->name('reports.export-pdf');
});
