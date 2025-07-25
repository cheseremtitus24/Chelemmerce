<?php
use Illuminate\Http\Request;
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

//Route::get('/', function () {
//    $user = Posts::all()->sortByDesc('created_at');
////    $user = Posts::orderBy('created_at', 'desc')->paginate(5);
////        return $this->hasMany(Posts::class)->orderBy('created_at','DESC');
//    return view('welcome',compact('user'));
////    return view('welcome');
//});

Route::get('/', function (Request $request) {
    $query = Posts::query();

    // Apply filters
    if ($request->filled('location')) {
        $query->where('location', 'like', '%' . $request->location . '%');
    }

    if ($request->filled('home_type')) {
        $query->where('home_type', $request->home_type);
    }

    if ($request->filled('price_type')) {
        $query->where('price_type', $request->price_type);
    }

    $page = $request->input('page', 1);

    // Paginate results
    $user = $query->orderBy('created_at', 'desc')
        ->simplePaginate(8)
        ->appends($request->query());

    // Return 204 No Content if no data on pages > 1
    if ($user->isEmpty() && $page > 1) {
        return response()->noContent();
    }

    return view('welcome', compact('user'));
});


Auth::routes();

Route::get('/p/create/p', [App\Http\Controllers\PostsController::class, 'create'])->middleware('auth');
Route::get('/p/create/i', [App\Http\Controllers\PostsController::class, 'document'])->middleware('auth');
Route::get('/p/create/f', [App\Http\Controllers\PostsController::class, 'preview'])->middleware('auth');
Route::get('/p/edit', [App\Http\Controllers\PostsController::class, 'edit'])->middleware('auth');
Route::get('/p/edit/{post}', [App\Http\Controllers\PostsController::class, 'posts_update'])->middleware('auth');
Route::get('/save/create', [App\Http\Controllers\DocumentController::class, 'create']);
Route::get('/p/{post}', [App\Http\Controllers\PostsController::class, 'show']);
Route::get('/d/{post}', [App\Http\Controllers\PostsController::class, 'destroy'])->middleware('auth');;
Route::post('/p', [App\Http\Controllers\PostsController::class, 'store'])->middleware('auth');
Route::post('/review-store',[App\Http\Controllers\PostsRatings::class, 'reviewstore'])->name('review.store')->middleware('auth');
Route::post('/save', [App\Http\Controllers\DocumentController::class, 'saveDocument']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'index'])->name('profile.show');
Route::patch('/profile/i/{user}', [App\Http\Controllers\ProfilesController::class, 'update_image'])->name('profile.update_image');
Route::patch('/profile/d/{user}', [App\Http\Controllers\ProfilesController::class, 'update_description'])->name('profile.update_description');
Route::get('/profile/{user}/edit', [App\Http\Controllers\ProfilesController::class, 'edit'])->name('profile.edit');
Route::get('/profile/{user}/update_brand', [App\Http\Controllers\ProfilesController::class, 'update_brand'])->name('profile.update_brand');
