<?php

namespace App\Services\Strategies\PasswordGeneratorStrategies;

abstract class AbstractPasswordGenerator
{
    protected const UPPER_CASES = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
    protected const LOWER_CASES = 'abcdefghjkmnpqrstuvwxyz';
    protected const NUMBERS = '2345';
    protected const SYMBOLS = '!#$%&(){}=][';

    protected $length;

    /**
     * @param int $length
     */
    public function __construct(int $length = 6)
    {
        $this->length = $length;
    }
}
