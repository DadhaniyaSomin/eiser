<?php
use Auth\VerificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::group(['prefix' => 'admin',  'middleware' => 'is_admin', 'auth' ], function()
{
    //All the routes that belongs to the group goes here
    Route::get('home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home');
    Route::resource('products', App\Http\Controllers\ProductController::class);
    Route::resource('categories', App\Http\Controllers\CategoryController::class)->middleware('auth');
    Route::post('import', [App\Http\Controllers\ProductController::class, 'import'])->name('import');
    Route::get('export', [App\Http\Controllers\ProductController::class, 'export'])->name('export');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');