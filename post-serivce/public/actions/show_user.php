<?php
declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\User\Controller\UserController;

$controller = new UserController();
$controller->showUser($_GET);