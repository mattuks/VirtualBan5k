<?php


namespace App\Services;


use Cknow\Money\Money;
use Money\Currency;

class ConversationService
{
    /**
     * @param Money $money
     * @param Currency $currency
     * @return Money
     */
    public  function convertMoney(Money $money, Currency $currency)
    {
        return new Money($this->convert($money->getAmount(), $money->getCurrency()->getCode(), $currency->getCode()), $currency);
    }

    /**
     * @param $amount
     * @param $from
     * @param $to
     * @return float|int
     */
    public function convert($amount, $from, $to)
    {

        if ($from !== 'EUR') {
            return $this->convertFromEuro($this->convertToEuro($amount, $from), $to);
        } else {
            return $this->convertFromEuro($amount, $to);
        }
    }

    /**
     * @param $amount
     * @param $currency
     * @return float|int
     */
    public function convertToEuro(int $amount, string $currency)
    {
        foreach (config('currencies.rates') as $key => $value) {
            if ($key === $currency) {
                return $amount / $value;
            }
        }
    }

    /**
     * @param $amount
     * @param $currency
     * @return float|int
     */
    public function convertFromEuro(int $amount, string $currency)
    {
        foreach (config('currencies.rates') as $key => $value) {
            if ($key === $currency) {
                return $amount * $value;
            }
        }
    }

}
