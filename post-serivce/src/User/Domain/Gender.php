<?php

namespace App\User\Domain;

use App\User\Domain\ErrorType\ErrorType;
use Exception;

enum Gender: int
{
    case MALE = 0;
    case FEMALE = 1;

    public static function convertStringToEnumValue(string $gender): Gender
    {
        $gender = strtoupper($gender);
        if ($gender === self::MALE->name)
        {
            return self::MALE;
        }
        if ($gender === self::FEMALE->name)
        {
            return self::FEMALE;
        }
        throw new Exception(' invalid gender ', ErrorType::INVALID_DATA->value);
    }
}