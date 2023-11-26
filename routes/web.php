<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/', function () {
    return view('frontend.pages.home');
});

/* Admin Auth routes */
Route::prefix('admin/')->group(function(){
    Route::get('login', [LoginController::class, 'loginPage'])->name('admin.loginpage');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');
    Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');

    // Route::middleware(['auth'])->group(function(){
    //     Route::get('dashboard',function(){
    //         return view('backend.pages.Dashboard');
    //     })->name('admin.dashboard');
    // });
    Route::middleware(['auth'])->group(function(){
        Route::get('dashboard',[DashboardController::class, 'dashboard'])->name('admin.dashboard');
    });

    /* Resource Controller */
    Route::resource('category', CategoryController::class);

});
/* Admin Auth routes */

