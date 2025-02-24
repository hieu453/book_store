<?php

use App\Models\Cart;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

// Route::get('/', function () {
//     return Inertia::render('Home/HomePage', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// dev routes
Route::get('/session-flush', function () {
    session()->flush();
    return redirect()->back();
});

Route::get('/checkout', function (Request $request) {
    $stripePriceId = 'price_1Qk4JHCAJbhs7QYLNSc2OPJM';
    $stripePriceId2 = 'price_1QkHH2CAJbhs7QYL4qjhmSDI';

    $quantity = 1;

    return $request->user()->checkout([
        $stripePriceId => $quantity,
        $stripePriceId2 => $quantity,
    ], [
        'success_url' => route('checkout-success'),
        'cancel_url' => route('checkout-cancel'),
    ]);
})->name('checkout');

Route::get('/payment', function (Request $request) {

    return Inertia::render('Payment', [
        'cart' => session('checkedItems')
    ]);
})->name('payment');

Route::post('/purchase', function (Request $request) {
    // $stripeCharge = $request->user()->charge(
    //     $request->totalPrice * 100, $request->paymentMethodId, [
    //         'return_url' => route('checkout-success'),
    //     ]
    // );

    // dd(session('checkedItems'));
    // session()->forget('checkedItems');
    $itemIds = [];
    foreach (session('checkedItems') as $item) {
        $itemIds[] = $item['id'];
    }

    dd($itemIds);

});

Route::inertia('/checkout/success', 'Success')->name('checkout-success');
Route::inertia('/checkout/cancel', 'Cancel')->name('checkout-cancel');

// Home routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Category routes
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/product/{slug}/{id}', [ProductController::class, 'show'])->name('product.show');

// Cart routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/increase', [CartController::class, 'increaseQuantity'])->name('cart.increase');
    Route::post('/cart/decrease', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');
    Route::get('/cart/cart-number', [CartController::class, 'getCartNumber'])->name('cart.number');
    Route::post('/cart/set-total-price-to-session', [CartController::class, 'setTotalPriceToSession'])->name('cart.total');
    Route::get('/cart/checkout', [CartController::class, 'showCheckout'])->name('cart.checkout');
    Route::post('/cart/delete', [CartController::class, 'deleteCartItems'])->name('cart.delete.items');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove.item');
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
