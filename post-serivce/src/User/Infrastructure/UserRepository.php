<?php

namespace App\User\Infrastructure;

use App\User\Model\User;
use App\User\Model\UserRepositoryInterface;
use DateTime;
use InvalidArgumentException;
use PDO;

class UserRepository implements UserRepositoryInterface
{
    private const MYSQL_DATETIME_FORMAT = 'Y-m-d H:i:s';
    static public string $DB_USER_ID = 'user_id';
    static public string $DB_USER_FIRST_NAME = 'first_name';
    static public string $DB_USER_LAST_NAME = 'last_name';
    static public string $DB_USER_MIDDLE_NAME = 'middle_name';
    static public string $DB_USER_GENDER = 'gender';
    static public string $DB_USER_BIRTH_DATE = 'birth_date';
    static public string $DB_USER_EMAIL = 'email';
    static public string $DB_USER_PHONE = 'phone';
    static public string $DB_USER_AVATAR_PATH = 'avatar_path';

    public function __construct(private readonly PDO $connection)
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
            ':middleName' => $user->getMiddleName() ?? null,
            ':gender' => $user->getGender(),
            ':birthDate' => $birthDate->format(self::MYSQL_DATETIME_FORMAT),
            ':email' => $user->getEmail(),
            ':phone' => $user->getPhone() ?? null,
            ':avatarPath' => $user->getAvatarPath() ?? null
        ]);
        return (int)$this->connection->lastInsertId();
    }

    private function createUserFromRow(array $row): User
    {
        return new User(
            (int)$row[self::$DB_USER_ID],
            $row[self::$DB_USER_FIRST_NAME],
            $row[self::$DB_USER_LAST_NAME],
            $row[self::$DB_USER_MIDDLE_NAME],
            $row[self::$DB_USER_GENDER],
            $this->parseDateTime($row[self::$DB_USER_BIRTH_DATE]),
            $row[self::$DB_USER_EMAIL],
            $row[self::$DB_USER_PHONE],
            $row[self::$DB_USER_AVATAR_PATH],
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