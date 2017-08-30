<?php

session_start();
include("db/authentication.php");

if(isset($_SESSION['user_id']) && isset($_SESSION['username'])){

  unset($_SESSION['user_id']);
  unset($_SESSION['username']);
    header("Location:forum_login.php");

}


?>
