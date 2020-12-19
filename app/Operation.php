<?php

namespace App;

use App\Enums\OperationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Operation
 * @package App
 */
class Operation extends Model
{
    /**
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    /**
     * @return OperationType
     */
    public function getType(): OperationType
    {
        return OperationType::coerce($this->getAttribute('type'));
    }

    /**
     * @param OperationType $operationType
     * @return $this
     */
    public function setType(OperationType $operationType): self
    {
        $this->setAttribute('type', $operationType->value);

        return $this;
    }
}
