<?php

require 'includes/db.php';
require 'includes/utils.php';

session_start();
unset($_SESSION["login_user"]);  
header("Location: index.php");

?>