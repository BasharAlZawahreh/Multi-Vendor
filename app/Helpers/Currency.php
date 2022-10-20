<?php

namespace App\Helpers;

class Currency
{

    public static function format($amount, $currency = null)
    {
        if (!$currency) {
            $currency =config('app.currency','USD');
        }

        $formatter = new \NumberFormatter(config('app.locale'), \NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, $currency);
    }
}
