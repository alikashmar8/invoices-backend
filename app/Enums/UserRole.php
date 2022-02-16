<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    const MANAGER = 'MANAGER';
    const CO_MANAGER = 'CO_MANAGER';
    const TEAM_MEMBER = 'TEAM_MEMBER';
}
