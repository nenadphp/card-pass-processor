<?php

namespace App\Services\Strategies\PasswordGeneratorStrategies;

use App\Services\Interfaces\PasswordGeneratorInterface;

class PasswordGeneratorHighStrategy extends AbstractPasswordGenerator implements PasswordGeneratorInterface
{
    public function generate(): string
    {
        $strShuffle = substr(str_shuffle(self::LOWER_CASES), (-$this->length / 2) + 2) .
            substr(str_shuffle(self::UPPER_CASES), (-$this->length / 2) + 2);

        $strShuffle .= substr(str_shuffle(self::NUMBERS), -2);
        $strShuffle .= substr(str_shuffle(self::SYMBOLS), -2);

        return str_shuffle($strShuffle);
    }
}
