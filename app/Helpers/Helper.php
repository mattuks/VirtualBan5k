<?php

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

function messageUser(string $key ,string $message){
   return session([$key => $message]);
}
