<?php

use App\Models\Cart;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Helpers\Payment\Momo;
use App\Helpers\Payment\Environment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;

// dev routes
Route::get('/session-flush', function () {
    session()->flush();
    return redirect()->back();
});

Route::get('/test', function (Request $request) {
    dd(session('checkedItems'));

    $itemIds = [];
    foreach (session('checkedItems') as $item) {
        $itemIds[] = $item['id'];
    }

    Cart::destroy($itemIds);
    return to_route('home');
});

// Home routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Category routes
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/product/{slug}/{id}', [ProductController::class, 'show'])->name('product.show');

// Cart routes
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
    Route::post('/payment', [PaymentController::class, 'process'])->name('payment');
    Route::get('/payment/redirect-success', [PaymentController::class, 'redirectCheckPayment'])->name('payment.redirect');
    Route::get('/payment/check', [PaymentController::class, 'showCheckPage'])->name('payment.check');
});

// Dashboard and Profile
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
