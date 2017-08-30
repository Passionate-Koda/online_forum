<?php
session_start();
include("db/db.php")


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Banjella Forum| Admin</title>
  </head>
  <body>

<?php

if(isset($_POST['submit'])){
$error = array();

if(empty($_POST['uname'])){
  $error[]= "please enter username";
}else{
  $uname = mysqli_real_escape_string($db, $_POST['uname']);
}

if(empty($_POST['pword'])){
  $error[] = "Please enter password";
}else{
  $pword = md5(mysqli_real_escape_string($db, $_POST['pword']));
}

if(empty($error)){

$ask = mysqli_query($db, "SELECT * FROM admin WHERE username='".$uname."' AND Password= '".$pword."' ") or die (mysqli_error($db));

if(mysqli_num_rows($ask) == 1){
  while($row = mysqli_fetch_array($ask)){
    $_SESSION['admin_id'] = $row['admin_id'];
    $_SESSION['admin_username'] = $row['username'];
    header("Location:admin_home.php");
  }
}else{
  $invalid = "Invalid Username and Password";
  header("Location:admin_login.php?invalid=$invalid");
}
}else{
  foreach ($error as $err){
    echo $err;
  }
}

}

if(isset($_GET['invalid'])){
  $invalid = $_GET['invalid'];
  echo "<p>$invalid</p>";
}



 ?>

<form class="" action="" method="post">
    <input type="text" name="uname" value="" placeholder="Username">
    <input type="password" name="pword" value=>
    <input type="submit" name="submit" value="Login">
</form>


  </body>
</html>
