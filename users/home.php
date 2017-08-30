<?php
session_start();
include("db/authentication.php");

check_page();

$user_identity = $_SESSION['user_id'];
$username = $_SESSION['username'];

$link = mysqli_query($db, "SELECT * FROM topic_category") or die (mysqli_error($db));






 ?>




<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Banjella Forum | Home</title>
  </head>
  <body>
    <h1>Banjella Forum</h1>
    <h2>...wanna always be here</h2>

        <?php echo "<p> Weclome, <strong> $username</stong></p>" ?>

    <a href="home.php">Home</a>
    <?php

    while($ref = mysqli_fetch_array($link)){
extract($ref);

?>

<a href="topic.php?cat_id=<?php echo $category_id; ?>&category_name=<?PHP echo $category_name ?>"><?PHP  echo $category_name  ?></a>

<?php
}

 ?>


<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
   Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
   dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
   Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>











<a href="logout.php">Logout</a>

  </body>
</html>
