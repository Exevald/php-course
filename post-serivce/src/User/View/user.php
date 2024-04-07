<?php
/**
 * @var App\User\Model\User $user ;
 */

$birthDateFormat = 'Y-m-d';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User</title>
    <meta charset="UTF-8">
</head>
<body>
<div>
    <h1>User data: </h1>
    <p>First name: <?= htmlentities($user->getFirstName(), ENT_QUOTES, 'UTF-8') ?></p>
    <p>Last name: <?= htmlentities($user->getLastName()) ?></p>
    <?php if ($user->getMiddleName()): ?>
        <p><?= htmlentities($user->getMiddleName()) ?></p>
    <?php endif; ?>
    <p><?= htmlentities($user->getGender()) ?></p>
    <p><?= htmlentities($user->getBirthDate()->format($birthDateFormat)) ?></p>
    <p><?= htmlentities($user->getEmail()) ?></p>
    <?php if ($user->getPhone()): ?>
        <p><?= htmlentities($user->getPhone()) ?></p>
    <?php endif; ?>
    <?php if ($user->getAvatarPath()): ?>
        <p><?= htmlentities($user->getAvatarPath()) ?></p>
    <?php endif; ?>
</div>
</body>
</html>