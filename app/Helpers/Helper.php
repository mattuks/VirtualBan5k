<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Money\Currency;
/**
 * @param int $amount
 * @return float|int
 */
function parseToCents(int $amount)
{
    return $amount * 100;
};

/**
 * @param string $currency
 * @return bool
 */
function isMainCurrency(string $currency)
{
    if ($currency === config('currencies.main')){
        return true;
    }else{
        return false;
    }
}

/**
 * @param string $key
 * @param string $message
 * @return RedirectResponse
 */
function messageUser(string $key ,string $message): RedirectResponse
{
  return Redirect::back()->with($key, $message);
}
