<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class DateFormatType extends Enum
{
    public const DATE_DEFAULT = 'Y-m-d';
    public const DATE_BR = 'd/m/Y';

    public const DATETIME_DEFAULT = 'Y-m-d H:i:s';
    public const DATETIME_BR = 'd/m/Y H:i:s';

    public const TIME_DEFAULT = 'H:i:s';
    public const TIME_BR = 'H:i:s';
}