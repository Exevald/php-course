<?php

namespace App\User\Controller;

use App\Common\ConnectionProvider\ConnectionProvider;
use App\User\Infrastructure\UserRepository;
use App\User\Model\User;
use DateTime;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

class UserController
{
    private UserRepository $userRepository;
    private const MYSQL_DATETIME_FORMAT = 'Y-m-d';
    private const HTTP_STATUS_303_SEE_OTHER = 303;
    private const SHOW_USER_REDIRECT_PATH = '/actions/show_user.php?user_id=';


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
        try
        {
            $user = new User(
                null,
                $request[UserRepository::$DB_USER_FIRST_NAME],
                $request[UserRepository::$DB_USER_LAST_NAME],
                $request[UserRepository::$DB_USER_MIDDLE_NAME],
                $request[UserRepository::$DB_USER_GENDER],
                $this->parseDateTime($request[UserRepository::$DB_USER_BIRTH_DATE]),
                $request[UserRepository::$DB_USER_EMAIL],
                $request[UserRepository::$DB_USER_PHONE],
                $request[UserRepository::$DB_USER_AVATAR_PATH]
            );
            $userId = $this->userRepository->store($user);
            $this->writeRedirectSeeOther(self::SHOW_USER_REDIRECT_PATH . $userId);
        }
        catch (Throwable $exception)
        {
            throw new RuntimeException($exception->getMessage());
        }
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