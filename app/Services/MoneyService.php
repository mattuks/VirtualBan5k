<?php


namespace App\Services;
use Cknow\Money\Money;
use Money\Currency;

class MoneyService
{
    /**
     * @param $amount
     * @param Currency $currency
     * @return Money
     */
    public function createMoney($amount, Currency $currency): Money
    {
        return new Money($amount * 100, $currency);
    }

    /**
     * @param int $amount
     * @return float|int
     */
    public function parseToCents(int $amount)
    {
        return $amount * 100;
    }
}
