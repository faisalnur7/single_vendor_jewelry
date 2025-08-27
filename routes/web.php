<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Route;


Route::get('/reboot', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('clear-compiled');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
    return 'rebooted & caches cleared!';
});
Route::get('/', [DashboardController::class, 'index'])->name('homepage');
Route::get('/collections', [DashboardController::class, 'product_list_page'])->name('collections');
Route::get('/best_sellers', [DashboardController::class, 'best_sellers'])->name('best_sellers');
Route::get('/collections/{category:slug}', [DashboardController::class, 'show_categorywise'])->name('category.show');
Route::get('/collections/{category:slug}/{subcategory:slug}', [DashboardController::class, 'show_subcategorywise'])->name('subcategory.show');

Route::get('/collections/{category:slug}/{subcategory:slug}/{childsubcategory:slug}', [DashboardController::class, 'show_child_subcategorywise'])->name('childsubcategory.show');

Route::get('/product/{product:slug}', [DashboardController::class, 'show_product'])->name('show_product');

Route::get('/signin', [SignInController::class, 'signin'])->name('signin');
Route::get('/signup', [SignInController::class, 'signup'])->name('signup');
Route::get('/forgot_password', [SignInController::class, 'forgot_password'])->name('forgot_password');

Route::post('/send_reset_password_link', [SignInController::class, 'send_reset_password_link'])->name('send_reset_password_link');
Route::get('user-reset-password/{token}', [SignInController::class, 'showResetForm'])->name('user.password.reset');
Route::post('user-reset-password', [SignInController::class, 'updatePassword'])->name('user.password.update');


Route::get('login/{provider}', [SignInController::class, 'redirect'])->name('social.redirect');
Route::get('login/{provider}/callback', [SignInController::class, 'callback'])->name('social.callback');

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


// Cart Operations routes
Route::post('/add_to_cart', [CartController::class, 'add_to_cart'])->name('add_to_cart');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::delete('/cart/remove/{product_id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update_item_qty'])->name('cart.update');

// Contact Us Messages Routes
Route::get('/contact_us', [ContactUsController::class, 'contact_us'])->name('contact_us');
Route::post('/contact_us_messages', [ContactUsController::class, 'contact_us_messages'])->name('contact_us_messages');

Route::get('/guest_wishlist', [WishlistController::class, 'guest_wishlist'])->name('guest_wishlist');
Route::post('/guest/wishlist-products', [WishlistController::class, 'guestProducts'])->name('guest_wishlist_products');
Route::post('/wishlist', [WishlistController::class, 'store'])->name('user_wishlist_store');

Route::get('/faq', [FaqController::class, 'faq'])->name('faq');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/user_dashboard', [UserController::class, 'user_dashboard'])->name('user_dashboard');
    Route::get('/user_profile', [UserController::class, 'user_profile'])->name('user_profile');
    Route::get('/user_view_profile', [UserController::class, 'user_view_profile'])->name('user_view_profile');
    Route::get('/user_edit_profile', [UserController::class, 'user_edit_profile'])->name('user_edit_profile');
    Route::post('/user_profile_update', [UserController::class, 'user_profile_update'])->name('user_profile_update');
    Route::get('/user_order', [UserController::class, 'user_order'])->name('user_order');
    Route::get('/user_order/show/{id}', [UserController::class, 'user_order_show'])->name('user_order_show');
    Route::get('/user_wishlist', [UserController::class, 'user_wishlist'])->name('user_wishlist');
    Route::get('/user_address', [UserController::class, 'user_address'])->name('user_address');
    Route::get('/user/list', [UserController::class, 'index'])->name('user.list');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::patch('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('user_password_form');
    Route::put('/change-password', [UserController::class, 'updatePassword'])->name('user_password_update');

    // Wishlist 
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('user_wishlist');
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy'])->name('user_wishlist_delete');

    // Shipping Address CRUD Routes
    Route::get('/user/shipping', [ShippingAddressController::class, 'index'])->name('user_shipping_index');
    Route::get('/user/shipping/create', [ShippingAddressController::class, 'create'])->name('user_shipping_create');
    Route::post('/user/shipping/store', [ShippingAddressController::class, 'store'])->name('user_shipping_store');
    Route::get('/user/shipping/edit/{id}', [ShippingAddressController::class, 'edit'])->name('user_shipping_edit');
    Route::put('/user/shipping/update/{id}', [ShippingAddressController::class, 'update'])->name('user_shipping_update');
    Route::delete('/user/shipping/delete/{id}', [ShippingAddressController::class, 'destroy'])->name('user_shipping_delete');

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

    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/payment/process', [CheckoutController::class, 'processPayment'])->name('payment.process');
    Route::get('/payment/success', [CheckoutController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed', [CheckoutController::class, 'failed'])->name('payment.failed');
});

// AJAX calls
Route::get('load_affiliate_id', [CommonController::class,'load_affiliate_id'])->name('load_affiliate_id');
Route::get('load_districts', [CommonController::class,'load_districts'])->name('load_districts');
Route::get('load_police_stations',[CommonController::class,'load_police_stations'])->name('load_police_stations');
Route::get('load_post_offices',[CommonController::class,'load_post_offices'])->name('load_post_offices');

Route::get('/get-states/{country_id}', [CommonController::class, 'getStates'])->name('getStates');
Route::get('/get-cities/{state_id}', [CommonController::class, 'getCities'])->name('getCities');

require __DIR__.'/admin-auth.php';
require __DIR__.'/admin-routes.php';