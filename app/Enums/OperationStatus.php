<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class OperationStatus
 * @package App\Enums
 */
final class OperationStatus extends Enum
{
    const PENDING = 1;
    const FAILED = 2;
    const SUCCESS = 3;
}
