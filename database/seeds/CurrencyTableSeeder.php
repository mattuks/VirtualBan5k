<?php

use Illuminate\Database\Seeder;
use Money\Currency as MoneyCurrency;
use App\Factories\CurrencyFactory;
class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('currencies.rates') as $currency => $rate){
            CurrencyFactory::create([
               'currency' => new MoneyCurrency($currency),
                'rate' => $rate,
            ])->save();
        }
    }
}
