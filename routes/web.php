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
use App\Http\Controllers\Frontend\FrontendController;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Api\JobApiController;
use App\Http\Controllers\Frontend\JobController as FrontendJobController;

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


Route::controller(FrontendController::class)->group(function () {

    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('about');

    Route::get('/pricing', 'pricing')->name('pricing');
    Route::get('/contact', 'contact')->name('contact');

    Route::get('/post-job', 'postJob')->name('post-job');
    Route::post('/contact-submit', 'contactSubmit')->name('contact.submit');
});

Route::controller(FrontendJobController::class)->group(function () {

    // JOB LIST
    Route::get('/jobs/index', 'index')->name('jobs.index');

    // CREATE JOB PAGE
    Route::get('/jobs/create', 'create')->name('jobs.create');

    // STORE JOB
    Route::post('/jobs/store', 'store')->name('jobs.store');

    // APPLY JOB
    Route::get('/jobs/{id}/apply', 'apply')->name('jobs.apply');

    // JOB DETAILS (KEEP LAST)
    Route::get('/jobs/{slug}', action: 'show')->name('jobs.show');

});


Route::middleware(['frontend'])->group(function () {
    Route::get('/jobs', [JobApiController::class, 'index']);          // List jobs
    Route::get('/jobs/{id}', [JobApiController::class, 'show']);      // Job preview/details
    Route::post('/jobs/{id}/apply', [JobApiController::class, 'apply']); // Apply to job
    Route::post('/jobs/{slug}/apply', [FrontendController::class, 'jobApplySubmit'])
    ->name('jobs.apply.submit');
});

Route::controller(AuthController::class)->group(function () {

    // Job Seeker
    Route::get('/jobseeker/login', 'jobseekerLogin')->name('jobseeker.login');
    Route::post('/jobseeker/login', 'jobseekerLoginSubmit')->name('jobseeker.login.submit');

    Route::get('/jobseeker/register', 'jobseekerRegister')->name('jobseeker.register');
    Route::post('/jobseeker/register', 'jobseekerRegisterSubmit')->name('jobseeker.register.submit');

    // Employer
    Route::get('/employer/login', 'employerLogin')->name('employer.login');
    Route::post('/employer/login', 'employerLoginSubmit')->name('employer.login.submit');

    Route::get('/employer/register', 'employerRegister')->name('employer.register');
    Route::post('/employer/register', 'employerRegisterSubmit')->name('employer.register.submit');

    // Forgot Password
    Route::get('/forgot-password', 'forgotPassword')->name('forgot.password');
    Route::post('/forgot-password', 'forgotPasswordSubmit')->name('forgot.password.submit');

    // Reset Password
    Route::get('/reset-password/{token}', 'resetPassword')->name('reset.password');
    Route::post('/reset-password', 'resetPasswordSubmit')->name('reset.password.submit');

    Route::post('/logout', 'logout')->name('logout');

});