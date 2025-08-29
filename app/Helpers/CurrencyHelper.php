<?php

use Illuminate\Support\Facades\Session;

if (!function_exists('show_price')) {
    /**
     * Return price according to session currency
     *
     * @param mixed $item       Number, Model, or array
     * @param bool  $formatted  Whether to include currency symbol
     * @return string|float
     */
    function show_price($item, bool $formatted = true)
    {
        $currency = Session::get('currency', 'USD');

        if (is_numeric($item)) {
            $price = $item;
        } elseif (is_object($item)) {
            $price = $currency === 'RMB' ? ($item->price_rmb ?? 0) : ($item->price ?? 0);
        } elseif (is_array($item)) {
            $price = $currency === 'RMB' ? ($item['price_rmb'] ?? 0) : ($item['price'] ?? 0);
        } else {
            $price = 0;
        }

        if ($formatted) {
            $symbol = $currency === 'RMB' ? '¥' : '$';
            return $symbol . number_format($price, 2);
        }

        return $price;
    }
}

if (!function_exists('show_price_range')) {
    /**
     * Return min-max price string for a collection of variants
     *
     * @param \Illuminate\Support\Collection|array $variants
     * @param bool $formatted
     * @return string
     */
    function show_price_range($variants, bool $formatted = true)
    {
        if (empty($variants)) return '';

        $currency = Session::get('currency', 'USD');

        $prices = collect($variants)->map(function ($variant) use ($currency) {
            return $currency === 'RMB'
                ? ($variant->price_rmb ?? 0)
                : ($variant->price ?? 0);
        });

        $min = $prices->min();
        $max = $prices->max();

        if ($formatted) {
            $symbol = $currency === 'RMB' ? '¥' : '$';
            return $symbol . number_format($min, 2) . ' - ' . $symbol . number_format($max, 2);
        }

        return $min . ' - ' . $max;
    }
}
