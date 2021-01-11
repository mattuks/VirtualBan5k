<?php

namespace App;

use App\Enums\OperationStatus;
use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Money\Currency;
use App\Helpers\SendsAlerts;
/**
 * Class Operation
 * @package App
 */
class Operation extends Model
{
    /**
     * @return HasMany
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    /**
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    /**
     * @return OperationStatus
     */
    public function getStatus(): OperationStatus
    {
        return OperationStatus::coerce($this->getAttribute('status'));
    }

    /**
     * @param OperationStatus $operationType
     * @return $this
     */
    public function setStatus(OperationStatus $operationType): self
    {
        $this->setAttribute('status', $operationType->value);

        return $this;
    }

    /**
     * @return string
     */
    public function getSenderUUID(): string
    {
        return $this->getAttribute('sender_uuid');
    }

    /**
     * @param string $senderUUID
     * @return $this
     */
    public function setSenderUUID(string $senderUUID): self
    {
        $this->setAttribute('sender_uuid', $senderUUID);

        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverUUID(): string
    {
        return $this->getAttribute('receiver_uuid');
    }

    /**
     * @param string $receiverUUID
     * @return $this
     */
    public function setReceiverUUID(string $receiverUUID): self
    {
        $this->setAttribute('receiver_uuid', $receiverUUID);

        return $this;
    }

    /**
     * @return Money
     */
    public function getAmount(): Money
    {
        return new Money($this->getAttribute('amount'), new Currency($this->getCurrency()->getCode()));
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

}
