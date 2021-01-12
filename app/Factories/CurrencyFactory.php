<?php

namespace App\Factories;

use App\Currency;

/**
 * Class CurrencyFactory
 * @package App\Factories
 */
class CurrencyFactory
{
    /**
     * @param array $data
     * @return Currency
     */
    public static function create(array $data): Currency
    {
        $currency = new Currency();
        $currency->setIsoCode($data['iso_code']);
        $currency->setRate($data['rate']);

        return $currency;
    }
}