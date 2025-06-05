<?php

namespace ZPlus\ViPOS\Http\Controllers;

use Illuminate\Http\Request;
use Webkul\Customer\Repositories\CustomerRepository;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected CustomerRepository $customerRepository
    ) {}

    /**
     * Search customers for POS.
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        $customers = $this->customerRepository->where('status', 1)
                        ->where(function ($query) use ($request) {
                            $query->where('first_name', 'like', '%' . $request->query . '%')
                                  ->orWhere('last_name', 'like', '%' . $request->query . '%')
                                  ->orWhere('email', 'like', '%' . $request->query . '%')
                                  ->orWhere('phone', 'like', '%' . $request->query . '%');
                        })
                        ->limit(10)
                        ->get(['id', 'first_name', 'last_name', 'email', 'phone']);

        return response()->json(['data' => $customers]);
    }

    /**
     * Get customer details.
     */
    public function show($id)
    {
        $customer = $this->customerRepository->with(['addresses'])
                                           ->find($id);

        if (! $customer) {
            return response()->json([
                'error' => 'Customer not found',
            ], 404);
        }

        return response()->json(['data' => $customer]);
    }

    /**
     * Create a new customer for POS.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
        ]);

        $customer = $this->customerRepository->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt('password'), // Default password for POS created customers
            'status' => 1,
            'is_verified' => 1,
        ]);

        return response()->json([
            'data' => $customer,
            'message' => 'Customer created successfully',
        ], 201);
    }
}