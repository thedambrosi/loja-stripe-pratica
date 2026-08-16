<?php

use App\Models\Product;

test('the catalog lists the available products', function () {
    $products = Product::factory()->count(3)->create();

    $response = $this->get(route('home'));

    $response->assertOk();

    foreach ($products as $product) {
        $response->assertSee($product->name);
    }
});
