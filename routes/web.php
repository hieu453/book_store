<?php

use Inertia\Inertia;
use App\Models\Order;
use App\Mail\TestMail;
use App\Models\Review;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Notifications\OrderedNotification;

// dev routes
Route::get('/session-flush', function () {
    session()->flush();
    return redirect()->back();
});

Route::get('/test', function (Request $request) {
    $order = Order::where('id', 13)->first();

    return (new OrderedNotification($order))->toMail($order);
});
Route::get('/test2', function (Request $request) {
    session()->forget('paymentDetails');
});

// Home routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('home.search');

// Category routes
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{slug}/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/products/{keyword?}', [ProductController::class, 'liveSearch'])->name('product.search');

// Auth routes
Route::middleware('auth')->group(function () {
    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update.quantity');
    Route::post('/cart/set-checked-items-to-session', [CartController::class, 'setCheckedItemsToSession'])->name('cart.total');
    Route::put('/cart/check-item', [CartController::class, 'checkItem'])->name('cart.check.item');
    Route::delete('/cart/remove/{ids}', [CartController::class, 'removeItems'])->name('cart.remove.items');


    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');


    // Payment routes
    Route::post('/payment/online', [PaymentController::class, 'process'])->name('payment.online');
    Route::post('/payment/cod', [PaymentController::class, 'processCod'])->name('payment.cod');
    Route::get('/payment/cod/success', [PaymentController::class, 'showSuccessCodPage'])->name('payment.cod.success');
    Route::get('/payment/redirect-success', [PaymentController::class, 'redirectCheckPayment'])->name('payment.redirect');
    Route::get('/payment/check', [PaymentController::class, 'showCheckPage'])->name('payment.check');


    // Wishlist routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');


    // Review routes
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/reviews/{reviewId}/like', [ReviewController::class, 'toggleLike'])->name('reviews.toggleLike');


    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::post('/orders/{orderId}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});


// Admin routes
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');


    // Category routes
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/categories/{categoryId}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/categories/{categoryId}/update', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{categoryId}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');


    // Product routes
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{productId}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{productId}/update', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{productId}/destroy', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');


    // Order routes
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::get('/orders/{orderId}/edit', [AdminOrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('/orders/{orderId}/update', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    // Cancelled orders
    Route::get('/cancelled-orders', [AdminOrderController::class, 'showCancelledOrder'])->name('admin.orders.cancelled');
    Route::post('/cancelled-orders', [AdminOrderController::class, 'cancelOrders'])->name('admin.orders.cancel');
});


// Dashboard and Profile
// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
