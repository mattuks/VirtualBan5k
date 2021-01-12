<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Money\Currency as MoneyCurrency;
use phpDocumentor\Reflection\Types\Mixed_;

class Currency extends Model
{
    public $currency;
    public $rate;

    /**
     * @return MoneyCurrency
     */
    public function getIsoCode(): MoneyCurrency
    {
        return new MoneyCurrency($this->getAttribute('iso_code'));
    }

    /**
     * @param MoneyCurrency $currency
     * @return $this
     */
    public function setIsoCode(MoneyCurrency $currency): self
    {
        $this->setAttribute('iso_code', $currency->getCode());

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

    /**
     * @param string $isoCode
     * @return float
     */
    public function getRateByIsoCode(string $isoCode): float
    {
        return Currency::where('iso_code', $isoCode)->first()->getRate();
    }
}
