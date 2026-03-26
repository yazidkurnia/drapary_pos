<?php

use App\Modules\Auth\Presentation\Controllers\AuthController;
use App\Modules\Auth\Presentation\Controllers\RoleManagementController;
use App\Modules\Auth\Presentation\Controllers\UserManagementController;
use App\Http\Controllers\ManageColor\ManageColorsController;
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

    // Point of Sale
    Route::get('/pos', function () {
        $products = [
            [
                'name'        => 'Kain Sutra',
                'description' => 'Kain sutra asli kualitas premium.',
                'image'       => 'https://placehold.co/600x400/f06292/white?text=Kain',
            ],
            [
                'name'        => 'Benang Wol',
                'description' => 'Benang wol tebal untuk rajutan.',
                'image'       => 'https://placehold.co/600x400/4fc3f7/white?text=Benang',
            ],
            [
                'name'        => 'Kancing Kayu',
                'description' => 'Kancing estetik bahan kayu.',
                'image'       => 'https://placehold.co/600x400/a1887f/white?text=Kancing',
            ],
        ];
        return view('pages.pos.index', compact('products'));
    })->name('pos');

    // User Management - hanya Owner & Admin Ecommerce
    Route::middleware('role:Owner|Admin Ecommerce')->group(function () {
        Route::resource('/users', UserManagementController::class);
        Route::resource('/colors', ManageColorsController::class)->except(['show']);
    });

    // Role Management - hanya Owner
    Route::middleware('role:Owner')->group(function () {
        Route::resource('/roles', RoleManagementController::class)->except(['show']);
    });
});
