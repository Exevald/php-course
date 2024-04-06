<?php
declare(strict_types=1);

namespace App\Common\ConnectionProvider;

use PDO;

class ConnectionProvider
{
    public static function getConnection(): PDO
    {
        $dbConfig = self::getConnectionParams();
        $dsn = $dbConfig['dsn'];
        $userName = $dbConfig['userName'];
        $password = $dbConfig['password'];

        return new PDO($dsn, $userName, $password);
    }

    /**
     * @return array{dsn:string,username:string,password:string}
     */

    private static function getConnectionParams(): array
    {
        $jsonConfig = file_get_contents(__DIR__ . '/db_config.json');
        return json_decode($jsonConfig, true);
    }
}