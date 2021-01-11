<?php

namespace App\Services;

use App\Currency;
use App\Factories\CurrencyFactory;

/**
 * Class CurrencyService
 * @package App\Services
 */
class CurrencyService
{
    /**
     * @param array $data
     * @return Currency
     */
    public function create(array $data): Currency
    {
        return CurrencyFactory::create($data);
    }

    /**
     * @param array $data
     * @return Currency
     */
    public function createAndSave(array $data): Currency
    {
        $currency = CurrencyFactory::create($data);
        $currency->save();

        return $currency;
    }

    /**
     * @param Currency $currency
     * @param float $rate
     * @return Currency
     */
    public function setRateAndSave(Currency $currency, float $rate): Currency
    {
        $currency->setRate($rate)->save();

        return $currency;
    }
}
