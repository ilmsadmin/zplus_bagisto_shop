<?php

namespace ZPlus\ViPOS\Http\Controllers;

use Illuminate\Http\Request;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Product\Repositories\ProductRepository;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected CustomerRepository $customerRepository,
        protected ProductRepository $productRepository
    ) {}

    /**
     * Create a new order from POS.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,card,upi,bank_transfer',
            'payment_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $customer = $this->customerRepository->find($request->customer_id);
            
            // Calculate totals
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            
            $taxAmount = $subtotal * (config('vipos.tax.default_rate') / 100);
            $grandTotal = $subtotal + $taxAmount;

            // Create order data
            $orderData = [
                'customer_id' => $customer->id,
                'customer_email' => $customer->email,
                'customer_first_name' => $customer->first_name,
                'customer_last_name' => $customer->last_name,
                'status' => 'processing',
                'channel_name' => 'ViPOS',
                'is_guest' => 0,
                'currency_code' => core()->getBaseCurrencyCode(),
                'base_currency_code' => core()->getBaseCurrencyCode(),
                'grand_total' => $grandTotal,
                'base_grand_total' => $grandTotal,
                'sub_total' => $subtotal,
                'base_sub_total' => $subtotal,
                'tax_amount' => $taxAmount,
                'base_tax_amount' => $taxAmount,
                'items_count' => count($request->items),
                'items_qty' => array_sum(array_column($request->items, 'quantity')),
            ];

            // Add items data
            $orderData['items'] = [];
            foreach ($request->items as $item) {
                $product = $this->productRepository->find($item['product_id']);
                $orderData['items'][] = [
                    'product_id' => $product->id,
                    'sku' => $product->sku,
                    'name' => $product->name,
                    'price' => $item['price'],
                    'base_price' => $item['price'],
                    'total' => $item['price'] * $item['quantity'],
                    'base_total' => $item['price'] * $item['quantity'],
                    'qty_ordered' => $item['quantity'],
                    'product_type' => $product->type,
                ];
            }

            // Create the order
            $order = $this->orderRepository->create($orderData);

            return response()->json([
                'data' => $order,
                'message' => 'Order created successfully',
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create order: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get order details.
     */
    public function show($id)
    {
        $order = $this->orderRepository->with(['items', 'customer'])
                                     ->find($id);

        if (! $order) {
            return response()->json([
                'error' => 'Order not found',
            ], 404);
        }

        return response()->json(['data' => $order]);
    }

    /**
     * Get recent orders from POS.
     */
    public function recent()
    {
        $orders = $this->orderRepository->where('channel_name', 'ViPOS')
                                      ->with(['customer'])
                                      ->orderBy('created_at', 'desc')
                                      ->limit(10)
                                      ->get();

        return response()->json(['data' => $orders]);
    }
}