<?php

require 'includes/utils.php';
require 'includes/db.php';

session_start();

if(isset($_POST['op'])) {
   $email = p('email');
   $password = p('password');
   
   $query = "SELECT id FROM 185399_users WHERE email = '$email' and password = '$password'";
   $result = mysqli_query($db, $query);
   
   $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
   $count = mysqli_num_rows($result);

    if (count(array_filter($_POST))!=count($_POST)) {
        echo "Palun täida kõik väljad!";
    } else {
        if($count == 1) {
            $_SESSION['login_user'] = $email;
            header("location: swiping.php");
         }else {
            $error = "Vale kasutajanimi või parool!";
            echo $error;
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
        <h1>Mini Tinder</h1>

        <form method="post">
            <input type="hidden" name="op" value="login">

            <label>E-mail</label>
            <br>
            <input type="text" required name="email">
            <br>
            <label>Parool</label>
            <br>
            <input type="password" required name="password">
            <br>
            <input type="submit" value="Logi sisse">
        </form>
        <a href="register.php">Registreeru</a>

    </body>
</html>