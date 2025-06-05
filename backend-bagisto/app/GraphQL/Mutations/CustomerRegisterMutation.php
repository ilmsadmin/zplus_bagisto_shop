<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Hash;
use Webkul\Customer\Repositories\CustomerRepository;
use GraphQL\Error\Error;

class CustomerRegisterMutation
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function __invoke($rootValue, array $args, $context, $info)
    {
        $input = $args['input'];
        
        // Check if passwords match
        if ($input['password'] !== $input['passwordConfirmation']) {
            throw new Error('Password confirmation does not match');
        }

        // Check if email already exists
        if ($this->customerRepository->findOneByField('email', $input['email'])) {
            throw new Error('Email already exists');
        }

        // Create customer
        $customer = $this->customerRepository->create([
            'first_name' => $input['firstName'],
            'last_name' => $input['lastName'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'is_verified' => 1,
            'customer_group_id' => core()->getDefaultCustomerGroup()->id,
            'subscribed_to_news_letter' => $input['subscribedToNewsLetter'] ?? false,
        ]);

        return [
            'success' => true,
            'message' => 'Registration successful',
            'customer' => $customer
        ];
    }
}