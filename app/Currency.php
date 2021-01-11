<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Money\Currency as MoneyCurrency;

class Currency extends Model
{
    public $currency;
    public $rate;

    /**
     * @return MoneyCurrency
     */
    public function getCurrency(): MoneyCurrency
    {
        return new MoneyCurrency($this->getAttribute('currency'));
    }

    /**
     * @param MoneyCurrency $currency
     * @return $this
     */
    public function setCurrency(MoneyCurrency $currency): self
    {
        $this->setAttribute('currency', $currency->getCode());

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRate(): float
    {
        return $this->getAttribute('rate');
    }

    /**
     * @param $rate
     * @return Currency
     */
    public function setRate($rate): Currency
    {
        $this->setAttribute('rate', $rate);

        return $this;
    }
}
