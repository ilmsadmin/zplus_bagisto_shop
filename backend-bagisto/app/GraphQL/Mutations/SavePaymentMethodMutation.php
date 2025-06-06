<?php

namespace App\GraphQL\Mutations;

use Webkul\Checkout\Facades\Cart;
use GraphQL\Error\Error;

class SavePaymentMethodMutation
{
    public function __invoke($rootValue, array $args, $context, $info)
    {
        $input = $args['input'];
        
        try {
            $cart = Cart::getCart();
            
            if (!$cart) {
                throw new Error('No active cart found');
            }

            $paymentData = [
                'method' => $input['method'],
                'method_title' => $input['methodTitle'] ?? $input['method'],
            ];

            if (isset($input['additional'])) {
                $paymentData['additional'] = json_decode($input['additional'], true);
            }

            Cart::savePaymentMethod($paymentData);

            return [
                'success' => true,
                'message' => 'Payment method saved successfully',
                'cart' => Cart::getCart(),
                'jumpToSection' => 'review'
            ];
        } catch (\Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}