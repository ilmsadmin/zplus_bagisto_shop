<?php

namespace App\GraphQL\Queries;

use Webkul\Shipping\Facades\Shipping;

class ShippingMethodsQuery
{
    public function __invoke($rootValue, array $args, $context, $info)
    {
        return Shipping::collectRates();
    }
}