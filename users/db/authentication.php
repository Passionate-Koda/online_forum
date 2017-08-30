<?php
include('db.php');

function check_page(){
  if(!isset($_SESSION['user_id']) && !isset($_SESSION['username'])){
    $redirect = "you have to login to view this page";
    header("Location:forum_login.php?redirect=$redirect");
  }

}


 ?>
