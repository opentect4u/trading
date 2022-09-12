<?php

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
    // return view('welcome');
    return redirect()->route('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// require __DIR__.'/auth.php';

Route::get('/admin', function () {
    return redirect()->route('admin.login');
});
Route::group(['prefix'=>'admin','as'=>'admin.'],function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('register', [App\Http\Controllers\Admin\Auth\RegisteredUserController::class, 'create'])->name('register');
        Route::post('register', [App\Http\Controllers\Admin\Auth\RegisteredUserController::class, 'store']);
        Route::get('login', [App\Http\Controllers\Admin\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [App\Http\Controllers\Admin\Auth\AuthenticatedSessionController::class, 'store'])->name('loginConfirm');
        Route::get('forgot-password', [App\Http\Controllers\Admin\Auth\PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [App\Http\Controllers\Admin\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
        Route::get('reset-password/{token}', [App\Http\Controllers\Admin\Auth\NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [App\Http\Controllers\Admin\Auth\NewPasswordController::class, 'store'])->name('password.update');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('verify-email', [App\Http\Controllers\Admin\Auth\EmailVerificationPromptController::class, '__invoke'])
                    ->name('verification.notice');
        Route::get('verify-email/{id}/{hash}', [App\Http\Controllers\Admin\Auth\VerifyEmailController::class, '__invoke'])
                    ->middleware(['signed', 'throttle:6,1'])
                    ->name('verification.verify');
        Route::post('email/verification-notification', [App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController::class, 'store'])
                    ->middleware('throttle:6,1')
                    ->name('verification.send');
        Route::get('confirm-password', [App\Http\Controllers\Admin\Auth\ConfirmablePasswordController::class, 'show'])
                    ->name('password.confirm');
        Route::post('confirm-password', [App\Http\Controllers\Admin\Auth\ConfirmablePasswordController::class, 'store']);
        Route::post('logout', [App\Http\Controllers\Admin\Auth\AuthenticatedSessionController::class, 'destroy'])
                    ->name('logout');
    });

    
    Route::get('dashboard', [App\Http\Controllers\Admin\HomeController::class, 'Index'])->name('dashboard');
});
