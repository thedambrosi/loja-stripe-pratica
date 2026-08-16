<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Stripe\WebhookSignature;

beforeEach(function () {
    config(['services.stripe.webhook_secret' => 'whsec_test_secret']);
});

function checkoutCompletedPayload(string $sessionId): array
{
    return [
        'id' => 'evt_test_123',
        'object' => 'event',
        'type' => 'checkout.session.completed',
        'data' => [
            'object' => [
                'id' => $sessionId,
                'object' => 'checkout.session',
            ],
        ],
    ];
}

test('a webhook with a valid signature marks the order as paid', function () {
    $order = Order::factory()->create(['status' => OrderStatus::Pending]);

    $data = checkoutCompletedPayload($order->stripe_session_id);
    $signature = WebhookSignature::generateSignatureHeader(json_encode($data), config('services.stripe.webhook_secret'));

    $response = $this->postJson(route('stripe.webhook'), $data, [
        'Stripe-Signature' => $signature,
    ]);

    $response->assertOk();

    expect($order->fresh()->status)->toBe(OrderStatus::Paid);
});

test('a webhook with an invalid signature is rejected and the order stays pending', function () {
    $order = Order::factory()->create(['status' => OrderStatus::Pending]);

    $data = checkoutCompletedPayload($order->stripe_session_id);

    $response = $this->postJson(route('stripe.webhook'), $data, [
        'Stripe-Signature' => 't=1234567890,v1=forged-signature',
    ]);

    $response->assertStatus(400);

    expect($order->fresh()->status)->toBe(OrderStatus::Pending);
});
