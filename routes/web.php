<?php

use Illuminate\Support\Facades\Route;

// User controllers
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\LoginController as UserLoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AccountController;

// Admin controllers
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PasswordResetController;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('home'))->name('home');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/forex', fn() => view('forex'))->name('forex');
Route::get('/metals', fn() => view('metals'))->name('metals');
Route::get('/indices', fn() => view('indices'))->name('indices');
Route::get('/crypto', fn() => view('crypto'))->name('crypto');
Route::get('/platform', fn() => view('platform'))->name('platform');
Route::get('/contact', fn() => view('contact'))->name('contact');

/*
|--------------------------------------------------------------------------
| User Authentication (Guest Only)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Signup
    Route::get('/signup', [RegistrationController::class, 'showForm'])->name('signup');
    Route::post('/signup', [RegistrationController::class, 'submit'])->name('signup.submit');

    // OTP Verification
    Route::get('/verify-email', [OtpController::class, 'showVerify'])->name('otp.show');
    Route::post('/verify-email', [OtpController::class, 'verify'])->name('otp.verify');
    Route::post('/resend-otp', [OtpController::class, 'resend'])->name('otp.resend');

    // Login
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::post('/login', [UserLoginController::class, 'login'])->name('login.submit');

    // Forgot Password


Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('forgot-password.show');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('forgot-password.send');


    // Reset Password Form
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])
        ->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [UserLoginController::class, 'logout'])->name('user.logout');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('dashboard.profile');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('dashboard.profile.avatar');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('dashboard.profile.password');

    // Transactions
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    });

    // Accounts
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');
});

/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/
// Admin Login
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');

/*
|--------------------------------------------------------------------------
| Admin Routes (Authenticated)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('auth:admin')->group(function() {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    // Admin Profile
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('admin.profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.password');

    // Manage Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    // Assign / Update Live ID
    Route::post('/users/{user}/assign-live-id', [UserController::class, 'assignLiveId'])->name('users.assignLiveId');
    Route::delete('/users/{user}/delete-account/{account}', [UserController::class, 'deleteAccount'])
    ->name('users.deleteAccount');



    // Password reset requests
    Route::get('password-requests', [PasswordResetController::class, 'index'])->name('admin.password.requests');
    Route::post('admin/password-requests/{user}/send', [PasswordResetController::class, 'send'])
    ->name('admin.password.send');

    // Show admin reset form (required for notifications)
    Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])
        ->name('password.reset');
});


// Fetch unread notifications
use App\Http\Controllers\Admin\NotificationController;

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('notifications/fetch', [NotificationController::class, 'fetch'])->name('admin.notifications.fetch');
    Route::post('notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.markAsRead');
    });


use App\Http\Controllers\UserNotificationController;

Route::get('/user/notifications/fetch', [UserNotificationController::class, 'fetch'])
     ->name('user.notifications.fetch');

Route::put('/user/notifications/mark-as-read', [UserNotificationController::class, 'markAsRead'])
     ->name('user.notifications.markAsRead');

Route::delete('/user/notifications/{id}', [UserNotificationController::class, 'destroy'])
     ->name('user.notifications.destroy');




use App\Http\Controllers\Admin\AdminNotificationController;

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    // Notification history with filters
    Route::get('notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');

    // Show send notification form
    Route::get('notifications/send', [AdminNotificationController::class, 'create'])->name('admin.notifications.create');

    // Send notification
    Route::post('notifications/send', [AdminNotificationController::class, 'send'])->name('admin.notifications.send');
});



Route::post('notifications/send', [AdminNotificationController::class, 'store'])->name('admin.notifications.store');


use App\Http\Controllers\Admin\AccountController as AdminAccountController;


Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::get('/accounts', [AdminAccountController::class, 'index'])->name('accounts.index');
    Route::post('/accounts', [AdminAccountController::class, 'store'])->name('accounts.store');
    Route::put('/accounts/{account}', [AdminAccountController::class, 'update'])->name('accounts.update');
    Route::delete('/accounts/{account}', [AdminAccountController::class, 'destroy'])->name('accounts.destroy');

    // ✅ New route to upload PNL
    Route::post('/accounts/{account}/upload-pnl', [AdminAccountController::class, 'uploadPNL'])->name('accounts.uploadPNL');
});



Route::post('/admin/users/{user}/promo', [App\Http\Controllers\Admin\UserController::class, 'updatePromoCode'])
    ->name('admin.users.updatePromoCode');


use App\Http\Controllers\Admin\AdminTransactionController;

Route::prefix('admin')->middleware('auth:admin')->group(function() {

    // Show transactions with search & pagination
    Route::get('transactions', [AdminTransactionController::class, 'index'])
        ->name('admin.transactions.index');

    // Store / Upload new transaction
    Route::post('transactions', [AdminTransactionController::class, 'store'])
        ->name('admin.transactions.store');

    // Update transaction (normal form submission, not AJAX)
    Route::put('transactions/{transaction}', [AdminTransactionController::class, 'update'])
        ->name('admin.transactions.update');

    // Delete transaction (normal form submission, not AJAX)
    Route::delete('transactions/{transaction}', [AdminTransactionController::class, 'destroy'])
        ->name('admin.transactions.destroy');

});


use App\Http\Controllers\DepositController;

Route::middleware(['auth'])->group(function() {
    // Show deposit page
    Route::get('/dashboard/deposit', [DepositController::class, 'index'])->name('deposit.index');

    // Handle deposit submission (form POST)
    Route::post('/dashboard/deposit', [DepositController::class, 'store'])->name('deposit.store');

    // Handle live ID request (POST)
    Route::post('/dashboard/deposit/request-live-id', [DepositController::class, 'requestLiveId'])->name('deposit.requestLiveId');
});




use App\Http\Controllers\WithdrawController;

Route::middleware(['auth'])->group(function () {
    // Show withdrawal form
    Route::get('/withdraw', function () {
        return view('dashboard.withdraw'); // include folder name
    })->name('withdraw.form');

    // Submit withdrawal request
    Route::post('/withdraw', [WithdrawController::class, 'store'])->name('withdraw.store');
});


use App\Http\Controllers\Admin\AdminWithdrawController;

Route::prefix('admin')->middleware('auth:admin')->group(function() {

    Route::get('withdrawals', [AdminWithdrawController::class, 'index'])
        ->name('admin.withdrawals.index');

    Route::patch('withdrawals/{withdrawal}', [AdminWithdrawController::class, 'update'])
        ->name('admin.withdrawals.update');



});


use App\Http\Controllers\Admin\AdminDepositController;

Route::prefix('admin')->middleware('auth:admin')->group(function() {

    // Show all deposit requests
    Route::get('deposits', [AdminDepositController::class, 'index'])
        ->name('admin.deposits.index');

    // Approve deposit
    Route::post('deposits/{deposit}/approve', [AdminDepositController::class, 'approve'])
        ->name('admin.deposits.approve');

    // Reject deposit
    Route::post('deposits/{deposit}/reject', [AdminDepositController::class, 'reject'])
        ->name('admin.deposits.reject');
});


Route::post('/admin/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])
    ->name('admin.users.toggleStatus');


Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [DashboardController::class, 'notifications'])->name('user.notifications');
});





// Notifications history page
Route::get('/notifications', [UserNotificationController::class, 'history'])
     ->name('user.notifications')
     ->middleware('auth');




Route::get('/dashboard/transactions', [TransactionController::class, 'index'])
    ->name('dashboard.transactions.index');

Route::get('/dashboard/transactions/pdf', [TransactionController::class, 'downloadPdf'])
    ->name('dashboard.transactions.pdf');


use App\Http\Controllers\VerificationController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/verification', [VerificationController::class, 'index'])->name('verification.index');
    Route::post('/dashboard/verification/identity', [VerificationController::class, 'uploadIdentity'])->name('verification.uploadIdentity');
    Route::post('/dashboard/verification/address', [VerificationController::class, 'uploadAddress'])->name('verification.uploadAddress');
    Route::post('/verification/upload-both', [VerificationController::class, 'uploadBoth'])
    ->name('verification.uploadBoth');

});




Route::prefix('admin')->middleware(['auth:admin'])->group(function(){

    // Admin verification dashboard
    Route::get('verifications', [\App\Http\Controllers\Admin\VerificationAdminController::class, 'index'])
        ->name('admin.verifications');

    // Identity approve/reject
    Route::post('verifications/{profile}/approve-identity', [\App\Http\Controllers\Admin\VerificationAdminController::class, 'approveIdentity'])
        ->name('admin.verifications.approveIdentity');

    Route::post('verifications/{profile}/reject-identity', [\App\Http\Controllers\Admin\VerificationAdminController::class, 'rejectIdentity'])
        ->name('admin.verifications.rejectIdentity');

    // Address approve/reject
    Route::post('verifications/{profile}/approve-address', [\App\Http\Controllers\Admin\VerificationAdminController::class, 'approveAddress'])
        ->name('admin.verifications.approveAddress');

    Route::post('verifications/{profile}/reject-address', [\App\Http\Controllers\Admin\VerificationAdminController::class, 'rejectAddress'])
        ->name('admin.verifications.rejectAddress');

        Route::get('verifications', [\App\Http\Controllers\Admin\VerificationAdminController::class, 'index'])
    ->name('admin.verifications');
});






use App\Http\Controllers\Admin\AdminTransactionHistoryController;

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::get('transactions/history', [AdminTransactionHistoryController::class, 'index'])
         ->name('admin.transactions.history');

// Show completed/failed transactions with search & pagination
Route::get('transactions/history', [AdminTransactionHistoryController::class, 'index'])
    ->name('admin.transactions.history');

    Route::get('transactions/history/pdf', [AdminTransactionHistoryController::class, 'exportPdf'])
         ->name('admin.transactions.history.pdf');

         Route::post('/admin/transactions/{transaction}/update', [AdminTransactionHistoryController::class, 'update'])
    ->name('admin.transactions.update');


    Route::post('transactions/store', [AdminTransactionHistoryController::class, 'store'])
        ->name('admin.transactions.store');
    
});



Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])
    ->name('forgot-password.show');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('forgot-password.send');








use App\Http\Controllers\Admin\PricingPlanController;

Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::resource('pricing', PricingPlanController::class);
});



use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');


use App\Http\Controllers\Admin\AdminDepositMethodController;

Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::get('deposit-methods', [AdminDepositMethodController::class, 'index'])->name('deposit-methods.index');
    Route::post('deposit-methods', [AdminDepositMethodController::class, 'store'])->name('deposit-methods.store');
    Route::put('deposit-methods/{id}', [AdminDepositMethodController::class, 'update'])->name('deposit-methods.update');
    Route::delete('deposit-methods/{id}', [AdminDepositMethodController::class, 'destroy'])->name('deposit-methods.destroy');
});


Route::get('/dashboard/account/{id}/details', [App\Http\Controllers\DashboardController::class, 'getAccountDetails']);



    Route::delete('/bulk-delete-notifications', [AdminNotificationController::class, 'bulkDeleteNotifications'])->name('admin.notifications.bulkDelete');
    Route::delete('/bulk-delete-activities', [AdminNotificationController::class, 'bulkDeleteActivities'])->name('admin.activities.bulkDelete');



use Illuminate\Support\Facades\Http;


/*
|--------------------------------------------------------------------------
| App Download Routes
|--------------------------------------------------------------------------
*/

