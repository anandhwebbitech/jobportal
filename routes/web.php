<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\JobSeekerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\JobSeeker\DashboardController;
use App\Http\Controllers\ResumePlanController;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Api\JobApiController;
use App\Http\Controllers\Frontend\JobController as FrontendJobController;
use App\Http\Controllers\JobSeeker\DashboardController as JobSeekerDashboardController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use App\Http\Controllers\Employer\ProfileController;
use App\Http\Controllers\JobSeeker\AlertController;
use App\Http\Controllers\JobSeeker\ApplicationController;
use App\Http\Controllers\JobSeeker\NotificationController;
use App\Http\Controllers\JobSeeker\ProfileController as JobSeekerProfileController;
use App\Http\Controllers\JobSeeker\ResumeController;
use App\Http\Controllers\JobSeeker\SavedJobController;
use App\Http\Controllers\JobSeeker\SettingsController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\EmployerController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\JobPlanController;
use App\Http\Controllers\BannerPlanController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Mail;



Route::get('/test-mail', function () {
    try {
        Mail::raw('Test Mail Working', function ($message) {
            $message->to('anandhwebbitech@gmail.com')
                    ->subject('Test Mail');
        });

        return "Mail Sent Successfully ✅";
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});
Route::get('/', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('userlogin');
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'loginSubmit'])->name('login.submit');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admindashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::resource('skills', SkillController::class);
        Route::resource('educations', EducationController::class);
        Route::resource('locations', LocationController::class);
        Route::resource('employers', EmployerController::class);
        Route::resource('jobseekers', JobSeekerController::class);
        Route::resource('jobs', JobController::class);
        Route::resource('users', CustomerController::class);
        Route::get('settings/index/{type?}', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update');
        Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
        Route::post('/admin/employers/approve/{id}', [EmployerController::class, 'approve'])->name('employers.approve');
        Route::post('/admin/jobs/approve/{id}', [JobController::class, 'approve'])->name('jobs.approve');

        Route::resource('plans', JobPlanController::class);
        Route::get('/admin/plans/{id}/edit', [JobPlanController::class, 'edit'])->name('admin.plans.edit');
        Route::post('/admin/plans/{id}/update', [JobPlanController::class, 'update'])->name('admin.plans.update');

        Route::get('resume-plans', [JobPlanController::class, 'resumeindex'])->name('resumeplans.index');
        Route::post('resume-plans', [JobPlanController::class, 'Resumestore'])->name('resumeplans.store');
        Route::get('resume-plans/{id}/edit', [JobPlanController::class, 'Resumeedit'])->name('resumeplans.edit');
        Route::post('resume-plans/{id}', [JobPlanController::class, 'Resumeupdate'])->name('resumeplans.update');
        Route::delete('resume-plans/{id}', [JobPlanController::class, 'destroy'])->name('resumeplans.destroy');


        Route::get('banner-plans', [JobPlanController::class, 'BannerAdindex'])->name('bannerplans.index');
        Route::post('banner-plans', [JobPlanController::class, 'BannerAdstore'])->name('bannerplans.store');
        Route::get('banner-plans/{id}/edit', [JobPlanController::class, 'BannerAdedit'])->name('bannerplans.edit');
        Route::post('banner-plans/{id}', [JobPlanController::class, 'BannerAdupdate'])->name('bannerplans.update');
        Route::delete('banner-plans/{id}', [JobPlanController::class, 'BannerAddestroy'])->name('bannerplans.destroy');

        });
    Route::post('jobseekers/{id}/approve', [JobSeekerController::class, 'Approve'])->name('jobseekers.approve');
    Route::get('/notification', [AdminController::class, 'AdminNotification'])->name('adminnotification');
    Route::get('admin/notifications-data', [AdminController::class, 'AdminNotificationData'])->name('notifications.data');
});


Route::controller(FrontendController::class)->group(function () {

    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('about');

    Route::get('/pricing', 'pricing')->name('pricing');
    Route::get('/contact', 'contact')->name('contact');

    Route::get('/post-job', 'postJob')->name('post-job');
    Route::post('/contact-submit', 'contactSubmit')->name('contact.submit');

    
});
Route::get('/search-jobs', [FrontendController::class, 'searchJobs'])->name('jobs.search');

Route::get('/get-districts/{state}', [FrontendController::class, 'getDistricts'])->name('get.districts');


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
Route::post('/jobs/apply/{id}', [FrontendJobController::class, 'applyJob'])->name('jobs.apply.submit');

Route::middleware(['frontend'])->group(function () {
    Route::get('/jobs', [JobApiController::class, 'index']);          // List jobs
    Route::get('/jobs/{id}', [JobApiController::class, 'show']);      // Job preview/details
    Route::post('/jobs/{id}/apply', [JobApiController::class, 'apply']); // Apply to job
    Route::post('/jobs/{slug}/apply', [FrontendController::class, 'jobApplySubmit'])
        ->name('jobs.apply.submit');
});
Route::post('/jobseeker-register-store', [AuthController::class, 'jobseekerRegisterSubmit'])->name('jobseeker_register.store');
Route::post('/employer-register-store', [AuthController::class, 'employerRegisterSubmit'])->name('employer_register.store');

