<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});


Auth::routes();
Route::group([
    'middleware' => 'auth'
], function () {
    Route::resource('invoices', InvoicesController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('products', ProductController::class);
    Route::get('section/{id}', [SectionController::class, 'getproducts']);
    Route::prefix('admin')->controller(AdminController::class)->group(function () {
        route::get('profile/{id}', 'show')->name('admin.show');
        route::get('edit/{id}', 'edit')->name('admin.edit');
        route::put('edit/{id}',  'update')->name('admin.update');
    });
    Route::prefix('message')->controller(AdminController::class)->group(function () {
        route::post('message/{id}', 'send_message')->name('admin.send_message');
        route::get('message/all', 'allmessage')->name('admin.allmessage');
        route::delete('message/{id}', 'delete_message')->name('admin.delete_message');
    });

    Route::prefix('notify')->controller(AdminController::class)->group(function () {
        route::get('/',  'notify')->name('admin.notify');
        route::get('/{id}',  'show_notify')->name('admin.show_notify');
        route::delete('/{id}',  'delete_notify')->name('delete_notify');
    });
});


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/{page}', [AdminController::class, 'index']);
