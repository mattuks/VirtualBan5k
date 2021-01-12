<?php


namespace App\Services;


use App\Account;
use App\Factories\AccountFactory;
use Cknow\Money\Money;

/**
 * Class AccountService
 * @package App\Services
 */
class AccountService extends ConversationService
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
     * @param Money $amount
     * @return Account
     */
    public function addAmountAndSave(Account $account, Money $amount): Account
    {
        $account->setAmount($amount)->save();
        return $account;
    }

    /**
     * @param Account $account
     * @param Money $money
     * @return Account
     */
    public function addToAmount(Account $account, Money $money): Account
    {
        return $this->addAmountAndSave($account,$account->getAmount()->add($money));
    }

    /**
     * @param Account $account
     * @param Money $money
     */
    public function subtractFromAmount(Account $account, Money $money): void
    {
        $this->addAmountAndSave($account, $account->getAmount()->subtract($money));
    }

    /**
     * @param Account $account
     * @param Money $money
     */
    public function addAmountAndConvert(Account $account, Money $money): void
    {
        if ($account->getAmount()->isSameCurrency($money)){
            $this->addToAmount($account,$money);
        }else{
            $this->addToAmount($account, $this->convertMoney($money, $account->getCurrency()));
        }
    }
}
