<?php


namespace App\Factories;

use App\Account;

/**
 * Class AccountFactory
 * @package App\Factories
 */
class AccountFactory
{
    /**
     * @param array $data
     * @return Account
     */
    public static function create(array $data): Account
    {
        $account = new Account();
        $account->setUserId($data['user_id']);
        $account->setName($data['name']);
        $account->setCurrency($data['currency']);

        return $account;
    }
}
