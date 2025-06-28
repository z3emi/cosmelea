<?php
// ======================================================================
// الملف: routes/web.php (النسخة المستقرة)
// ======================================================================

use Illuminate\Support\Facades\Route;

// --- استدعاء المتحكمات ---
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\CustomerController;

// --- استدعاء الوسيط ---
use App\Http\Middleware\IsAdmin;

/*
|--------------------------------------------------------------------------
| A) Authentication Routes
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| B) Frontend (Public) Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'homepage'])->name('homepage');
Route::get('/shop', [PageController::class, 'shop'])->name('shop');
Route::get('/product/{product}', [PageController::class, 'productDetail'])->name('product.detail');
Route::get('/home', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| C) Shopping Cart & User-Specific Routes
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'destroy'])->name('cart.destroy');

// --- الروابط التي تتطلب تسجيل الدخول (Checkout & Profile) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/details', [ProfileController::class, 'updateDetails'])->name('profile.update.details');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
});

/*
|--------------------------------------------------------------------------
| D) Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::get('orders/trash', [AdminOrderController::class, 'trash'])->name('orders.trash');
    Route::post('orders/trash/{id}/restore', [AdminOrderController::class, 'restore'])->name('orders.restore');
    Route::delete('orders/trash/{id}/force-delete', [AdminOrderController::class, 'forceDelete'])->name('orders.forceDelete');
    Route::resource('orders', AdminOrderController::class);
    Route::post('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/{order}/invoice', [AdminOrderController::class, 'invoice'])->name('orders.invoice');
    Route::resource('users', UserController::class)->except(['show']);
    Route::post('/users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
    Route::post('/users/{user}/unban', [UserController::class, 'unban'])->name('users.unban');
    Route::get('/users/{user}/orders', [UserController::class, 'showUserOrders'])->name('users.orders');
    Route::resource('roles', RoleController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::resource('customers', CustomerController::class);
});