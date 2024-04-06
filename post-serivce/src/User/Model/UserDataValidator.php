<?php

namespace App\User\Model;

use App\User\Model\ErrorType\ErrorType;
use Exception;

class UserDataValidator
{
    private const STRING_REGEXP = "/^[ 1-9a-zA-ZА-яёЁ-]+$/u";

    public function validateName(string $firstName, ?string $lastName): void
    {
        $checkCorrectFirstName = preg_match(self::STRING_REGEXP, $firstName);
        $checkCorrectLastName = (($lastName === "") || ($lastName === null) || preg_match(self::STRING_REGEXP, $lastName));
        if (!($checkCorrectFirstName && $checkCorrectLastName))
        {
            throw new Exception("Full name is not correct", ErrorType::INVALID_DATA->value);
        }
    }

    public function validateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            throw new Exception("Incorrect email!", ErrorType::INVALID_DATA->value);
        }
    }
}