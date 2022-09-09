<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});


Route::get('dashboard',[App\Http\Controllers\HomeController::class,'Index'])->name('dashboard');

Route::get('members',[App\Http\Controllers\MemberController::class,'Index'])->name('memberManage');
Route::get('memberadd',[App\Http\Controllers\MemberController::class,'Show'])->name('memberAdd');
Route::post('memberadd',[App\Http\Controllers\MemberController::class,'Create'])->name('memberAdd');
Route::get('memberedit/{society_id}/{customer_id}',[App\Http\Controllers\MemberController::class,'Edit'])->name('memberEdit');
Route::post('memberupdate',[App\Http\Controllers\MemberController::class,'Update'])->name('memberUpdate');
Route::get('memberclose/{society_id}/{customer_id}',[App\Http\Controllers\MemberController::class,'ShowClose'])->name('memberClose');
Route::post('member_close',[App\Http\Controllers\MemberController::class,'Close'])->name('memberCloseConfirm');
Route::post('memberDeleteAjax',[App\Http\Controllers\MemberController::class,'Delete'])->name('memberDeleteAjax');

Route::get('supplier',[App\Http\Controllers\SupplierController::class,'Index'])->name('supplierManage');
Route::get('supplieradd',[App\Http\Controllers\SupplierController::class,'Show'])->name('supplierAdd');
Route::post('supplieradd',[App\Http\Controllers\SupplierController::class,'Create'])->name('supplierCreate');
Route::get('supplieredit/{id}',[App\Http\Controllers\SupplierController::class,'Edit'])->name('supplierEdit');
Route::post('supplieredit',[App\Http\Controllers\SupplierController::class,'Update'])->name('supplierUpdate');

Route::get('category',[App\Http\Controllers\ProductCategoryController::class,'Index'])->name('categoryManage');
Route::get('categoryadd',[App\Http\Controllers\ProductCategoryController::class,'Show'])->name('categoryAdd');
Route::post('categoryadd',[App\Http\Controllers\ProductCategoryController::class,'Create'])->name('categoryCreate');
Route::get('categoryedit/{id}',[App\Http\Controllers\ProductCategoryController::class,'Edit'])->name('categoryEdit');
Route::post('categoryedit',[App\Http\Controllers\ProductCategoryController::class,'Update'])->name('categoryUpdate');

Route::get('product',[App\Http\Controllers\ProductController::class,'Index'])->name('productManage');
Route::get('productadd',[App\Http\Controllers\ProductController::class,'Show'])->name('productAdd');
Route::post('productadd',[App\Http\Controllers\ProductController::class,'Create'])->name('productCreate');
Route::get('productedit/{id}',[App\Http\Controllers\ProductController::class,'Edit'])->name('productEdit');
Route::post('productedit',[App\Http\Controllers\ProductController::class,'Update'])->name('productUpdate');

Route::get('productrate',[App\Http\Controllers\ProductRateController::class,'Index'])->name('productrateManage');
Route::get('productrateadd',[App\Http\Controllers\ProductRateController::class,'Show'])->name('productrateAdd');
Route::post('productrateadd',[App\Http\Controllers\ProductRateController::class,'Create'])->name('productrateCreate');
Route::get('productrateedit/{id}',[App\Http\Controllers\ProductRateController::class,'Edit'])->name('productrateEdit');
Route::post('productrateedit',[App\Http\Controllers\ProductRateController::class,'Update'])->name('productrateUpdate');


Route::get('purchase',[App\Http\Controllers\PurchaseController::class,'Index'])->name('purchaseManage');
Route::get('purchaseadd',[App\Http\Controllers\PurchaseController::class,'Show'])->name('purchaseAdd');
Route::post('purchaseadd',[App\Http\Controllers\PurchaseController::class,'Create'])->name('purchaseCreate');
Route::get('purchaseedit/{id}',[App\Http\Controllers\PurchaseController::class,'Edit'])->name('purchaseEdit');
Route::post('purchaseedit',[App\Http\Controllers\PurchaseController::class,'Update'])->name('purchaseUpdate');
Route::post('productRateAjax',[App\Http\Controllers\PurchaseController::class,'RateAjax'])->name('productRateAjax');


Route::get('payment',[App\Http\Controllers\PaymentController::class,'Index'])->name('paymentManage');
Route::get('paymentadd',[App\Http\Controllers\PaymentController::class,'Show'])->name('paymentAdd');
Route::post('paymentadd',[App\Http\Controllers\PaymentController::class,'Create'])->name('paymentCreate');
Route::get('paymentedit/{id}',[App\Http\Controllers\PaymentController::class,'Edit'])->name('paymentEdit');
Route::post('paymentedit',[App\Http\Controllers\PaymentController::class,'Update'])->name('paymentUpdate');
// Route::post('productRateAjax',[App\Http\Controllers\PaymentController::class,'RateAjax'])->name('productRateAjax');

Route::get('sale',[App\Http\Controllers\SaleController::class,'Index'])->name('saleManage');
Route::get('saleadd',[App\Http\Controllers\SaleController::class,'Show'])->name('saleAdd');
Route::post('saleadd',[App\Http\Controllers\SaleController::class,'Create'])->name('saleCreate');
Route::get('saleedit/{id}',[App\Http\Controllers\SaleController::class,'Edit'])->name('saleEdit');
Route::post('saleedit',[App\Http\Controllers\SaleController::class,'Update'])->name('saleUpdate');
Route::post('productStockAjax',[App\Http\Controllers\SaleController::class,'SaleStockProductAjax'])->name('productStockAjax');

Route::get('receive',[App\Http\Controllers\ReceivedController::class,'Index'])->name('receiveManage');
Route::get('receiveadd',[App\Http\Controllers\ReceivedController::class,'Show'])->name('receiveAdd');
Route::post('receiveadd',[App\Http\Controllers\ReceivedController::class,'Create'])->name('receiveCreate');
Route::get('receiveedit/{id}',[App\Http\Controllers\ReceivedController::class,'Edit'])->name('receiveEdit');
Route::post('receiveedit',[App\Http\Controllers\ReceivedController::class,'Update'])->name('receiveUpdate');
