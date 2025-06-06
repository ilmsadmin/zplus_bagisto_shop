<?php

namespace App\GraphQL\Mutations;

use Webkul\Checkout\Facades\Cart;
use GraphQL\Error\Error;

class SaveShippingAddressMutation
{
    public function __invoke($rootValue, array $args, $context, $info)
    {
        $input = $args['input'];
        
        try {
            $cart = Cart::getCart();
            
            if (!$cart) {
                throw new Error('No active cart found');
            }

            // Prepare address data
            $addressData = [
                'billing' => [
                    'first_name' => $input['firstName'],
                    'last_name' => $input['lastName'],
                    'email' => $input['email'] ?? $cart->customer_email,
                    'address1' => $input['address1'],
                    'country' => $input['country'],
                    'state' => $input['state'],
                    'city' => $input['city'],
                    'postcode' => $input['postcode'],
                    'phone' => $input['phone'],
                ],
                'shipping' => [
                    'first_name' => $input['firstName'],
                    'last_name' => $input['lastName'],
                    'email' => $input['email'] ?? $cart->customer_email,
                    'address1' => $input['address1'],
                    'country' => $input['country'],
                    'state' => $input['state'],
                    'city' => $input['city'],
                    'postcode' => $input['postcode'],
                    'phone' => $input['phone'],
                ]
            ];

            if (isset($input['address2'])) {
                $addressData['billing']['address2'] = $input['address2'];
                $addressData['shipping']['address2'] = $input['address2'];
            }

            if (isset($input['companyName'])) {
                $addressData['billing']['company_name'] = $input['companyName'];
                $addressData['shipping']['company_name'] = $input['companyName'];
            }

            Cart::saveCustomerAddress($addressData);

            return [
                'success' => true,
                'message' => 'Address saved successfully',
                'cart' => Cart::getCart(),
                'jumpToSection' => 'shipping'
            ];
        } catch (\Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}