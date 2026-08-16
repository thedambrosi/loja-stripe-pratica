<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'customer_email' => ['required', 'email'],
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'mode' => 'payment',
            'customer_email' => $validated['customer_email'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'brl',
                        'product_data' => [
                            'name' => $product->name,
                        ],
                        'unit_amount' => $product->price_cents,
                    ],
                    'quantity' => 1,
                ],
            ],
            'success_url' => route('checkout.success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
        ]);

        Order::create([
            'product_id' => $product->id,
            'customer_email' => $validated['customer_email'],
            'stripe_session_id' => $session->id,
            'status' => OrderStatus::Pending,
        ]);

        return redirect()->away($session->url);
    }

    public function success(): View
    {
        return view('checkout.success');
    }

    public function cancel(): View
    {
        return view('checkout.cancel');
    }
}
