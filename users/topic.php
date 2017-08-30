<?php
session_start();
    include('db/authentication.php');

check_page();

$user_identity = $_SESSION['user_id'];
$username = $_SESSION['username'];


if(isset($_GET['cat_id']) && isset($_GET['category_name'])){
$cate_id = $_GET['cat_id'];
  $cate_name = $_GET['category_name'];
}

$tabs = mysqli_query($db, "SELECT * FROM topic_category") or die(mysqli_error($db));
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
  <?php

  echo "<p>Logged In User: <strong> $username</strong></p>";
   ?>


    <a href="home.php">Home</a>
    <?php

    while($bluelinks = mysqli_fetch_array($tabs)){
extract($bluelinks);

?>

<a href="topic.php?cat_id=<?php echo $category_id; ?>&category_name=<?PHP echo $category_name; ?>"><?PHP  echo $category_name;  ?></a>
<?php }  ?>

<br>
<hr>




<?php     echo '<p>'.$cate_name.'</p> <br>'; ?>





<?php

if($cate_name == "Technology"){

  echo "<p> This Is the first page $cate_name</p>";

}else{//begining of text section of
  $error = array();

//process start
if (array_key_exists('message', $_POST)){


  if(empty($_POST['text'])){
    $error[] = "please post a topic";
  }else{
    $topic = mysqli_real_escape_string($db, $_POST['text']);
  }
  if(empty($error)){
    $insert = mysqli_query($db, "INSERT INTO topic
                                  VALUES (NULL,
                                  '".$topic."',
                                  '".$cate_id."',
                                  '".$username."',
                                  NOW())") or die(mysqli_error($db));

  $success = "Your Content has been posted";
  header("Location:topic.php?cat_id=$cate_id&category_name=$cate_name&success=$success");
}else{
  foreach($error as $err){
    echo "<p>$err</p>";
  }
}
}

  ?>

<form  action="topic.php?cat_id=<?php echo $cate_id ?>&category_name=<?php echo $cate_name ?>"  method="post">

  <p> post a topic :<br>
    <textarea name="text" rows="" cols="20"></textarea>
   </p>
  <input type="submit" name="message" value="Post Topic">

</form>

<?php
}//end of text area



 ?>

 <hr>

 <?php
$topic = mysqli_query($db, "SELECT * FROM topic WHERE category_id = '".$cate_id."'") or die(mysqli_error());


  ?>

  <table border="1">

    <tr>
      <th>Topic Content</th> <th>Topic By</th> <th>Date</th>
    </tr>
    <tr>

    <?php while($result = mysqli_fetch_array($topic)){
      extract ($result);

     ?>
     <td><a href="comments.php?cat_id=<?PHP  echo $cate_id  ?>&topic_id=<?PHP echo $result['topic_id']?>"><?php echo $result['content']; ?></a></td>

     <td><?php echo $result['username']; ?></td><td><?php echo $result['date']; ?></td>
       </tr>
       <?php }?>
  </table>









<a href="logout.php">Logout</a>

  </body>
</html>
