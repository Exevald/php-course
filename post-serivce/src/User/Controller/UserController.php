<?php

namespace App\User\Controller;

use App\User\Domain\User;
use App\User\Infrastructure\ConnectionProvider\ConnectionProvider;
use App\User\Infrastructure\UserRepository;
use DateTime;
use InvalidArgumentException;

class UserController
{
    private UserRepository $userRepository;
    private const MYSQL_DATETIME_FORMAT = 'Y-m-d';
    private const HTTP_STATUS_303_SEE_OTHER = 303;


    public function __construct()
    {
        $connection = ConnectionProvider::getConnection();
        $this->userRepository = new UserRepository($connection);
    }

    public function index(): void
    {
        require __DIR__ . '/../View/create_user_form.php';
    }

    public function createUser(array $request): void
    {
        $user = new User(
            null,
            $request['first_name'],
            $request['last_name'],
            $request['middle_name'],
            $request['gender'],
            $this->parseDateTime($request['birth_date']),
            $request['email'],
            $request['phone'],
            $request['avatar_path']
        );
        $userId = $this->userRepository->store($user);
        $this->writeRedirectSeeOther('/actions/show_user.php?user_id=' . $userId);
    }

    public function showUser(array $request): void
    {
        $userId = $request['user_id'] ?? null;
        if ($userId === null)
        {
            throw new InvalidArgumentException('User id is not defined');
        }
        $user = $this->userRepository->get($userId);
        require __DIR__ . '/../View/user.php';
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

    private function writeRedirectSeeOther(string $url): void
    {
        header('Location: ' . $url, true, self::HTTP_STATUS_303_SEE_OTHER);
    }
}