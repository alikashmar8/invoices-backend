<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class InvitationStatus extends Enum
{
    const PENDING = 'PENDING';
    const ACCEPTED = 'ACCEPTED';
    const REJECTED = 'REJECTED';
    const EXPIRED = 'EXPIRED';
}
