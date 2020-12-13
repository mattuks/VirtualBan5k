<?php

namespace App;

use App\Enums\TransactionDirectionType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Model;
use Money\Currency;

/**
 * Class Transaction
 * @package App
 */
class Transaction extends Model
{
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->getAttribute('user_id');
    }

    /**
     * @param int $user_id
     * @return $this
     */
    public function setUserId(int $user_id): self
    {
        $this->setAttribute('user_id', $user_id);

        return $this;
    }

    /**
     * @return int
     */
    public function getOperationId(): int
    {
        return $this->getAttribute('operation_id');
    }

    /**
     * @param int $operation_id
     * @return $this
     */
    public function setOperationId(int $operation_id): self
    {
        $this->setAttribute('operation_id', $operation_id);

        return $this;
    }

    /**
     * @return int
     */
    public function getAccountId(): int
    {
        return $this->getAttribute('account_id');
    }

    /**
     * @param int $account_id
     * @return $this
     */
    public function setAccountId(int $account_id): self
    {
        $this->setAttribute('account_id', $account_id);

        return $this;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return new Currency($this->getAttribute('currency'));
    }

    /**
     * @param Currency $currency
     * @return $this
     */
    public function setCurrency(Currency $currency): self
    {
        $this->setAttribute('currency', $currency->getCode());

        return $this;
    }

    /**
     * @return TransactionStatus
     */
    public function getStatus(): TransactionStatus
    {
        return TransactionStatus::coerce($this->getAttribute('status'));
    }

    /**
     * @param TransactionStatus $transactionStatus
     * @return $this
     */
    public function setStatus(TransactionStatus $transactionStatus): self
    {
        $this->setAttribute('status', $transactionStatus->value);

        return $this;
    }


    /**
     * @return TransactionType
     */
    public function getType(): TransactionType
    {
        return TransactionType::coerce($this->getAttribute('type'));
    }

    /**
     * @param TransactionType $transactionType
     * @return $this
     */
    public function setType(TransactionType $transactionType): self
    {
        $this->setAttribute('type', $transactionType->value);

        return $this;
    }

    /**
     * @return TransactionDirectionType
     */
    public function getDirection(): TransactionDirectionType
    {
        return TransactionDirectionType::coerce($this->getAttribute('direction'));
    }

    /**
     * @param TransactionDirectionType $transactionDirectionType
     * @return $this
     */
    public function setDirection(TransactionDirectionType $transactionDirectionType): self
    {
        $this->setAttribute('direction', $transactionDirectionType->value);

        return $this;
    }

    /**
     * @return Money
     */
    public function getAmount(): Money
    {
        return new Money($this->getAttribute('amount'), new Currency($this->getCurrency()));
    }

    /**
     * @param Money $money
     * @return $this
     */
    public function setAmount(Money $money): self
    {
        $this->setAttribute('amount', $money->getAmount());

        return $this;
    }
}
