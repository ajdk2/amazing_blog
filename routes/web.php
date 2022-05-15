<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('post', [PostController::class, 'index'])->name('post');
Route::get('post/{post:slug}', [PostController::class, 'show'])->name('post.show');
Route::get('about', [AboutController::class, 'index'])->name('about');
Route::get('contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact', [ContactController::class, 'store']);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/', [LoginController::class, 'index']);
        Route::get('login', [LoginController::class, 'index'])->name('login');
        Route::post('login', [LoginController::class, 'authenticate']);
    });

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('my_profile', [MyProfileController::class, 'edit'])->name('my-profile');
    Route::put('my_profile', [MyProfileController::class, 'update'])->name('my-profile.update');

    Route::prefix('post')->name('post.')->middleware('auth')->group(function () {
        Route::get('/', [AdminPostController::class, 'index'])->name('index');
        Route::post('/', [AdminPostController::class, 'store']);
        Route::get('create', [AdminPostController::class, 'create'])->name('create');
        Route::get('{id}/edit', [AdminPostController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [AdminPostController::class, 'update'])->name('update');
        Route::get('{id}/delete', [AdminPostController::class, 'destroy'])->name('delete');
    });

    Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::post('/', [AdminUserController::class, 'store'])->name('store');
        Route::get('create', [AdminUserController::class, 'create'])->name('create');
        Route::get('{id}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [AdminUserController::class, 'update'])->name('update');
        Route::delete('{id}/delete', [AdminUserController::class, 'destroy'])->name('delete');
    });
});

Route::get('test', function () {
    $json = Storage::get('large-file.json');
    $json = collect(json_decode($json, true));

    $test = $json->where('type', 'CreateEvent')->pluck('actor.login')->slice(0, 20);

    dd($test->all());
});
