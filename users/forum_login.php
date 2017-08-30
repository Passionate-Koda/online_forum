<?php
session_start();

include('db/db.php');



 ?>





<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Banjella Forum - Login</title>
  </head>
  <body>

<h1>Banjella Forum</h1>



<h2>...wanna always be here</h2>

<p>Please enter your username and password</p>
<?php
$null = array();
if(isset($_POST['login'])){

  if(empty($_POST['username'])){
    $null[] = "please enter username";
  }else{
    $username = mysqli_real_escape_string($db, $_POST['username']);
  }

  if(empty($_POST['password'])){
    $null[]= "please enter password";
  }else{
    $password = md5(mysqli_real_escape_string($db, $_POST['password']));
  }
  if(empty($null)){

    $ask = mysqli_query($db, "SELECT * FROM users WHERE username = '".$username."'
    AND password = '".$password."' ") or die (mysqli_error($db));

    if (mysqli_num_rows($ask) == 1){
      while($rows = mysqli_fetch_array($ask)){

        $_SESSION ['user_id'] = $rows['user_id'];
        $_SESSION['username'] = $rows['username'];
        header("Location:home.php");
      }
    }else{
      $invalid = "Invalid username and password. Please check again";
      header("Location:forum_login.php?invalid=$invalid");
    }


  }else{
    foreach ($null as $null) {
    echo "<p>".$null."</p>";
    }
  }
}
if(isset($_GET['invalid'])){
  $invalid = $_GET['invalid'];
  echo "<p>".$invalid."</p>";
}
if(isset($_GET['redirect'])){
  $redirect = $_GET['redirect'];
  echo "<p>".$redirect."</p>";
}

 ?>

 <form class=""  action="" method="post">
   <p>Username:<input class="" type="text" name="username" value=""></p>
   <p>password:<input class="" type="password" name="password" value=""></p>
   <input type="submit" name="login" value="Login">
 </form>
















 <p>New here? Please register here. Wont take a minute</p>


 <?php
$error = array();

if(isset($_POST['submit'])){

  if(empty($_POST['fname'])){
    $error[] = "Please enter Firstname";
  }else{
$fname = mysqli_real_escape_string($db, $_POST['fname']);
  }


  if(empty($_POST['lname'])){
    $error[] = "Please enter Lastname";
  }else{
    $lname = mysqli_real_escape_string($db, $_POST['lname']);
  }

  if(empty($_POST['email'])){
    $error[] = "Please enter you email";
  }else{
    $email = mysqli_real_escape_string($db, $_POST['email']);
  }

  if(empty($_POST['uname'])){
    $error[] = "Please specify your Username";
  }else{
    $uname = mysqli_real_escape_string($db, $_POST["uname"]);
  }

  if(empty($_POST['rpword'])){
    $error[] = "Please enter password";
  }else {
    $rpword = mysqli_real_escape_string($db, $_POST['rpword']);
  }

  if(empty($_POST['pword'])){
    $error [] = "Please enter password";
  }elseif (isset($_POST['rpword']) && $_POST['rpword'] != $_POST['pword']) {
  $error[] = "Password not Match";
}else {
  $pword= md5(mysqli_real_escape_string($db, $_POST['pword']));
}

if(empty($error)){

  $check= mysqli_query($db, "SELECT * FROM users WHERE email = '".$email."' ") or die (mysqli_error($db));
  if(mysqli_num_rows($check)==1) {
  $message = "Email already used to register";
  header("Location:forum_login.php?message=$message");
}else{

$confirm = mysqli_query($db, "SELECT * FROM users WHERE username = '".$uname."' ")
or die (mysqli_error($db));

if(mysqli_num_rows($confirm)== 0){
  $confirm = mysqli_query($db, "INSERT INTO users
  VALUES (NULL,
  '".$fname."',
  '".$lname."',
  '".$email."',
  '".$uname."',
  '".$rpword."',
  '".$pword."',
  NOW())") or die(mysqli_error($db));
  $success = "You have been registered";
  header("Location:forum_login.php?success=$success");
}else{
  $incorrect = "Username already exists";
  header("Location:forum_login.php?incorrect=$incorrect");


}

}


}else{
  foreach($error as $err){
  echo "<p>".$err."<p>";
  }
}





}

if(isset($_GET['incorrect'])){
$incorrect = $_GET['incorrect'];
echo '<p>'.$incorrect.'</p>';}

if(isset($_GET['success'])){
$success = $_GET['success'];
echo '<p>'.$success.'</p>';}

if(isset($_GET['message'])){
$message = $_GET['message'];
echo '<p>'.$message.'</p>';
}

if(isset($_GET['$redirect'])){
  $message = $_GET['redirect'];
  echo "<p>$redirect</p>";
}





?>

  <form class="" action="" method="post">
  <p>Firstname:<input type="text" name="fname" value=""></p>
  <p>Lastname: <input type="text" name="lname" value=""></p>
  <p>email: <input type="email" name="email" value=""></p>
  <p>Username: <input type="text" name="uname" value=""></p>
  <p>Password: <input type="password" name="rpword" value=""></p>
  <p>Confirm Password: <input type="passwword" name="pword" value=""></p>
  <input type="submit" name="submit" value="register">

  </form>









  </body>
</html>
