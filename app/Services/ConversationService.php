<?php


namespace App\Services;
use Cknow\Money\Money;
use Money\Currency;

class ConversationService
{
    /**
     * @param Money $sell
     * @param Money $buy
     * @return Money
     */
    public function convert(Money $sell, Money $buy)
    {
        $a = $sell->getCurrency()->getCode();
        $b = $buy->getCurrency()->getCode();

        if ($a === 'USD' && $b === 'EUR'){
            return $this->usdToEur($sell);
        }elseif ($a === 'USD' && $b === 'GBP'){
           return $this->usdToGbp($sell);
        }elseif ($a === 'EUR' && $b === 'USD'){
           return $this->eurToUsd($sell);
        }elseif ($a === 'EUR' && $b === 'GBP'){
          return $this->eurToGbp($sell);
        }elseif ($a === 'GBP' && $b === 'EUR'){
           return $this->gbpToEur($sell);
        }elseif ($a === 'GBP' && $b === 'USD'){
           return $this->gbpToUsd($sell);
        };

}

    /**
     * @param Money $money
     * @return Money
     */
    public function eurToUsd(Money $money)
    {
        $money = new Money($money->getAmount() * 1.23 , new Currency('USD'));
        return $money;
    }

    /**
     * @param Money $money
     * @return Money
     */
    public function eurToGbp(Money $money)
    {
        $money = new Money($money->getAmount() * 0.90 , new Currency('GBP'));
        return $money;
    }
    /**
     * @param Money $money
     * @return Money
     */
    public function usdToEur(Money $money)
    {
        $money = new Money($money->getAmount() * 0.81 , new Currency('USD'));
        return $money;
    }

    /**
     * @param Money $money
     * @return Money
     */
    public function usdToGbp(Money $money)
    {
        $money = new Money($money->getAmount() * 0.73 , new Currency('GBP'));
        return $money;
    }

        /**
     * @param Money $money
     * @return Money
     */
    public function gbpToEur(Money $money)
    {
        $money = new Money($money->getAmount() * 1.11 , new Currency('USD'));
        return $money;
    }

    /**
     * @param Money $money
     * @return Money
     */
    public function gbpToUsd(Money $money)
    {
        $money = new Money($money->getAmount() * 1.36 , new Currency('GBP'));
        return $money;
    }

}
