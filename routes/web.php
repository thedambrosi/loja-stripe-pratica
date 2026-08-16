<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::post('checkout/{product}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('checkout/sucesso', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('checkout/cancelado', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

Route::post('stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
