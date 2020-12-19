<?php

namespace App;

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Money\Currency;

/**
 * Class AccountEvent
 * @package App
 */
class Account extends Model
{
    /**
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return HasMany
     */
    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class);
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
     * @return string
     */
    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->setAttribute('name', $name);

        return $this;
    }

    /**
     * @return string
     */
    public function getUUID(): string
    {
        return $this->getAttribute('uuid');
    }

    /**
     * @param string $uuid
     * @return $this
     */
    public function setUUID(string $uuid): self
    {
        $this->setAttribute('uuid', $uuid);

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
}
