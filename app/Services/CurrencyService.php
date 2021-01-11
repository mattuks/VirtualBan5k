<?php

namespace App\Services;

use App\Currency;
use App\Factories\CurrencyFactory;
use Money\Currency as MoneyCurrency;

/**
 * Class CurrencyService
 * @package App\Services
 */
class CurrencyService
{
    /**
     *
     */
    public function updateCurrencyRates(): void
    {
        foreach (Currency::all() as $currency) {
            if ($this->isMainCurrency($currency->getCurrency()->getCode(), config('currencies.main'))){
                $this->setRateAndSave($currency, config('currencies.rates.eur'));
            }else{
                $this->setRateAndSave($currency, $this->generateRate());
            }
        }
    }

    /**
     * @param array $currencies
     */
    public function createCurrencies(array $currencies)
    {
        foreach ($currencies as $currency) {
            if ($this->isMainCurrency($currency, config('currencies.main'))) {
                $this->createAndSave([
                    'currency' => new MoneyCurrency($currency),
                    'rate'     => config('currencies.rates.eur'),
                ]);
            } else {
                $this->createAndSave([
                    'currency' => new MoneyCurrency($currency),
                    'rate'     => $this->generateRate(),
                ]);
            }
        }
    }

    /**
     * @param string $currency
     * @param string $mainCurrency
     * @return bool
     */
    public function isMainCurrency(string $currency, string $mainCurrency): bool
    {
        if ($currency === $mainCurrency) {
            return true;
        } else {
            return false;
        }
    }

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

    /**
     * @return float|int
     */
    private function generateRate()
    {
        return mt_rand(0.8 * 10, 1.5 * 10) / 10;
    }
}