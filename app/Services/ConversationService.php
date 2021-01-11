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
    public function convertMoney(Money $money, Currency $currency): Money
    {
        return new Money($this->convert($money->getAmount(), $money->getCurrency()->getCode(), $currency->getCode()), $currency);
    }

    /**
     * @param $amount
     * @param $from
     * @param $to
     * @return float|int
     */
    private function convert($amount, $from, $to)
    {

        if ($from !== config('currencies.main')) {
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
    private function convertToEuro(int $amount, string $currency)
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
    private function convertFromEuro(int $amount, string $currency)
    {
        foreach (config('currencies.rates') as $key => $value) {
            if ($key === $currency) {
                return $amount * $value;
            }
        }
    }
}
