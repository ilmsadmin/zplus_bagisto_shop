<?php

namespace App\GraphQL\Queries;

use Webkul\Payment\Facades\Payment;

class PaymentMethodsQuery
{
    public function __invoke($rootValue, array $args, $context, $info)
    {
        return Payment::getPaymentMethods();
    }
}