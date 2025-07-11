<?php

namespace App\Services;

use Braintree\Gateway;

class BraintreeGateway
{
    public static function getGateway()
    {
        return new Gateway([
            'environment' => env('BRAINTREE_ENVIRONMENT'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);
    }
    
}
