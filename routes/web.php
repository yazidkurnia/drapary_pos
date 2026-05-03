<?php

use App\Modules\Auth\Presentation\Controllers\AuthController;
use App\Modules\Auth\Presentation\Controllers\RoleManagementController;
use App\Modules\Auth\Presentation\Controllers\UserManagementController;
use App\Http\Controllers\ManageColor\ManageColorsController;
use App\Http\Controllers\ManageUnit\ManageUnitsController;
use App\Http\Controllers\ManageSize\ManageSizesController;
use App\Http\Controllers\ManageBrand\ManageBrandsController;
use App\Http\Controllers\ManageMaterial\ManageMaterialsController;
use App\Http\Controllers\ManageFit\ManageFitsController;
use App\Http\Controllers\ManageSleeve\ManageSleevesController;
use App\Http\Controllers\ManageCollar\ManageCollarsController;
use App\Http\Controllers\ManagePattern\ManagePatternsController;
use App\Http\Controllers\ManageGender\ManageGendersController;
use App\Http\Controllers\ManageProduct\ManageProductsController;
use App\Http\Controllers\ManageProductVariant\ManageProductVariantsController;
use Illuminate\Support\Facades\Route;

// Guest routes (hanya bisa diakses jika belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/test', function(){
    return view('index');
});

// Protected routes (harus login)
Route::middleware('auth')->group(function () {
    Route::get('/', fn() => redirect('/dashboard'));

    Route::get('/dashboard', function () {
        return view('pages.overview.index');
    })->name('dashboard');

    Route::post('/pos/checkout', [\App\Http\Controllers\Pos\OrderController::class, 'store'])->name('pos.checkout');
    Route::get('/pos/orders/{order}', [\App\Http\Controllers\Pos\OrderController::class, 'show'])->name('pos.orders.show');
    // Point of Sale
    Route::get('/pos', function () {
        $products = \App\Models\Product::with([
            'brand',
            'variants' => fn($q) => $q->with(['images', 'color', 'sizeStocks.size']),
        ])->get();

        $brands = \App\Models\Brand::orderBy('brand_name')->get();

        return view('pages.pos.index', compact('products', 'brands'));
    })->name('pos');

    // Transactions
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Pos\TransactionController::class, 'index'])->name('index');
        Route::get('/data', [\App\Http\Controllers\Pos\TransactionController::class, 'data'])->name('data');
        Route::get('/summary', [\App\Http\Controllers\Pos\TransactionController::class, 'summary'])->name('summary');
        Route::get('/{order}', [\App\Http\Controllers\Pos\TransactionController::class, 'show'])->name('show');
    });

    // User Management - hanya Owner & Admin Ecommerce
    Route::middleware('role:Owner|Admin Ecommerce')->group(function () {
        Route::resource('/users', UserManagementController::class);       
        Route::resource('/colors', ManageColorsController::class)->except(['show']);
        Route::resource('/units', ManageUnitsController::class)->except(['show', 'create']);
        Route::resource('/sizes', ManageSizesController::class)->except(['show', 'create']);
        Route::resource('/brands', ManageBrandsController::class)->except(['show', 'create']);
        Route::resource('/materials', ManageMaterialsController::class)->except(['show', 'create']);
        Route::resource('/fits', ManageFitsController::class)->except(['show', 'create']);
        Route::resource('/sleeves', ManageSleevesController::class)->except(['show', 'create']);
        Route::resource('/collars', ManageCollarsController::class)->except(['show', 'create']);
        Route::resource('/patterns', ManagePatternsController::class)->except(['show', 'create']);
        Route::resource('/genders', ManageGendersController::class)->except(['show', 'create']);
        Route::get('/products/by-brand/{brandId}', [ManageProductsController::class, 'byBrand'])->name('products.by-brand');
        Route::resource('/products', ManageProductsController::class)->except(['show', 'create']);
        Route::resource('/product-variants', ManageProductVariantsController::class)->except(['show', 'create']);
        Route::delete('/product-variant-images/{imageId}', [ManageProductVariantsController::class, 'destroyImage'])->name('product-variant-images.destroy');
    });

    // Role Management - hanya Owner
    Route::middleware('role:Owner')->group(function () {
        Route::resource('/roles', RoleManagementController::class)->except(['show']);
    });
});
