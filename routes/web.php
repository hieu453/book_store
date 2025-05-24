<?php

use App\Models\User;
use App\Models\Order;
use App\Mail\NewOrder;
use App\Mail\OrderSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Notifications\NewOrderNotification;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Mail\UpdateOrderStatus;
use App\Models\CancelledOrder;
use App\Notifications\CancelOrderNotification;

// dev routes
Route::get('/session-flush', function () {
    session()->flush();
    return redirect()->back();
});

Route::get('/notification', function () {
    $cancelledOrder = CancelledOrder::find(14);
    return (new CancelOrderNotification($cancelledOrder))
            ->toMail($cancelledOrder->user);
});

Route::get('/test2', function (Request $request) {

    return;
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

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'userNotifications'])->name('notifications');
    Route::post('/notifications/read/{notificationId}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
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
    Route::post('/categories/check-all', [AdminCategoryController::class, 'selectAll'])->name('admin.categories.check.all');


    // Product routes
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{productId}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{productId}/update', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{productId}/destroy', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

    // User routes
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::get('/users/{userId}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{userId}/update', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{userId}/delete', [AdminUserController::class, 'delete'])->name('admin.users.delete');


    // Order routes
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::get('/orders/{orderId}/edit', [AdminOrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('/orders/{orderId}/update', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('/orders/{orderId}/delete}', [AdminOrderController::class, 'delete'])->name('admin.orders.delete');
    // Cancelled orders
    Route::get('/cancelled-orders', [AdminOrderController::class, 'showCancelledOrder'])->name('admin.orders.cancelled');
    Route::post('/cancelled-orders', [AdminOrderController::class, 'cancelOrders'])->name('admin.orders.cancel');
    Route::post('/cancelled-orders/check-all', [AdminOrderController::class, 'checkAll'])->name('admin.orders.cancelled.check.all');

    // Admin notifications
    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('admin.notifications');
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
