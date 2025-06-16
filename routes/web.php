<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\PrimeRequestController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('homepage');
Route::get('/collections', [DashboardController::class, 'product_list_page'])->name('collections');
Route::get('/collections/{category:slug}', [DashboardController::class, 'show_categorywise'])->name('category.show');
Route::get('/collections/{category:slug}/{subcategory:slug}', [DashboardController::class, 'show_subcategorywise'])->name('subcategory.show');

Route::get('/collections/{category:slug}/{subcategory:slug}/{childsubcategory:slug}', [DashboardController::class, 'show_child_subcategorywise'])->name('childsubcategory.show');

Route::get('/product/{product:slug}', [DashboardController::class, 'show_product'])->name('show_product');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/user/otpPage', [RegisteredUserController::class, 'otpPage'])->name('user.otpPage');
Route::post('/user/newUserVerify', [RegisteredUserController::class, 'newUserVerify'])->name('newUserVerify');

Route::post('/user/otp', [RegisteredUserController::class, 'initiateRegistration'])->name('user.otp');
Route::get('/user/otp/{temp_id}', [RegisteredUserController::class, 'otp'])->name('otp');
Route::post('/user/verify', [RegisteredUserController::class, 'store'])->name('verify');

Route::post('/login/otp', [AuthenticatedSessionController::class, 'initiateLogin'])->name('login.otp');
Route::get('/login/otp/{temp_id}', [AuthenticatedSessionController::class, 'login_otp'])->name('login_otp');
Route::post('/login/verify', [AuthenticatedSessionController::class, 'verifyLoginOTP'])->name('login_verify');



Route::group(['middleware' => ['auth']], function () {
    Route::get('/user/list', [UserController::class, 'index'])->name('user.list');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::patch('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // Role

    Route::get('/role/list', [RoleController::class, 'index'])->name('role.list');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::get('/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::patch('/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/delete/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

    // KYC 

    Route::prefix('kyc')->group(function () {
        Route::get('/add', [KycController::class, 'index'])->name('kyc.list');
        Route::get('/prime', [KycController::class, 'prime'])->name('kyc.prime');
        Route::post('/prime_store', [KycController::class, 'prime_store'])->name('kyc.prime_store');
        Route::get('/create', [KycController::class, 'create'])->name('kyc.create');
        Route::post('/store', [KycController::class, 'store'])->name('kyc.store');
        Route::get('/edit/{id}', [KycController::class, 'edit'])->name('kyc.edit');
        Route::post('/update/{id}', [KycController::class, 'update'])->name('kyc.update');
        Route::delete('/delete/{id}', [KycController::class, 'destroy'])->name('kyc.delete');

        Route::post('assign_postal_area',[KycController::class,'assign_postal_area'])->name('assign_postal_area');
        Route::post('nominee',[KycController::class,'nominee'])->name('nominee');
        Route::post('choose_package',[KycController::class,'choose_package'])->name('choose_package');
        Route::post('finish_payment',[KycController::class,'finish_payment'])->name('finish_payment');

    });

    Route::get('/prime_requests', [PrimeRequestController::class, 'prime_requests'])->name('prime_requests');
    Route::post('/prime-request', [PrimeRequestController::class, 'store'])->name('prime.request');
    Route::post('/prime-request-cancel', [PrimeRequestController::class, 'cancel_request'])->name('prime.cancel_request');
    Route::post('/prime-request/{id}/respond', [PrimeRequestController::class, 'respond'])->name('prime.respond');
});

// AJAX calls
Route::get('load_affiliate_id', [CommonController::class,'load_affiliate_id'])->name('load_affiliate_id');
Route::get('load_districts', [CommonController::class,'load_districts'])->name('load_districts');
Route::get('load_police_stations',[CommonController::class,'load_police_stations'])->name('load_police_stations');
Route::get('load_post_offices',[CommonController::class,'load_post_offices'])->name('load_post_offices');


require __DIR__.'/admin-auth.php';
require __DIR__.'/admin-routes.php';