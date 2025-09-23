<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SubscriptionPackageController;
use App\Http\Controllers\PackageFeatureController;
use App\Http\Controllers\PaymentOptionController;
use App\Http\Controllers\SubscriptionRequestController;
use App\Http\Controllers\ChildSubCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShippingMethodController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\ContactSettingController;
use App\Http\Controllers\SocialMediaSettingController;
use App\Http\Controllers\HomePageSettingController;
use App\Http\Controllers\HomepageBannerController;
use App\Http\Controllers\HomePageTrendingController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ReturnPolicyController;
use App\Http\Controllers\ShippingPolicyController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\CacheSettingController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->middleware('auth:admin')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Subscription Package Routes

    Route::prefix('subscription-management')->group(function () {

        Route::prefix('subscription_request')->group(function () {
            Route::get('/pending_list', [SubscriptionRequestController::class, 'pending_list'])->name('pending_list');
            Route::post('/respond/{id}', [SubscriptionRequestController::class, 'respond'])->name('admin.respond');
        });


        Route::prefix('subscription_package')->group(function () {
            Route::get('/list', [SubscriptionPackageController::class, 'index'])->name('subscription_package.list');
            Route::get('/create', [SubscriptionPackageController::class, 'create'])->name('subscription_package.create');
            Route::post('/store', [SubscriptionPackageController::class, 'store'])->name('subscription_package.store');
            Route::get('/edit/{id}', [SubscriptionPackageController::class, 'edit'])->name('subscription_package.edit');
            Route::post('/update/{id}', [SubscriptionPackageController::class, 'update'])->name('subscription_package.update');
            Route::delete('/delete/{id}', [SubscriptionPackageController::class, 'destroy'])->name('subscription_package.delete');
        });

        Route::prefix('package_feature')->group(function () {
            Route::get('/list', [PackageFeatureController::class, 'index'])->name('package_feature.list');
            Route::get('/create', [PackageFeatureController::class, 'create'])->name('package_feature.create');
            Route::post('/store', [PackageFeatureController::class, 'store'])->name('package_feature.store');
            Route::get('/edit/{id}', [PackageFeatureController::class, 'edit'])->name('package_feature.edit');
            Route::post('/update/{id}', [PackageFeatureController::class, 'update'])->name('package_feature.update');
            Route::delete('/delete/{id}', [PackageFeatureController::class, 'destroy'])->name('package_feature.delete');
        });

        Route::prefix('payment_option')->group(function () {
            Route::get('/list', [PaymentOptionController::class, 'index'])->name('payment_option.list');
            Route::get('/create', [PaymentOptionController::class, 'create'])->name('payment_option.create');
            Route::post('/store', [PaymentOptionController::class, 'store'])->name('payment_option.store');
            Route::get('/edit/{id}', [PaymentOptionController::class, 'edit'])->name('payment_option.edit');
            Route::post('/update/{id}', [PaymentOptionController::class, 'update'])->name('payment_option.update');
            Route::delete('/delete/{id}', [PaymentOptionController::class, 'destroy'])->name('payment_option.delete');
        });
        
        
    });

    // Product Management
    Route::prefix('product-management')->group(function () {

        // Product Routes
        Route::prefix('products')->group(function () {
            Route::get('/list', [ProductController::class, 'index'])->name('product.list');
            Route::get('/show/{id}', [ProductController::class, 'show'])->name('product.show');
            Route::get('/create', [ProductController::class, 'create'])->name('product.create');
            Route::post('/store', [ProductController::class, 'store'])->name('product.store');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
            Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
            Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');
            Route::get('/stock', [ProductController::class, 'stock'])->name('stock');
        });

        // Category Routes
        Route::prefix('categories')->group(function () {
            Route::get('/list', [CategoryController::class, 'index'])->name('category.list');
            Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
            Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
            Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');
        });

        // SubCategory Routes
        Route::prefix('subcategories')->group(function () {
            Route::get('/list', [SubCategoryController::class, 'index'])->name('subcategory.list');
            Route::get('/create', [SubCategoryController::class, 'create'])->name('subcategory.create');
            Route::post('/store', [SubCategoryController::class, 'store'])->name('subcategory.store');
            Route::get('/edit/{id}', [SubCategoryController::class, 'edit'])->name('subcategory.edit');
            Route::post('/update/{id}', [SubCategoryController::class, 'update'])->name('subcategory.update');
            Route::delete('/delete/{id}', [SubCategoryController::class, 'destroy'])->name('subcategory.delete');
        });

        // ChildSubCategory Routes
        Route::prefix('childsubcategories')->group(function () {
            Route::get('/list', [ChildSubCategoryController::class, 'index'])->name('childsubcategory.list');
            Route::get('/create', [ChildSubCategoryController::class, 'create'])->name('childsubcategory.create');
            Route::post('/store', [ChildSubCategoryController::class, 'store'])->name('childsubcategory.store');
            Route::get('/edit/{id}', [ChildSubCategoryController::class, 'edit'])->name('childsubcategory.edit');
            Route::post('/update/{id}', [ChildSubCategoryController::class, 'update'])->name('childsubcategory.update');
            Route::delete('/delete/{id}', [ChildSubCategoryController::class, 'destroy'])->name('childsubcategory.destroy');
        });

        // Attribute Routes
        Route::prefix('attributes')->group(function () {
            Route::get('/list', [AttributeController::class, 'index'])->name('attribute.list');
            Route::get('/create', [AttributeController::class, 'create'])->name('attribute.create');
            Route::post('/store', [AttributeController::class, 'store'])->name('attribute.store');
            Route::get('/edit/{id}', [AttributeController::class, 'edit'])->name('attribute.edit');
            Route::post('/update/{id}', [AttributeController::class, 'update'])->name('attribute.update');
            Route::delete('/delete/{id}', [AttributeController::class, 'destroy'])->name('attribute.delete');
        });

        // Brand Routes
        Route::prefix('brands')->group(function () {
            Route::get('/list', [BrandController::class, 'index'])->name('brand.list');
            Route::get('/create', [BrandController::class, 'create'])->name('brand.create');
            Route::post('/store', [BrandController::class, 'store'])->name('brand.store');
            Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
            Route::post('/update/{id}', [BrandController::class, 'update'])->name('brand.update');
            Route::delete('/delete/{id}', [BrandController::class, 'destroy'])->name('brand.delete');
        });

    });

    // Order Management
    Route::prefix('order-management')->group(function () {
        // Order Routes
        Route::prefix('orders')->group(function () {
            Route::get('/list', [OrderController::class, 'index'])->name('orders');
            // Route::get('/completed', [OrderController::class, 'completed'])->name('order.completed');
            Route::get('/cancelled', [OrderController::class, 'cancelled'])->name('order.cancelled');
            Route::get('/pending_list', [OrderController::class, 'pending_list'])->name('order.pending');
            Route::get('/confirmed_list', [OrderController::class, 'confirmed_list'])->name('order.confirmed');
            Route::get('/rejected_list', [OrderController::class, 'rejected_list'])->name('order.rejected');
            Route::get('/processing_list', [OrderController::class, 'processing_list'])->name('order.processing');
            Route::get('/shipped_list', [OrderController::class, 'shipped_list'])->name('order.shipped');
            Route::get('/completed_list', [OrderController::class, 'completed_list'])->name('order.completed');
            Route::get('/print_invoice/{id}', [OrderController::class, 'print_invoice'])->name('order.print_invoice');

            Route::get('/show', [OrderController::class, 'show'])->name('order.show');
            // Route::post('/store', [OrderController::class, 'store'])->name('order.store');
            Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
            Route::post('/update', [OrderController::class, 'update_status'])->name('order.update.status');
            Route::delete('/delete/{id}', [OrderController::class, 'destroy'])->name('order.delete');
        });
    });

    Route::prefix('customer-management')->group(function () {
        Route::get('/list', [CustomerController::class, 'index'])->name('customer.list');
        Route::get('/groups', [CustomerController::class, 'groups'])->name('customer.group');
    });

    Route::prefix('shipping-management')->group(function () {
        Route::get('shipping-methods', [ShippingMethodController::class, 'index'])->name('shipping-methods.index');
        Route::post('shipping-methods', [ShippingMethodController::class, 'store'])->name('shipping-methods.store');
        Route::get('shipping-methods/{shippingMethod}/edit', [ShippingMethodController::class, 'edit'])->name('shipping-methods.edit');
        Route::post('shipping-methods/{shippingMethod}', [ShippingMethodController::class, 'update'])->name('shipping-methods.update');
        Route::delete('shipping-methods/{shippingMethod}', [ShippingMethodController::class, 'destroy'])->name('shipping-methods.destroy');
        Route::post('shipping-methods/{shippingMethod}/toggle-status', [ShippingMethodController::class, 'toggleStatus'])->name('shipping-methods.toggle-status');
    });



    Route::prefix('promotion-management')->group(function () {
        Route::get('/coupons', [CouponController::class, 'index'])->name('coupon.list');
        Route::get('/banners', [BannerController::class, 'index'])->name('banner.list');
        Route::get('/offers', [OfferController::class, 'index'])->name('offer.list');
    });

    Route::prefix('reports')->group(function () {
        Route::get('/sales', [ReportController::class, 'sales'])->name('report.sales');
        Route::get('/customers', [ReportController::class, 'customers'])->name('report.customer');
        Route::get('/products', [ReportController::class, 'products'])->name('report.product');
    });


    Route::prefix('settings')->group(function () {

        Route::get('/general-settings', [GeneralSettingController::class, 'edit'])->name('admin.general-settings.edit');
        Route::post('/general-settings', [GeneralSettingController::class, 'update'])->name('admin.general-settings.update');

        Route::get('/contact', [ContactSettingController::class, 'edit'])->name('contact-settings.edit');
        Route::post('/contact', [ContactSettingController::class, 'update'])->name('contact-settings.update');

        Route::get('/social/edit', [SocialMediaSettingController::class, 'edit'])->name('social.edit');
        Route::post('/social/update', [SocialMediaSettingController::class, 'update'])->name('social.update');

        Route::get('/homepage/edit', [HomePageSettingController::class, 'edit'])->name('homepage.edit');
        Route::post('/homepage/update', [HomePageSettingController::class, 'update'])->name('homepage.update');

        Route::get('/general', [SettingController::class, 'general'])->name('settings.general');
        Route::get('/branding', [SettingController::class, 'branding'])->name('settings.branding');
        Route::get('/email', [SettingController::class, 'email'])->name('settings.email');
        Route::get('/seo', [SettingController::class, 'seo'])->name('settings.seo');

        Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscribers');
        Route::get('/subscriber/edit/{faq}', [SubscriberController::class, 'edit'])->name('subscriber.edit');
        Route::post('/subscriber/update/{faq}', [SubscriberController::class, 'update'])->name('subscriber.update');
        Route::delete('/subscriber/delete/{faq}', [SubscriberController::class, 'destroy'])->name('subscriber.delete');

        // FAQ Routes
        Route::get('/faq/index', [FaqController::class, 'index'])->name('faq.index');
        Route::get('/faq/create', [FaqController::class, 'create'])->name('faq.create');
        Route::post('/faq/store', [FaqController::class, 'store'])->name('faq.store');
        Route::get('/faq/edit/{faq}', [FaqController::class, 'edit'])->name('faq.edit');
        Route::post('/faq/update/{faq}', [FaqController::class, 'update'])->name('faq.update');
        Route::delete('/faq/delete/{faq}', [FaqController::class, 'destroy'])->name('faq.delete');

        // Return Policy Routes
        Route::get('/return-policy/index', [ReturnPolicyController::class, 'index'])->name('return_policy.index');
        Route::get('/return-policy/create', [ReturnPolicyController::class, 'create'])->name('return_policy.create');
        Route::post('/return-policy/store', [ReturnPolicyController::class, 'store'])->name('return_policy.store');
        Route::get('/return-policy/edit/{returnPolicy}', [ReturnPolicyController::class, 'edit'])->name('return_policy.edit');
        Route::post('/return-policy/update/{returnPolicy}', [ReturnPolicyController::class, 'update'])->name('return_policy.update');
        Route::delete('/return-policy/delete/{returnPolicy}', [ReturnPolicyController::class, 'destroy'])->name('return_policy.delete');


        // Shipping Policy Routes
        Route::get('/shipping-policy/index', [ShippingPolicyController::class, 'index'])->name('shipping_policy.index');
        Route::get('/shipping-policy/create', [ShippingPolicyController::class, 'create'])->name('shipping_policy.create');
        Route::post('/shipping-policy/store', [ShippingPolicyController::class, 'store'])->name('shipping_policy.store');
        Route::get('/shipping-policy/edit/{shippingPolicy}', [ShippingPolicyController::class, 'edit'])->name('shipping_policy.edit');
        Route::post('/shipping-policy/update/{shippingPolicy}', [ShippingPolicyController::class, 'update'])->name('shipping_policy.update');
        Route::delete('/shipping-policy/delete/{shippingPolicy}', [ShippingPolicyController::class, 'destroy'])->name('shipping_policy.delete');


        // Privacy Policy Routes
        Route::get('/privacy-policy/index', [PrivacyPolicyController::class, 'index'])->name('privacy_policy.index');
        Route::get('/privacy-policy/create', [PrivacyPolicyController::class, 'create'])->name('privacy_policy.create');
        Route::post('/privacy-policy/store', [PrivacyPolicyController::class, 'store'])->name('privacy_policy.store');
        Route::get('/privacy-policy/edit/{privacyPolicy}', [PrivacyPolicyController::class, 'edit'])->name('privacy_policy.edit');
        Route::post('/privacy-policy/update/{privacyPolicy}', [PrivacyPolicyController::class, 'update'])->name('privacy_policy.update');
        Route::delete('/privacy-policy/delete/{privacyPolicy}', [PrivacyPolicyController::class, 'destroy'])->name('privacy_policy.delete');

        
        Route::get('/cache_setting', [CacheSettingController::class, 'edit'])->name('cache.setting');
        Route::post('/cache_setting/update', [CacheSettingController::class, 'update'])->name('admin.cache_settings.update');
    });





    // Purchase Management
    Route::prefix('purchase-management')->group(function () {
        // Supplier Routes
        Route::prefix('suppliers')->group(function () {
            Route::get('/list', [SupplierController::class, 'index'])->name('supplier.list');
            Route::get('/create', [SupplierController::class, 'create'])->name('supplier.create');
            Route::post('/store', [SupplierController::class, 'store'])->name('supplier.store');
            Route::get('/edit/{supplier}', [SupplierController::class, 'edit'])->name('supplier.edit');
            Route::post('/update/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
            Route::delete('/delete/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.delete');
        });


        // Purchase Routes
        Route::prefix('purchases')->group(function () {
            Route::get('/show/{id}', [PurchaseController::class, 'show'])->name('purchase.show');
            Route::get('/list', [PurchaseController::class, 'index'])->name('purchase.list');
            Route::get('/create', [PurchaseController::class, 'create'])->name('purchase.create');
            Route::post('/store', [PurchaseController::class, 'store'])->name('purchase.store');
            Route::get('/edit/{purchase}', [PurchaseController::class, 'edit'])->name('purchase.edit');
            Route::post('/update/{purchase}', [PurchaseController::class, 'update'])->name('purchase.update');
            Route::delete('/delete/{purchase}', [PurchaseController::class, 'destroy'])->name('purchase.delete');
        });


    });

    // Homepage Banners CRUD
    Route::prefix('homepage_banner')->group(function () {
        Route::get('/', [HomepageBannerController::class, 'index'])->name('homepage_banner.index');
        Route::get('/create', [HomepageBannerController::class, 'create'])->name('homepage_banner.create');
        Route::post('/store', [HomepageBannerController::class, 'store'])->name('homepage_banner.store');
        Route::get('/edit/{id}', [HomepageBannerController::class, 'edit'])->name('homepage_banner.edit');
        Route::post('/update/{id}', [HomepageBannerController::class, 'update'])->name('homepage_banner.update');
        Route::delete('/delete/{id}', [HomepageBannerController::class, 'destroy'])->name('homepage_banner.destroy');
    });

    // AJAX calls
    Route::get('/getProducts', [ProductController::class, 'getProducts'])->name('getProducts');
    Route::get('/getNextProductId', [ProductController::class, 'getNextProductId'])->name('getNextProductId');

    Route::get('/get-subcategories/{category_id}', [HomepageBannerController::class, 'getSubcategories'])->name('get.subcategories');
    Route::get('/get-child-subcategories/{sub_category_id}', [HomepageBannerController::class, 'getChildSubcategories'])->name('get.childsubcategories');

});

