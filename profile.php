<?php

require 'includes/utils.php';
require 'includes/db.php';
session_start();

$msg = "";

if (isset($_POST['description'])) {
    $description = p('description');
    $sql = 'UPDATE 185399_users SET description = "'.$description.'" WHERE email = "'.$_SESSION['login_user'].'"';

    if (mysqli_query($db, $sql) == false) {
        die(mysqli_error($db));
    } else {
        echo "Profiil muudetud!";
    }
} 

if (isset($_POST['image'])) {
    $file_type = $_FILES['image']['type'];

    $allowed = array("image/jpeg", "image/gif", "image/png");
    if (!in_array($file_type, $allowed)) {
        $error_message = 'Ainult jpg, gif või png fail!';

        echo $error_message;

        exit();
    }

    $image = $_FILES['image']['name'];

    $target = "uploads/".basename($image);

    $sql = 'UPDATE 185399_users SET photo = "'.$target.'" WHERE email = "'.$_SESSION['login_user'].'"';

    mysqli_query($db, $sql);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Profiil muudetud!";
    } else {
        $msg = "Ebaõnnestus!";
    }

    echo $msg;
}
?>


<html>
    <head>
        <!-- <link rel="stylesheet" href="https://unpkg.com/sakura.css/css/sakura.css" type="text/css"> -->
        <link rel="stylesheet" href="stylesheet.css">
        <title>Mini Tinder</title>
    </head>
    <body>
        <div class="vertical-menu">
            <a href="swiping.php" class="active">Pealeht</a>
            <a href="profile.php">Muuda profiili</a>
            <a href="matches.php">Matchid</a>
            <a href="logout.php">Logi välja</a>
        </div>

        <h1>Minu profiil</h1>

        Praegune profiil:

        <?php
        $getuser = 'SELECT * FROM 185399_users WHERE email="'.$_SESSION['login_user'].'"';
        $result = mysqli_query($db, $getuser);
        $row = mysqli_fetch_array($result);
        $img_src = $row['photo'];
        $description = $row['description'];
        ?>
        <div>
        <img src="<?php echo $img_src; ?>" alt="" title="" width="300px" />
        <br>
        <?php echo $description; ?>
        </div>

        <div id="change">
        Muuda profiili:

        <form method="post" id="usrform" enctype="multipart/form-data">
            <input type="hidden" name="op" value="login">

            <label>Sind kirjeldav tekst</label>
            <br>
            <textarea rows="4" cols="50" name="description" form="usrform"></textarea>
            <br>
            <label>Pilt</label>
            <input type="file" name="image" id="image">
            <br>
            <input type="submit" name="upload" value="Muuda"> 
        </form>
        <div>

    </body>
</html>