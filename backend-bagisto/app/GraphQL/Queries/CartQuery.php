<?php

namespace App\GraphQL\Queries;

use Webkul\Checkout\Facades\Cart;

class CartQuery
{
    public function __invoke($rootValue, array $args, $context, $info)
    {
        Cart::collectTotals();
        
        return Cart::getCart();
    }
}