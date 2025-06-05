<?php

namespace App\GraphQL\Mutations;

use Webkul\Checkout\Facades\Cart;
use GraphQL\Error\Error;

class RemoveFromCartMutation
{
    public function __invoke($rootValue, array $args, $context, $info)
    {
        $input = $args['input'];
        
        try {
            Cart::removeItem($input['cartItemId']);
            Cart::collectTotals();

            return [
                'success' => true,
                'message' => 'Item removed from cart successfully',
                'cart' => Cart::getCart()
            ];
        } catch (\Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}