<?php
const INTERESTS = [
    "Робототехника",
    "Походы и сплавы",
    "World of Warcraft",
];

const BIRTHDAY = new DateTime("2004-10-28");

function calculateAge(DateTime $birthdayDate): int
{
    $currentDatetime = new DateTime();
    return $currentDatetime->diff($birthdayDate)->y;
}

?>

<html lang="ru">
<head>
    <title>About me</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<header class="page-header">
    <h1 class="page-title">Обо мне</h1>
</header>
<div class="info_section">
    <h3>ФИО: Калинин Константин Олегович</h3>
    <h3>Возраст: <?php echo(calculateAge(BIRTHDAY)); ?></h3>
    <h3>Интересы:</h3>
    <ul class="info_section__interests">
        <?php foreach (array_map(htmlentities(...), INTERESTS) as $phpPageLink): ?>
            <?php echo("<li>" . $phpPageLink . "</li>") ?>
        <?php endforeach; ?>
    </ul>
    <a class="links-section__page-link" href="./index.php">На главную страницу</a>
</div>
</body>
</html>
