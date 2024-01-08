<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SupplierController;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Suppliers\Index;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::prefix('suppliers')->name('suppliers.')->group(function () {
    Route::get('/search/{category_id?}', Index::class)->name('index');
    Route::get('/{supplier_id}', [SupplierController::class, 'show'])->name('show');
});
Route::controller(BlogController::class)->prefix('blogs')->name('blogs.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{blog_id}', 'show')->name('show');
});
