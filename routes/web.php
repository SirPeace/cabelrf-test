<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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

Route::middleware('auth')->group(function () {
    Route::permanentRedirect('/', '/products');

    Route::delete('users/destroy-multiple', [UserController::class, 'destroyMultiple'])
        ->name('users.destroy-multiple');

    Route::delete('products/destroy-multiple', [ProductController::class, 'destroyMultiple'])
        ->name('products.destroy-multiple');

    Route::resource('users', UserController::class)->except(['store', 'create']);

    Route::resource('products', ProductController::class)
        ->scoped(['product' => 'slug']);
});

require __DIR__ . '/auth.php';
