<?php

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

Route::get('about', function () {
   return view('about');
})->name('about');

Route::get('contact', [ContactController::class, 'index'])->name('contact');

// Category controller
Route::get('/category/all', [CategoryController::class, 'allCategory'])->name('all.category');
Route::post('category/add', [CategoryController::class, 'addCategory'])->name('store.category');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    //$users = User::all();
    $users = DB::table('users')->get();
    return view('dashboard', compact('users'));
})->name('dashboard');
