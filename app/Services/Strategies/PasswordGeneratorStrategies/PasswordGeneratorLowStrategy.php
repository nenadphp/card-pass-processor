<?php

namespace App\Services\Strategies\PasswordGeneratorStrategies;

use App\Services\Interfaces\PasswordGeneratorInterface;

class PasswordGeneratorLowStrategy extends AbstractPasswordGenerator implements PasswordGeneratorInterface
{
    /**
     * @param int $length
     * @return string
     */
    public function generate(int $length = 6): string
    {
        $strShuffle = substr(str_shuffle(self::LOWER_CASES), -$this->length / 2) .
            substr(str_shuffle(self::UPPER_CASES), -$this->length / 2);

            return str_shuffle($strShuffle);
    }
}
