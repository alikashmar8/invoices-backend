<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CurrencyEnum extends Enum
{
    const AUD =   'AUD';
    const USD =   'USD';
    const EUR =  'EUR';
    const GBP =  'GBP';
    const CAD =  'CAD';
    const CHF =  'CHF';
    const JPY =  'JPY';
    const AED =  'AED';
    const RUR =  'RUR';
    const TRY =  'TRY';
}
