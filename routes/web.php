<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('about', function () {
   return view('about');
})->name('about');

Route::get('contact', [ContactController::class, 'index'])->name('contact');

// Category controller
Route::prefix('category')->group(function () {
    Route::get('all', [CategoryController::class, 'allCategory'])->name('all.category');
    Route::post('add', [CategoryController::class, 'addCategory'])->name('store.category');
    Route::get('edit/{id}', [CategoryController::class, 'editCategory'])->name('edit.category');
    Route::post('update/{id}', [CategoryController::class, 'updateCategory'])->name('update.category');
    Route::get('delete/{id}', [CategoryController::class, 'deleteCategory'])->name('delete.category');
    Route::get('restore/{id}', [CategoryController::class, 'restoreCategory'])->name('restore.category');
    Route::get('pdelete/{id}', [CategoryController::class, 'permanentDeleteCategory'])->name('permanentDelete.category');
});


Route::prefix('brand')->group(function () {
    Route::get('all', [BrandController::class, 'allBrand'])->name('all.brand');
    Route::post('add', [BrandController::class, 'addBrand'])->name('store.brand');
    Route::get('edit/{id}', [BrandController::class, 'editBrand'])->name('edit.brand');
    Route::post('update/{id}', [BrandController::class, 'updateBrand'])->name('update.brand');
    Route::get('delete/{id}', [BrandController::class, 'deleteBrand'])->name('delete.brand');
    Route::get('multi/image', [BrandController::class, 'multiPicture'])->name('multi.image');
    Route::post('multi/add', [BrandController::class, 'storeImages'])->name('store.image');
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    //$users = User::all();
    //$users = DB::table('users')->get();
    return view('admin.index');
})->name('dashboard');

Route::get('user/logout', [BrandController::class, 'logout'])->name('user.logout');
