<?php

namespace App\Services\Strategies\PasswordGeneratorStrategies;

use App\Services\Interfaces\PasswordGeneratorInterface;

class PasswordGeneratorMiddleStrategy extends AbstractPasswordGenerator implements PasswordGeneratorInterface
{
    public function generate(int $length = 6): string
    {
        $strShuffle = substr(str_shuffle(self::LOWER_CASES), (-$this->length / 2) + 1) .
            substr(str_shuffle(self::UPPER_CASES), (-$this->length / 2) + 1);

        $strShuffle .= substr(str_shuffle(self::NUMBERS), -2);

        return str_shuffle($strShuffle);
    }
}
