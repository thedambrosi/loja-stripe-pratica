<?php

use App\Enums\OrderStatus;
use App\Models\Product;
use Illuminate\Support\Str;
use Stripe\ApiRequestor;
use Stripe\HttpClient\ClientInterface;

beforeEach(function () {
    config(['services.stripe.secret' => 'sk_test_fake']);
});

afterEach(function () {
    ApiRequestor::setHttpClient(null);
});

test('checkout creates a pending order and redirects to the stripe checkout url', function () {
    $product = Product::factory()->create(['price_cents' => 5000]);

    $sessionId = 'cs_test_'.Str::random(24);
    $checkoutUrl = "https://checkout.stripe.com/c/pay/{$sessionId}";

    $fakeHttpClient = Mockery::mock(ClientInterface::class);
    $fakeHttpClient->shouldReceive('request')->once()->andReturn([
        json_encode([
            'id' => $sessionId,
            'object' => 'checkout.session',
            'mode' => 'payment',
            'status' => 'open',
            'payment_status' => 'unpaid',
            'url' => $checkoutUrl,
        ]),
        200,
        [],
    ]);
    ApiRequestor::setHttpClient($fakeHttpClient);

    $response = $this->post(route('checkout.store', $product), [
        'customer_email' => 'buyer@example.com',
    ]);

    $response->assertRedirect($checkoutUrl);

    $this->assertDatabaseHas('orders', [
        'product_id' => $product->id,
        'customer_email' => 'buyer@example.com',
        'stripe_session_id' => $sessionId,
        'status' => OrderStatus::Pending->value,
    ]);
});

test('checkout requires a customer email', function () {
    $product = Product::factory()->create();

    $response = $this->post(route('checkout.store', $product), []);

    $response->assertSessionHasErrors('customer_email');
    $this->assertDatabaseCount('orders', 0);
});
