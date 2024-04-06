<?php

namespace App\User\Model;

use DateTime;

class User
{
    private ?int $userId;
    private string $firstName;
    private string $lastName;
    private string $gender;
    private DateTime $birthDate;
    private string $email;
    private ?string $phone;
    private ?string $avatarPath;
    private ?string $middleName;

    public function __construct(
        ?int     $userId,
        string   $firstName,
        string   $lastName,
        ?string  $middleName,
        string   $gender,
        DateTime $birthDate,
        string   $email,
        ?string  $phone,
        ?string  $avatarPath
    )
    {
        $userDataValidator = new UserDataValidator();
        $userDataValidator->validateName($firstName, $lastName);
        $userDataValidator->validateEmail($email);

        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
        $this->gender = $gender;
        $this->birthDate = $birthDate;
        $this->email = $email;
        $this->phone = $phone;
        $this->avatarPath = $avatarPath;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getBirthDate(): DateTime
    {
        return $this->birthDate;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getAvatarPath(): ?string
    {
        return $this->avatarPath;
    }

}