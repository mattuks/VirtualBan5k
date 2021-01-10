<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class OperationCreatedNotification
 * @package App\Enums
 */
final class OperationStatus extends Enum
{
    const PENDING = 1;
    const FAILED = 2;
    const SUCCESS = 3;
}
