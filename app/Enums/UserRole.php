<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserRole extends Enum
{
    const SUPERADMIN = 'SUPERADMIN';
    const BUSINESS_ADMIN = 'BUSINESS_ADMIN';
    const MANAGER = 'MANAGER';
    const EMPLOYEE = 'EMPLOYEE';
}
