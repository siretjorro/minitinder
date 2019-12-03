<?php 

require 'includes/db.php';
require 'includes/utils.php';

session_start();

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
        <h1>Matchid</h1>

        <?php 

        $matches_query = 'SELECT * FROM 185399_statuses WHERE user1="'.$_SESSION['login_user'].'" AND status=1';
        $result = mysqli_query($db, $matches_query);

        $matchesCount = 0;
        
        while ($rows = mysqli_fetch_array($result)) {   
            $match = $rows['user2'];
            $matches_query2 = 'SELECT * FROM 185399_statuses WHERE user1="'.$match.'" AND user2="'.$_SESSION['login_user'].'" AND status=1';
            $result2 = mysqli_query($db, $matches_query2);
            $num_rows = mysqli_num_rows($result2);
            if ($num_rows == 1) {
                $matchesCount += 1;
                $getmatch = 'SELECT * FROM 185399_users WHERE email="'.$match.'"';
                $result3 = mysqli_query($db, $getmatch);
                $row = mysqli_fetch_array($result3);
                $name = $row['name'];
                $email = $row['email'];
                $img_src = $row['photo'];
                $description = $row['description'];
                ?>
                <div id='match'> 
                <?php echo $name; ?>
                <br>
                <img src="<?php echo $img_src; ?>" alt="" title="" width="300px" />
                <br>
                <?php echo $description; ?>
                <br>
                <form action='messaging.php' method='POST'>
                    <input type="hidden" name="messagingWith" value="<?php echo $email; ?>">
                    <input type="submit" value="Vestle!">
                </form>
                </div>
                <?php
            }
        }

        if ($matchesCount == 0) {
            echo "Ühtegi matchi pole :(";
        }

        ?>
    </body>
</html>