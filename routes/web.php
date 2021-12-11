<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, CartController, CategoryController, DashboardController, DashboardProductController, DashboardSettingController, DashboardTransactionController, DetailController};
use App\Http\Controllers\Admin\{CategoryController as AdminCategoryController, UserController};
use App\Http\Controllers\Auth\RegisterController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('categories', [CategoryController::class, 'index'])->name('categories');
Route::get('details/{id}', [DetailController::class, 'index'])->name('detail');
Route::get('carts', [CartController::class, 'index'])->name('cart');
Route::get('success', [CartController::class, 'success'])->name('success');

Route::get('register/success', [RegisterController::class, 'success'])->name('register-success');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('dashboard/products', [DashboardProductController::class, 'index'])->name('dashboard-product');
Route::get('dashboard/products/create', [DashboardProductController::class, 'create'])->name('dashboard-product-create');
Route::get('dashboard/products/{id}', [DashboardProductController::class, 'details'])->name('dashboard-product-details');

Route::get('dashboard/transactions', [DashboardTransactionController::class, 'index'])->name('dashboard-transactions');
Route::get('dashboard/transactions/{id}', [DashboardTransactionController::class, 'details'])->name('dashboard-transactions-details');

Route::get('dashboard/settings', [DashboardSettingController::class, 'store'])->name('dashboard-settings-store');
Route::get('dashboard/account', [DashboardSettingController::class, 'account'])->name('dashboard-settings-account');

Route::prefix('admin')->group( function(){
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resources([
        'categories' => AdminCategoryController::class,
        'users' => UserController::class,
    ]);
});


Auth::routes();
