<?php

namespace App\User\Model;

use App\User\Model\ErrorType\ErrorType;
use Exception;

enum Gender: int
{
    case MALE = 0;
    case FEMALE = 1;
    # использовать match
    # convertFrom
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