Route::controller(AuthController::class)->group(callback: function () {

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

    Route::get('/jobs-preview/{id}', [AuthController::class, 'preview'])
        ->name('jobs.preview');

    Route::post('/logout', 'logout')->name('logout');
});

    Route::post('/buy-plan', [JobPlanController::class, 'buyPlan'])->name('buy.plan');
    Route::post('/buy-resume-plan', [JobPlanController::class, 'buyResumePlan'])->name('buy.resumeplan');

   
    Route::post('/create-resume-order', [ResumePlanController::class, 'createResumeOrder'])
        ->name('resume.order.create');

    Route::post('/verify-resume-payment', [ResumePlanController::class, 'verifyResumePayment'])
        ->name('resume.payment.verify');

    Route::post('/create-order', [JobPlanController::class, 'createOrder']);
    Route::post('/verify-payment', [JobPlanController::class, 'verifyPayment']);
    Route::get('/check-download/{id}', [ResumeController::class, 'checkDownload'])->name('resume.check');
    Route::get('/download/{id}', [ResumeController::class, 'download'])->name('resume.download');

     Route::post('/purchase-banner', [JobPlanController::class, 'purchaseBanner'])
        ->name('banner.purchase');

    Route::post('/banner-payment-success', [JobPlanController::class, 'paymentSuccess'])
        ->name('banner.payment.success');


    Route::post('/create-banner-order', [BannerPlanController::class, 'createBannerOrder'])
        ->name('banner.order.create');

    Route::post('/verify-banner-payment', [BannerPlanController::class, 'verifyBannerPayment'])
        ->name('banner.payment.verify');
   Route::get('/user/invoices', [InvoiceController::class, 'getInvoices'])->name('user.invoices');

    Route::get('/invoice-pdf/{id}', [InvoiceController::class, 'downloadPdf'])->name('invoice.pdf');

Route::prefix('employer')->name('employer.')->middleware(['auth', 'employer'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [EmployerDashboardController::class, 'logout'])->name('logout');

    // Company Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Billing & Plans
    Route::get('/billing', [EmployerDashboardController::class, 'billing'])->name('billing');
    Route::post('/billing/purchase', [EmployerDashboardController::class, 'billingPurchase'])->name('billing.purchase');
    Route::get('/billing/invoice/{id}', [EmployerDashboardController::class, 'billingInvoice'])->name('billing.invoice');

    // Jobs
    Route::get('/jobs', [EmployerDashboardController::class, 'jobs'])->name('jobs.index');
    Route::get('/jobs/create', [EmployerDashboardController::class, 'jobsCreate'])->name('jobs.create');
    Route::post('/jobs', [EmployerDashboardController::class, 'jobsStore'])->name('jobs.store');
    Route::get('/jobs/{id}', [EmployerDashboardController::class, 'jobsShow'])->name('jobs.show');
    Route::get('/jobs/{id}/edit', [EmployerDashboardController::class, 'jobsEdit'])->name('jobs.edit');
    Route::put('/jobs/{id}', [EmployerDashboardController::class, 'jobsUpdate'])->name('jobs.update');
    Route::delete('/jobs/{id}', [EmployerDashboardController::class, 'jobsDestroy'])->name('jobs.destroy');
    Route::post('/jobs/{id}/toggle', [EmployerDashboardController::class, 'jobsToggle'])->name('jobs.toggle');

    // Candidates
    Route::get('/candidates', [EmployerDashboardController::class, 'candidates'])->name('candidates');
    Route::get('/candidates/{id}', [EmployerDashboardController::class, 'candidatesShow'])->name('candidates.show');
    Route::patch('/candidates/{id}/status', [EmployerDashboardController::class, 'candidatesStatus'])->name('candidates.status');
    Route::get('/candidates/{id}/resume', [EmployerDashboardController::class, 'candidatesResume'])->name('candidates.resume');

    Route::post('/employer/candidate/update-status', [EmployerDashboardController::class, 'updateStatus'])
        ->name('candidate.update.status');

    Route::get('/employer/candidate/download-resume/{id}', [EmployerDashboardController::class, 'downloadResume'])
        ->name('candidateresume.download');
    Route::get('/employer/resume/view/{id}', [EmployerDashboardController::class, 'viewResume'])
        ->name('resume.view');
    // Resume Database
    Route::get('/resume', [EmployerDashboardController::class, 'resume'])->name('resume');
    Route::get('/resume/{id}/view', [EmployerDashboardController::class, 'resumeView'])->name('resume.view');
    Route::get('/resume/{id}/download', [EmployerDashboardController::class, 'resumeDownload'])->name('resume.download');

    // Advertisements
    Route::get('/ads', [EmployerDashboardController::class, 'advertisements'])->name('ads');
    Route::post('/ads', [EmployerDashboardController::class, 'adsStore'])->name('ads.store');
    Route::delete('/ads/{id}', [EmployerDashboardController::class, 'adsDestroy'])->name('ads.destroy');

    // Notifications
    Route::get('/notifications', [EmployerDashboardController::class, 'notifications'])->name('notifications');
    Route::patch('/notifications/{id}/read', [EmployerDashboardController::class, 'notificationsRead'])->name('notifications.read');
    Route::patch('/notifications/read-all', [EmployerDashboardController::class, 'notificationsReadAll'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [EmployerDashboardController::class, 'notificationsDestroy'])->name('notifications.destroy');

    // Settings
    Route::get('/settings', [EmployerDashboardController::class, 'settings'])->name('settings');
    Route::post('/settings/password', [EmployerDashboardController::class, 'settingsPassword'])->name('settings.password');
    Route::patch('/settings/notifications', [EmployerDashboardController::class, 'settingsNotifications'])->name('settings.notifications');
    Route::delete('/settings/delete', [EmployerDashboardController::class, 'deleteAccount'])->name('settings.delete');
});

