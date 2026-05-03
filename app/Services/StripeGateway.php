<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\StripeException;

class StripeGateway
{
    /**
     * Initialize Stripe client with secret key
     *
     * @return void
     * @throws StripeException
     */
    private static function getClient(): void
    {
        static $initialized = false;
        
        if (!$initialized) {
            $secretKey = config('services.stripe.secret');
            if (!$secretKey) {
                throw new StripeException('Stripe secret key not configured. Please set STRIPE_SECRET in .env');
            }
            Stripe::setApiKey($secretKey);
            $initialized = true;
        }
    }

    /**
     * Create a PaymentIntent
     *
     * @param float $amount
     * @param string $currency
     * @param array $metadata
     * @param string|null $paymentMethodId
     * @return array
     */
    public static function createPaymentIntent(float $amount, string $currency = 'USD', array $metadata = [], ?string $paymentMethodId = null): array
    {
        self::getClient();

        try {
            // Amount must be in integer cents for most currencies
            $amountInCents = (int) round($amount * 100);

            $params = [
                'amount' => $amountInCents,
                'currency' => $currency,
                'metadata' => $metadata,
                'description' => 'Payment for order',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ];

            if ($paymentMethodId) {
                $params['payment_method'] = $paymentMethodId;
            }

            $paymentIntent = PaymentIntent::create($params);

            return [
                'success' => true,
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id,
                'payment_intent' => $paymentIntent,
            ];
        } catch (StripeException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Retrieve a PaymentIntent
     *
     * @param string $paymentIntentId
     * @return array
     */
    public static function retrievePaymentIntent(string $paymentIntentId): array
    {
        self::getClient();

        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            return [
                'success' => true,
                'payment_intent' => $paymentIntent,
            ];
        } catch (StripeException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Confirm a PaymentIntent with a payment method
     *
     * @param string $paymentIntentId
     * @param string|null $paymentMethodId
     * @return array
     */
    public static function confirmPaymentIntent(string $paymentIntentId, ?string $paymentMethodId = null): array
    {
        self::getClient();

        try {
            $params = [];
            if ($paymentMethodId) {
                $params['payment_method'] = $paymentMethodId;
            }

            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            $paymentIntent->confirm($params);

            return [
                'success' => true,
                'payment_intent' => $paymentIntent,
            ];
        } catch (StripeException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Cancel a PaymentIntent
     *
     * @param string $paymentIntentId
     * @return array
     */
    public static function cancelPaymentIntent(string $paymentIntentId): array
    {
        self::getClient();

        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            $paymentIntent->cancel();

            return [
                'success' => true,
                'payment_intent' => $paymentIntent,
            ];
        } catch (StripeException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
