<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Webkul\Customer\Repositories\CustomerRepository;
use GraphQL\Error\Error;

class CustomerLoginMutation
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function __invoke($rootValue, array $args, $context, $info)
    {
        $input = $args['input'];
        
        $customer = $this->customerRepository->findOneByField('email', $input['email']);
        
        if (!$customer || !Hash::check($input['password'], $customer->password)) {
            throw new Error('Invalid credentials');
        }

        if (!$customer->status) {
            throw new Error('Your account is not active');
        }

        // Generate API token
        $token = $customer->createToken('API Token')->plainTextToken;

        return [
            'success' => true,
            'message' => 'Login successful',
            'accessToken' => $token,
            'tokenType' => 'Bearer',
            'expiresIn' => config('sanctum.expiration', 60 * 24), // 24 hours in minutes
            'customer' => $customer
        ];
    }
}