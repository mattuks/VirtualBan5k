<?php

namespace App\Services;

use App\Currency;
use Cknow\Money\Money;
use Money\Currency as MoneyCurrency;

class ConversationService
{
    /**
     * @param Money $money
     * @param MoneyCurrency $currency
     * @return Money
     */
    public function convertMoney(Money $money, MoneyCurrency $currency): Money
    {
        return new Money($this->convert($money->getAmount(), $money->getCurrency()->getCode(), $currency->getCode()),
            $currency);
    }

    /**
     * @param int $amount
     * @param string $fromCurrency
     * @param string $toCurrency
     * @return float|int
     */
    public function convert(int $amount, string $fromCurrency, string $toCurrency): float
    {
        /** @var Currency $currencyModel */
        $currencyModel = app(Currency::class);
        if (isMainCurrency($fromCurrency)) {
            return $this->convertFromEuro($amount, $currencyModel->getRateByIsoCode($toCurrency));
        } else {
            return $this->convertFromEuro($this->convertToEuro($amount,
                $currencyModel->getRateByIsoCode($fromCurrency)), $currencyModel->getRateByIsoCode($toCurrency));
        }
    }

    /**
     * @param int $amount
     * @param float $rate
     * @return float|int
     */
    public function convertToEuro(int $amount, float $rate): float
    {
        return $amount / $rate;
    }

    /**
     * @param int $amount
     * @param float $rate
     * @return float|int
     */
    public function convertFromEuro(int $amount, float $rate): float
    {
        return $amount * $rate;
    }
}
