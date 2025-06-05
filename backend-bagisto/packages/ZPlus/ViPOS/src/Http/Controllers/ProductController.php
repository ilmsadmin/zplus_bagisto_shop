<?php

namespace ZPlus\ViPOS\Http\Controllers;

use Illuminate\Http\Request;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Category\Repositories\CategoryRepository;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected ProductRepository $productRepository,
        protected CategoryRepository $categoryRepository
    ) {}

    /**
     * Get products for POS.
     */
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $products = $this->productRepository->where('status', 1);

        if ($request->search) {
            $products = $products->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category_id) {
            $products = $products->whereHas('categories', function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            });
        }

        $products = $products->with(['images', 'inventory_indices'])
                           ->paginate($request->per_page ?? 20);

        return response()->json([
            'data' => $products->items(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }

    /**
     * Get product by ID, SKU, or barcode.
     */
    public function show(Request $request, $identifier)
    {
        $product = $this->productRepository->where('id', $identifier)
                        ->orWhere('sku', $identifier)
                        ->with(['images', 'inventory_indices'])
                        ->first();

        if (! $product) {
            return response()->json([
                'error' => 'Product not found',
            ], 404);
        }

        return response()->json(['data' => $product]);
    }

    /**
     * Get categories for POS.
     */
    public function categories()
    {
        $categories = $this->categoryRepository->where('status', 1)
                                              ->orderBy('sort_order')
                                              ->get(['id', 'name', 'slug']);

        return response()->json(['data' => $categories]);
    }
}