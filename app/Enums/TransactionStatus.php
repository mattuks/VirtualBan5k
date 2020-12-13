<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class TransactionStatus
 * @package App\Enums
 */
final class TransactionStatus extends Enum
{
    const SENT = 1;
    const PENDING = 2;
    const RECEIVED = 3;
    const FAILED = 4;

}
