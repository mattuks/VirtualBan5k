<?php


namespace App\Services;
use Cknow\Money\Money;
use Money\Currency;

class MoneyService
{
    public function createMoney($amount, Currency $currency)
    {
        return new Money($amount * 100, $currency);
    }
}
