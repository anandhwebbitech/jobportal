<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Route;

    

Route::get('/', [AdminController::class, 'login'])->name('login');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'loginSubmit'])->name('login.submit');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::resource('categories', CategoryController::class);
        Route::resource('colors', ColorController::class);
        Route::resource('skills', SkillController::class);
        Route::resource('sizes', SizeController::class);
        Route::resource('subcategories', SubCategoryController::class);
    
        Route::resource('products', ProductController::class);
        Route::get('get-subcategories/{category}', [ProductController::class, 'getSubcategories'])
            ->name('products.getSubcategories');
        Route::delete('products/image/{id}', [ProductController::class, 'deleteImage'])
            ->name('products.image.delete');
    
        Route::resource('sliders', SliderController::class);
        Route::post('sliders/{id}/toggle-status', [SliderController::class, 'toggleStatus'])
            ->name('sliders.toggleStatus');

        // Inventory
        Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
        Route::put('inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');

        Route::resource('coupons', CouponController::class);

        Route::resource('users', CustomerController::class);

        Route::get('settings/index/{type?}', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update');

        Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    });
});
