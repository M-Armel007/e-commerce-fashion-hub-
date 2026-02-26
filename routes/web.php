<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes produits
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/{id}', [ProductController::class, 'show'])->name('show');
    Route::post('/add-quick', [ProductController::class, 'addQuick'])->name('add-quick');
    Route::get('/{id}/quick-view', [ProductController::class, 'quickView'])->name('quick-view');
});

// Routes panier
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/add-quick', [CartController::class, 'addQuick'])->name('add-quick');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

// Routes commandes (protégées par authentification)
Route::middleware(['auth'])->prefix('orders')->name('orders.')->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/store', [OrderController::class, 'store'])->name('store');
    Route::get('/confirmation/{id}', [OrderController::class, 'confirmation'])->name('confirmation');
    Route::get('/facture/{id}', [OrderController::class, 'facture'])->name('facture');
});

// Routes profil (protégées par authentification)
Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::put('/', [ProfileController::class, 'update'])->name('update');
    Route::get('/orders', [ProfileController::class, 'orders'])->name('orders');
});

// Route de redirection après connexion
Route::get('/redirect', [RedirectAuthenticatedUsersController::class, 'redirect'])->name('redirect');

// Routes admin (protégées par auth et middleware admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard - UNE SEULE ROUTE
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestion produits
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    // Gestion commandes
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('orders');
    Route::get('/orders/{id}', [OrderController::class, 'adminShow'])->name('orders.show');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    
    // Gestion ventes sur place
    Route::get('/sales', [AdminController::class, 'sales'])->name('sales');
    Route::get('/sales/create', [AdminController::class, 'createSale'])->name('sales.create');
    Route::post('/sales', [AdminController::class, 'storeSale'])->name('sales.store');
});

// Routes d'authentification (Breeze)
require __DIR__.'/auth.php';