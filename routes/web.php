<?php
use Illuminate\Support\Facades\Route;

// Import các Controller
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;

// Route cho trang chủ
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Đăng ký và đăng nhập người dùng
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Route dành cho Admin (sử dụng middleware để kiểm tra quyền admin)
Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard của Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Quản lý sản phẩm
    Route::resource('/admin/products', ProductController::class, [
        'as' => 'admin' // Đặt tiền tố 'admin' cho tất cả các route liên quan đến sản phẩm
    ]);

    // Quản lý danh mục
    Route::resource('/admin/categories', CategoryController::class, [
        'as' => 'admin' // Đặt tiền tố 'admin' cho tất cả các route liên quan đến danh mục
    ]);
});

// Route dành cho người dùng bình thường (đã đăng nhập)
Route::middleware(['auth'])->group(function () {
    // Hiển thị danh sách sản phẩm và chi tiết sản phẩm
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show_normal'])->name('products.show');

    // Route cho giỏ hàng
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

    // Route cho thanh toán
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'index'])->name('checkout.process');
    Route::post('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});
