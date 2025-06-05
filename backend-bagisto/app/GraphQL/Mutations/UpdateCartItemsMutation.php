<?php

namespace App\GraphQL\Mutations;

use Webkul\Checkout\Facades\Cart;
use GraphQL\Error\Error;

class UpdateCartItemsMutation
{
    public function __invoke($rootValue, array $args, $context, $info)
    {
        $input = $args['input'];
        
        try {
            foreach ($input['items'] as $item) {
                Cart::updateItem($item['cartItemId'], $item['quantity']);
            }
            
            Cart::collectTotals();

            return [
                'success' => true,
                'message' => 'Cart updated successfully',
                'cart' => Cart::getCart()
            ];
        } catch (\Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}