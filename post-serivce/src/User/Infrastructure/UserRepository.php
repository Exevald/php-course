<?php

namespace App\User\Infrastructure;

use App\User\Model\User;
use App\User\Model\UserRepositoryInterface;
use DateTime;
use InvalidArgumentException;
use PDO;

class UserRepository implements UserRepositoryInterface
{
    private const MYSQL_DATETIME_FORMAT = 'Y-m-d';

    public function __construct(private PDO $connection)
    {
    }

    public function get(int $id): ?User
    {
        $query = "SELECT first_name, last_name, middle_name, gender, birth_date, email, phone, avatar_path
                  FROM user
                  WHERE user_id = :id";
        $statement = $this->connection->prepare($query);
        $statement->execute(['id' => $id]);
        if ($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            return $this->createUserFromRow($row);
        }
        return null;
    }

    public function store(User $user): int
    {
        $birthDate = $user->getBirthDate();
        $query = "INSERT INTO user 
                    (first_name, last_name, middle_name, gender, birth_date, email, phone, avatar_path)
                    VALUES (:firstName, :lastName, :middleName, :gender, :birthDate, :email, :phone, :avatarPath)";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ':firstName' => $user->getFirstName(),
            ':lastName' => $user->getLastName(),
            ':middleName' => $user->getMiddleName(),
            ':gender' => $user->getGender(),
            ':birthDate' => $birthDate->format(self::MYSQL_DATETIME_FORMAT),
            ':email' => $user->getEmail(),
            ':phone' => $user->getPhone(),
            ':avatarPath' => $user->getAvatarPath()
        ]);
        return (int)$this->connection->lastInsertId();
    }

    private function createUserFromRow(array $row): User
    {
        # вынести в константы
        return new User(
            (int)$row['user_id'],
            $row['first_name'],
            $row['last_name'],
            $row['middle_name'],
            $row['gender'],
            $this->parseDateTime($row['birth_date']),
            $row['email'],
            $row['phone'],
            $row['avatar_path'],
        );
    }

    private function parseDateTime(string $value): DateTime
    {
        $result = DateTime::createFromFormat(self::MYSQL_DATETIME_FORMAT, $value);
        if (!$result)
        {
            throw new InvalidArgumentException("Invalid datetime value '$value'");
        }
        return $result;
    }

}