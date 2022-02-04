<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class WebsiteIds extends Enum
{
    const Shagtoday =   1;
    const HookUpToday =   2;
    const BeeDate = 3;
    const OhCupid = 4;
}
