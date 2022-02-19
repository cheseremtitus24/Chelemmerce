<?php

use App\Models\Posts;
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
    $user = Posts::all()->sortByDesc('created_at');;
//        return $this->hasMany(Posts::class)->orderBy('created_at','DESC');
    return view('welcome',compact('user'));
//    return view('welcome');
});

Auth::routes();

Route::get('/p/create/p', [App\Http\Controllers\PostsController::class, 'create'])->middleware('auth');
Route::get('/p/create/i', [App\Http\Controllers\PostsController::class, 'document'])->middleware('auth');
Route::get('/p/create/f', [App\Http\Controllers\PostsController::class, 'preview'])->middleware('auth');
Route::get('/save/create', [App\Http\Controllers\DocumentController::class, 'create']);
Route::get('/p/{post}', [App\Http\Controllers\PostsController::class, 'show']);
Route::post('/p', [App\Http\Controllers\PostsController::class, 'store'])->middleware('auth');
Route::post('/save', [App\Http\Controllers\DocumentController::class, 'saveDocument']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'index'])->name('profile.show');
Route::patch('/profile/i/{user}', [App\Http\Controllers\ProfilesController::class, 'update_image'])->name('profile.update_image');
Route::patch('/profile/d/{user}', [App\Http\Controllers\ProfilesController::class, 'update_description'])->name('profile.update_description');
Route::get('/profile/{user}/edit', [App\Http\Controllers\ProfilesController::class, 'edit'])->name('profile.edit');
Route::get('/profile/{user}/update_brand', [App\Http\Controllers\ProfilesController::class, 'update_brand'])->name('profile.update_brand');
