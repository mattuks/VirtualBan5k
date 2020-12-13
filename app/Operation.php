<?php

namespace App;

use App\Enums\OperationType;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Operation
 * @package App
 */
class Operation extends Model
{

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
