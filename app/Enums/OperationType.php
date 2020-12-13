<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class OperationType
 * @package App\Enums
 */
final class OperationType extends Enum
{
    const PENDING = 1;
    const FAILED = 2;
    const SUCCESS = 3;
}