// ═════════════════════════════════════
// JOB SEEKER DASHBOARD ROUTES
// ═════════════════════════════════════

Route::prefix('jobseeker')->name('jobseeker.')->group(function () {

        // DASHBOARD
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // PROFILE
        Route::prefix('profile')->name('profile.')->group(function () {

            Route::get('/', [JobSeekerProfileController::class, 'index'])->name('index');
            Route::put('/', [JobSeekerProfileController::class, 'update'])->name('update');
            Route::put('/education', [JobSeekerProfileController::class, 'education'])->name('education');
            Route::put('/experience', [JobSeekerProfileController::class, 'experience'])->name('experience');
            Route::put('/skills', [JobSeekerProfileController::class, 'skills'])->name('skills');
        });

        // RESUME
        Route::prefix('resume')->name('resume.')->group(function () {

            Route::get('/', [ResumeController::class, 'index'])->name('index');
            Route::post('/upload', [ResumeController::class, 'upload'])->name('upload');
            Route::delete('/delete', [ResumeController::class, 'delete'])->name('delete');
            Route::put('/visibility', [ResumeController::class, 'visibility'])->name('visibility');
        });

        // APPLIED JOBS
        Route::prefix('applied')->name('applied.')->group(function () {

            Route::get('/', [ApplicationController::class, 'index'])->name('index');
            Route::get('/{id}', [ApplicationController::class, 'show'])->name('show');
            Route::get('/application/{id}', [ApplicationController::class, 'detail'])->name('application');
        });

        // SAVED JOBS
        Route::prefix('saved')->name('saved.')->group(function () {

            Route::get('/', [SavedJobController::class, 'index'])->name('index');
            Route::post('/{jobId}', [SavedJobController::class, 'save'])->name('save');
            Route::delete('/{id}', [SavedJobController::class, 'remove'])->name('remove');
        });
        Route::post('/jobs/toggle-save', [SavedJobController::class, 'toggleSave'])->name('jobs.toggleSave');
        Route::get('/jobs/get-saved', [SavedJobController::class, 'getSavedJobs'])->name('jobs.getSaved');
        Route::delete('/jobseeker/saved/{id}', [SavedJobController::class, 'destroy'])->name('saved.destroy');
        // JOB ALERTS
        Route::prefix('alerts')->name('alerts.')->group(function () {

            Route::get('/', [AlertController::class, 'index'])->name('index');
            Route::post('alertstore', [AlertController::class, 'store'])->name('store');
            Route::get('/alerts/list', [AlertController::class, 'list'])->name('list');
            Route::get('/{id}/edit', [AlertController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AlertController::class, 'update'])->name('update');
            Route::put('/{id}/toggle', [AlertController::class, 'toggle'])->name('toggle');
            Route::delete('/{id}', [AlertController::class, 'destroy'])->name('delete');
        });

        // NOTIFICATIONS
        Route::prefix('notifications')->name('notifications.')->group(function () {

            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::put('/{id}/read', [NotificationController::class, 'markRead'])->name('read');
            Route::put('/read-all', [NotificationController::class, 'readAll'])->name('readAll');
            
        });
        Route::get('/notificationslist', [NotificationController::class, 'Notificationlist'])->name('notifications.ajax');
        Route::put('/jobseeker/notifications/read/{id}', [NotificationController::class, 'markRead'])->name('notifications.read');

        // SETTINGS
        Route::prefix('settings')->name('settings.')->group(function () {

            Route::get('/', [SettingsController::class, 'index'])->name('index');
            Route::post('/password', [SettingsController::class, 'updatePassword'])->name('password');
            Route::put('/notifications', [SettingsController::class, 'updateNotifs'])->name('notifications');
            Route::put('/privacy', [SettingsController::class, 'updatePrivacy'])->name('privacy');
            Route::delete('/account', [SettingsController::class, 'deleteAccount'])->name('delete');
        });
    });

Route::post('/job-plans/store', [JobPlanController::class, 'store'])->name('job-plans.store');
Route::get('/notifications', [NotificationController::class, 'Notificationlist'])->name('notifications.list');
Route::post('/notifications/mark-read/{id}', [NotificationController::class, 'markRead'])->name('notifications.markRead');
Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.delete');
Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
Route::post('/notifications/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clearAll');