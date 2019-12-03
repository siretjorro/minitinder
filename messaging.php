<?php

require 'includes/utils.php';
require 'includes/db.php';
session_start();


if(isset($_POST['messagingWith'])) {  
    $messagingWith = p('messagingWith');
    $_SESSION['messagingWith'] = $messagingWith;
    $nameOfLoggedInQ = 'SELECT * FROM 185399_users WHERE email="'.$_SESSION['login_user'].'"';
    $nameOfMessagingWithQ = 'SELECT * FROM 185399_users WHERE email="'.$_SESSION['messagingWith'].'"';

    $result1 = mysqli_query($db, $nameOfLoggedInQ);
    $result2 = mysqli_query($db, $nameOfMessagingWithQ);

    $nameOfLoggedIn = (mysqli_fetch_array($result1))['name'];
    $nameOfMessagingWith = (mysqli_fetch_array($result2))['name'];

    $_SESSION['nameOfLoggedIn'] = $nameOfLoggedIn;
    $_SESSION['nameOfMessagingWith'] = $nameOfMessagingWith;
}

if(isset($_POST['message'])) {
    $message = p('message');

    $sql = 'INSERT INTO 185399_messages (sentby, sentto, message) VALUES("'.$_SESSION['login_user'].'" , "'.$_SESSION['messagingWith'].'","'.$message.'")';

    if (mysqli_query($db, $sql) == false) {
        die(mysqli_error($db));
    }

    header('Location: messaging.php');
}

?>

<html>
    <head>
        <!-- <link rel="stylesheet" href="https://unpkg.com/sakura.css/css/sakura.css" type="text/css"> -->
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
        <title>Mini Tinder</title>
        <!-- <meta http-equiv="refresh" content="5"/> -->
        <meta charset="UTF-8">
    </head>

    <body>
        <div class="vertical-menu">
            <a href="swiping.php" class="active">Pealeht</a>
            <a href="profile.php">Muuda profiili</a>
            <a href="matches.php">Matchid</a>
            <a href="logout.php">Logi välja</a>
        </div>

        <h1>Vestlus</h1>
        <div id="messagesandbox">
        <div id="messages">
        <?php

        // if(isset($_POST['messagingWith'])) {
            $messages_query = 'SELECT * FROM 185399_messages WHERE sentby="'.$_SESSION['login_user'].'" AND sentto="'.$_SESSION['messagingWith'].'" OR sentto="'.$_SESSION['login_user'].'" AND sentby="'.$_SESSION['messagingWith'].'"';
            $result = mysqli_query($db, $messages_query);

            while ($rows = mysqli_fetch_array($result)) {
                if ($rows['sentby'] == $_SESSION['messagingWith']) { ?>
                    <div id="notmymessage"> <?php
                    echo  $_SESSION['nameOfMessagingWith']. ": " . $rows['message']; ?>
                    </div> <?php 
                } else { ?> <div id="mymessage"> <?php
                    echo $_SESSION['nameOfLoggedIn']. ": " . $rows['message']; ?>
                    </div> <?php
                } 
                ?>
                <br>
                <?php
            }
        // }
        ?>

        </div>
        <br>
        <form id="messageform" method="POST">
            <textarea rows="4" cols="50" name="message" form="messageform" placeholder="Sisesta oma sõnum"></textarea>
            <br>
            <!-- <input type="hidden" name="messagingWith" value="<?php echo $messagingWith; ?>"> -->
            <input type="submit" name="sendmessage" value="Saada"> 
        </form>
        </div>

    </body>
</html>