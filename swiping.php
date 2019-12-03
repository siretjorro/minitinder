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

        <h1>Mini Tinder</h1>

        <?php

        $display = "inline";

        $query = 'SELECT gender from 185399_users where email="'.$_SESSION['login_user'].'"';
        $user_gender = mysqli_query($db, $query);
        $roww = mysqli_fetch_assoc($user_gender);
        
        if ($roww['gender'] == 0) {
            $show_gender = 1;
        } else {
            $show_gender = 0;
        }
        
        $sql1 = "SELECT description, photo from 185399_users where gender = $show_gender";
        $result1 = mysqli_query($db, $sql1);
        $num_rows = mysqli_num_rows($result1);

        if (isset($_POST['a'])) {
            $a = p('a');
            if ($a == $num_rows) {
                echo "Rohkem kasutajaid ei ole!";
                $display = "none";
            }
        } else {
            $a = 0;
        }

        if (isset($_POST['status'])) {
            $status = p('status');
            $userr = p('usertocheck');
            
            $checkIfExists = 'SELECT * from 185399_statuses where user1 = "'.$_SESSION['login_user'].'" AND user2="'.$userr.'"';
            $ifExistsResult = mysqli_query($db, $checkIfExists);
            if (mysqli_query($db, $checkIfExists) == false) {
                die(mysqli_error($db));
            }
            $num_rows = mysqli_num_rows($ifExistsResult);
            if ($num_rows == 1) {
                $sql = 'UPDATE 185399_statuses SET status="'.$status.'" WHERE user1 = "'.$_SESSION['login_user'].'" AND user2="'.$userr.'"';
                
                if (mysqli_query($db, $sql) == false) {
                    die(mysqli_error($db));
                }
            } else {
                $statusquery = 'INSERT INTO 185399_statuses (user1, user2, status) VALUES("'.$_SESSION['login_user'].'", "'.$userr.'", "'.$status.'")';
                if (mysqli_query($db, $statusquery) == false) {
                    die(mysqli_error($db));
                }
            }
        }

        $b = 1;
        
        $sql1 = "SELECT * from 185399_users where gender = $show_gender LIMIT $a, $b";

        $result = mysqli_query($db, $sql1);

        if (!$result) {
            echo mysqli_error($db);
        }
        
        $row = mysqli_fetch_array($result);
        $usertocheck = $row['email'];
        $name = $row['name'];
        $img_src = $row['photo'];
        $description = $row['description'];
        ?>
    
        <div>
        <?php echo $name; ?>
        <br>
        <img src="<?php echo $img_src; ?>" alt="" title="" width="300px"/>
        <br>
        <?php echo $description; ?>
        </div>
        
        <form style="display:<?php echo $display; ?>" method='POST'>
            <input type="hidden" name="status" value='1'>
            <input type="hidden" name="a" value='<?php echo $a+1; ?>'>
            <input type="hidden" name="usertocheck" value="<?php echo $usertocheck; ?>">
            <input type="submit" value="Jah">
        </form>

        <form style="display:<?php echo $display; ?>" method='POST'>
            <input type="hidden" name="status" value='0'>
            <input type="hidden" name="a" value='<?php echo $a+1; ?>'>
            <input type="hidden" name="usertocheck" value="<?php echo $usertocheck; ?>">
            <input type="submit" value="Ei">
        </form>

        <!-- <a id="yes" style="display:<?php echo $display; ?>" href="swiping.php?status=1&a=<?php echo $a+1; ?>&usertocheck=<?php echo $usertocheck; ?>">Jah</a>
        <a id="no" style="display:<?php echo $display; ?>" href="swiping.php?status=0&a=<?php echo $a+1; ?>&usertocheck=<?php echo $usertocheck; ?>">Ei</a> -->
    </body>
</html>