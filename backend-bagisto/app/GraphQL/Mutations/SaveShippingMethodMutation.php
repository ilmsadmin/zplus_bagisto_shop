<?php

namespace App\GraphQL\Mutations;

use Webkul\Checkout\Facades\Cart;
use GraphQL\Error\Error;

class SaveShippingMethodMutation
{
    public function __invoke($rootValue, array $args, $context, $info)
    {
        $input = $args['input'];
        
        try {
            $cart = Cart::getCart();
            
            if (!$cart) {
                throw new Error('No active cart found');
            }

            Cart::saveShippingMethod($input['shippingMethod']);

            return [
                'success' => true,
                'message' => 'Shipping method saved successfully',
                'cart' => Cart::getCart(),
                'jumpToSection' => 'payment'
            ];
        } catch (\Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}