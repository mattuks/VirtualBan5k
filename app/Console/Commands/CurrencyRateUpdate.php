<?php

namespace App\Console\Commands;

use App\Currency;
use Illuminate\Console\Command;
class CurrencyRateUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:currencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update currency rates on Database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function handle()
    {
        $currencies = Currency::all();
        foreach ($currencies as $currency){
           if ($currency->getIsoCode()->getCode() === config('currencies.main')){
                continue;
           }else{
               $currency->setRate(mt_rand(0.7 * 10, 1.7 * 10) / 10)->save();
           }
        }

    }
}
