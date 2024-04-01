<?php
$createUserRoute = '/actions/create_user.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create user form</title>
</head>
<body>
<form action="<?= $createUserRoute ?>" method="POST">
    <div>
        <label for="first_name">Firstname:</label>
        <input name="first_name" id="first_name" type="text" required>
    </div>
    <div>
        <label for="last_name">Lastname:</label>
        <input name="last_name" id="last_name" type="text" required>
    </div>
    <div>
        <label for="middle_name">Middle name:</label>
        <input name="middle_name" id="middle_name" type="text">
    </div>
    <div>
        <p>Please select your gender:</p>
        <input name="gender" id="male" value="male" type="radio">
        <label for="male">Male</label>
        <input name="gender" id="female" value="female" type="radio">
        <label for="female">Female</label>
    </div>
    <div>
        <input type="date" id="birth_date" name="birth_date">
        <label for="birth_date">Birthday (date and time):</label>
    </div>
    <div>
        <label for="email">Email:</label>
        <input name="email" id="email" type="text">
    </div>
    <div>
        <label for="phone">Phone:</label>
        <input name="phone" id="phone" type="text">
    </div>


    <button type="submit">Submit</button>
</form>
</body>
</html>