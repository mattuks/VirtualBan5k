<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class TransactionType
 * @package App\Enums
 */
final class TransactionType extends Enum
{
    const TRANSFER = 1;
    const BONUS = 2;
}
