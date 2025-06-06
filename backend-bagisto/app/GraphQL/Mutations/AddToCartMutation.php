<?php

namespace App\GraphQL\Mutations;

use Webkul\Checkout\Facades\Cart;
use Webkul\Product\Repositories\ProductRepository;
use GraphQL\Error\Error;

class AddToCartMutation
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke($rootValue, array $args, $context, $info)
    {
        $input = $args['input'];
        
        $product = $this->productRepository->find($input['productId']);
        
        if (!$product) {
            throw new Error('Product not found');
        }

        try {
            $cartData = [
                'product_id' => $input['productId'],
                'quantity' => $input['quantity'],
            ];

            if (isset($input['options'])) {
                $cartData['options'] = json_decode($input['options'], true);
            }

            Cart::addProduct($input['productId'], $cartData);
            Cart::collectTotals();

            return [
                'success' => true,
                'message' => 'Product added to cart successfully',
                'cart' => Cart::getCart()
            ];
        } catch (\Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}