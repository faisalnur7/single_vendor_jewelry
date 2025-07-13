<?php

namespace App\Services;

use Braintree\Gateway;

class BraintreeGateway
{
    public static function getGateway()
    {
        $variables = [
            'environment' => config('braintree.environment'),
            'merchantId' => config('braintree.merchantId'),
            'publicKey' => config('braintree.publicKey'),
            'privateKey' => config('braintree.privateKey'),
        ];
        return new Gateway($variables);
    }
    
}
