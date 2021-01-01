<?php


namespace App\Services;


use App\Account;
use App\Factories\AccountFactory;
use Cknow\Money\Money;

/**
 * Class AccountService
 * @package App\Services
 */
class AccountService
{
    /**
     * @param array $data
     * @return Account
     */
    public function create(array $data): Account
    {
        return AccountFactory::create($data);
    }

    /**
     * @param array $data
     * @return Account
     */
    public function createAndSave(array $data): Account
    {
        $account = AccountFactory::create($data);
        $account->save();

        return $account;
    }

    /**
     * @param Account $account
     * @param $amount
     * @return Account
     */
    public function addAmountAndSave(Account $account, Money $amount): Account
    {
        $account->setAmount($amount)->save();

        return $account;
    }

}
