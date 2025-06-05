<?php

namespace App\GraphQL\Mutations;

use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;
use GraphQL\Error\Error;

class PlaceOrderMutation
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function __invoke($rootValue, array $args, $context, $info)
    {
        try {
            $cart = Cart::getCart();
            
            if (!$cart) {
                throw new Error('No active cart found');
            }

            // Save order
            $order = $this->orderRepository->create(Cart::prepareDataForOrder());

            Cart::deActivateCart();

            session()->flash('order', $order);

            return [
                'success' => true,
                'message' => 'Order placed successfully',
                'redirectUrl' => route('shop.checkout.success'),
                'selectedMethod' => $cart->payment->method ?? 'default',
                'order' => $order
            ];
        } catch (\Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}