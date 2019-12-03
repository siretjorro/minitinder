<?php

require 'includes/utils.php';
require 'includes/db.php';

session_start();

$username = p('username');
$name = p('name');
$email = p('email');
$password = p('password');
$gender = p('gender');

if (isset($_POST['op'])) {
    $check = mysqli_query($db, "select * from 185399_users where email='$email'");
    $checkrows=mysqli_num_rows($check);

    $query = 'INSERT INTO 185399_users (username, name, email, password, gender) VALUES("'.$username.'" , "'.$name.'","'.$email.'","'.$password.'", "'.$gender.'")';

    if ($checkrows > 0) {
        echo "Sellise e-mailiga kasutaja on juba olemas!";
    } else {
        if (mysqli_query($db, $query) == false) {
            die(mysqli_error($db));
        } else {
            $_SESSION['login_user'] = $email;
            header('Location: profilefirst.php');
        }
    }
}

?>

<html>
    <head>
        <!-- <link rel="stylesheet" href="https://unpkg.com/sakura.css/css/sakura.css" type="text/css"> -->
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
        <title>Mini Tinder</title>
    </head>
    <body>
        <h1>Registreeru</h1>

        <form method="post">
            <input type="hidden" name="op" value="login">

            <label>Kasutajatunnus</label>
            <br>
            <input type="text" maxlength="100" required name="username">
            <br>

            <label>Nimi</label>
            <br>
            <input type="text" maxlength="100" required name="name">
            <br>

            <label>E-mail</label>
            <br>
            <input type="email" maxlength="100" required name="email">
            <br>

            <label>Parool</label>
            <br>
            <input type="password" maxlength="100" required name="password">
            <br>

            <label>Sugu</label>
            <br>
            <input type="radio" name="gender" value="0"> Mees
            <input type="radio" name="gender" value="1"> Naine<br>

            <input type="submit" value="Registreeru">
        </form>

    </body>
</html>