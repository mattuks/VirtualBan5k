<?php


namespace App\Services;


use App\Currency;
use Cknow\Money\Money;
use Money\Currency as MoneyCurrency;

class ConversationService
{



    /**
     * @param int $amount
     * @param string $fromCurrency
     * @param string $toCurrency
     * @return float|int
     */
    public function convert(int $amount, string $fromCurrency, string $toCurrency)
    {
        if (isMainCurrency($fromCurrency)) {
            return $this->convertFromEuro($amount, $this->getRate($toCurrency));
        } else {
            return $this->convertFromEuro($this->convertToEuro($amount, $this->getRate($fromCurrency)), $this->getRate($toCurrency));
        }
    }

    /**
     * @param int $amount
     * @param float $rate
     * @return float|int
     */
    public function convertToEuro(int $amount, float $rate)
    {
        return $amount / $rate;
    }

    /**
     * @param int $amount
     * @param float $rate
     * @return float|int
     */
    public function convertFromEuro(int $amount, float $rate)
    {
        return $amount * $rate;
    }

    /**
     * @param string $currency
     * @return mixed
     */
    public function getRate(string $currency)
    {
        return Currency::all()->where('currency', $currency)->first()->getRate();
    }

    /**
     * @param Money $money
     * @param MoneyCurrency $currency
     * @return Money
     */
    public function convertMoney(Money $money, MoneyCurrency $currency): Money
    {
        return new Money($this->convert($money->getAmount(), $money->getCurrency()->getCode(), $currency->getCode()), $currency);
    }


}
