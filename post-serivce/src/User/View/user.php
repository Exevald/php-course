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
    <p>First name: <?= $user->getFirstName() ?></p>
    <p>Last name: <?= $user->getLastName() ?></p>
    <?php if ($user->getMiddleName()): ?>
        <p>Middle name: <?= $user->getMiddleName() ?></p>
    <?php endif; ?>
    <p>Gender: <?= $user->getGender() ?></p>
    <p>Birthdate: <?= $user->getBirthDate()->format($birthDateFormat) ?></p>
    <p>Email: <?= $user->getEmail() ?></p>
    <?php if ($user->getPhone()): ?>
        <p>Phone: <?= $user->getPhone() ?></p>
    <?php endif; ?>
    <?php if ($user->getAvatarPath()): ?>
        <p>Avatar path: <?= $user->getAvatarPath() ?></p>
    <?php endif; ?>
</div>
</body>
</html>