// ANDROID (direct .apk download)
Route::get('/download/android', function () {
    $url = 'https://www.hybridsolutions.com/downloads/VertexFXTraderLite_1.7.apk';
    $fileName = 'VertexFXTraderLite_1.7.apk';

    $response = Http::get($url);
    return response($response->body(), 200)
        ->header('Content-Type', 'application/vnd.android.package-archive')
        ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
});

// WINDOWS (direct .exe download)
Route::get('/download/windows', function () {
    $url = 'https://www.hybridsolutions.com/downloads/vertexfx.exe';
    $fileName = 'vertexfx.exe';

    $response = Http::get($url);
    return response($response->body(), 200)
        ->header('Content-Type', 'application/octet-stream')
        ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
});

// IOS (redirect to App Store)
Route::get('/download/ios', function () {
    return redirect()->away('https://apps.apple.com/lk/app/vertexfx-trader/id1469388395');
});

use App\Http\Controllers\Admin\PromotionController;

Route::prefix('admin')->name('admin.')->group(function () {
    // List promotions
    Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');

    // Create new promotion
    Route::post('/promotions', [PromotionController::class, 'store'])->name('promotions.store');

    // Update promotion
    Route::patch('/promotions/{promotion}', [PromotionController::class, 'update'])->name('promotions.update');

    // Delete promotion
    Route::delete('/promotions/{promotion}', [PromotionController::class, 'destroy'])->name('promotions.destroy');

    // Toggle popup enabled/disabled
    Route::patch('/promotions/{promotion}/toggle', [PromotionController::class, 'toggle'])->name('promotions.toggle');
});



Route::get('/promotion', [PromotionController::class, 'show'])->name('promotion.show');

use App\Http\Controllers\Admin\PendingRegistrationController;

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/pending-registrations', [PendingRegistrationController::class, 'index'])->name('pending.index');
    Route::delete('/admin/pending-registrations/{id}', [PendingRegistrationController::class, 'destroy'])->name('pending.destroy');
});


use App\Services\NotifyService;

Route::get('/test-sms', function () {
    $notify = new NotifyService();

    $res = $notify->sendSMS("94774585861", "Test SMS from Laravel!");

    return $res;
});


Route::get('/admin/get-user-by-live-id/{live_id}', [AdminTransactionHistoryController::class, 'getUserByLiveId']);


Route::get('/mutualfunds', function () {
    return view('mutualfunds');
})->name('mutualfunds');
