<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\Auth;

class CustomerQuery
{
    public function __invoke($rootValue, array $args, $context, $info)
    {
        return Auth::guard('customer')->user();
    }
}