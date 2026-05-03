<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

// ── Home ────────────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('home', [
        'categories'       => Category::withCount(['products' => fn ($q) => $q->where('is_active', true)])
                                  ->whereHas('products', fn ($q) => $q->where('is_active', true))
                                  ->take(8)
                                  ->get(),
        'featuredProducts' => Product::active()->with('category')->latest()->take(8)->get(),
    ]);
})->name('home');

// ── Shop ─────────────────────────────────────────────────────────────────────
Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');

// Route model binding by slug — no model change required (inline binding, Laravel 10+)
Route::get('/shop/{product:slug}', [ProductController::class, 'show'])->name('shop.show');

// ── Cart (accessible to guests AND authenticated users) ───────────────────────
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

// ── Authenticated customer area ───────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {

    // Account dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (unchanged from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/confirmation', [OrderController::class, 'confirmation'])
         ->name('orders.confirmation');
});

// ── Admin area ────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // Products CRUD
        Route::resource('products', AdminProductController::class);

        // Categories CRUD (no dedicated show page — view is inline on index)
        Route::resource('categories', CategoryController::class)->except(['show']);

        // Orders — read + status update only (no create/delete)
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
             ->name('orders.updateStatus');
    });

require __DIR__ . '/auth.php';
