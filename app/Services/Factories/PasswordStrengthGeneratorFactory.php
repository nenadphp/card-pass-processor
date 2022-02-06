<?php

namespace App\Services\Factories;

use App\Exceptions\PasswordFactoryException;
use App\Services\Interfaces\PasswordGeneratorInterface;
use App\Services\Strategies\PasswordGeneratorStrategies\PasswordGeneratorHighStrategy;
use App\Services\Strategies\PasswordGeneratorStrategies\PasswordGeneratorLowStrategy;
use App\Services\Strategies\PasswordGeneratorStrategies\PasswordGeneratorMiddleStrategy;

class PasswordStrengthGeneratorFactory
{
    private const PASSWORD_STRENGTH_LOW = 1;
    private const PASSWORD_STRENGTH_MIDDLE = 2;
    private const PASSWORD_STRENGTH_HIGH5 = 3;

    /**
     * @param int $passwordLevel
     * @param int $length
     * @return PasswordGeneratorInterface
     * @throws PasswordFactoryException
     */
    public static function create(int $passwordLevel, int $length): PasswordGeneratorInterface
    {
        switch ($passwordLevel) {
            case self::PASSWORD_STRENGTH_LOW:
                return new PasswordGeneratorLowStrategy($length);
            case self::PASSWORD_STRENGTH_MIDDLE:
                return new PasswordGeneratorMiddleStrategy($length);
            case self::PASSWORD_STRENGTH_HIGH5;
                return new PasswordGeneratorHighStrategy($length);
            default:
                throw new PasswordFactoryException(
                    sprintf(
                        'Wrong pass strength passed, strength expected: [%s]',
                        implode(', ',[self::PASSWORD_STRENGTH_LOW, self::PASSWORD_STRENGTH_MIDDLE, self::PASSWORD_STRENGTH_HIGH5])
                    )
                );
        }
    }
}
