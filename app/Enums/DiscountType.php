<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DiscountType extends Enum
{
    const AMOUNT = 'AMOUNT';
    const PERCENTAGE = 'PERCENTAGE';
}
