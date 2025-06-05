<?php

namespace App\GraphQL\Mutations;

use Webkul\Checkout\Facades\Cart;

class CreateCartMutation
{
    public function __invoke($rootValue, array $args, $context, $info)
    {
        $cart = Cart::getCart();
        
        if (!$cart) {
            Cart::collectTotals();
            $cart = Cart::getCart();
        }
        
        return $cart;
    }
}