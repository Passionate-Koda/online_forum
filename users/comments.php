<?php
session_start();
    include('db/authentication.php');

check_page();

$user_identity = $_SESSION['user_id'];
$username = $_SESSION['username'];

$cate_id = $_GET['cat_id'];
$topic_id = $_GET['topic_id'];

$tabs = mysqli_query($db, "SELECT * FROM topic_category") or die(mysqli_error($db));


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>Banjella Forum</h1>
    <h2>...wanna always be here</h2>
  <?php

  echo "<p>Logged In User: <strong> $username</stong></p>";
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




<?php
$comment = mysqli_query($db, "SELECT content FROM topic WHERE topic_id='".$topic_id."'") or die(mysqli_error($db));

while($response = mysqli_fetch_array($comment)){
  extract($response);

  echo '<p>Topic:'.$content.'</p>';
}
?>
<?php
   $error = array();
   if(isset($_POST['comment'])){

     if(empty($_POST['box'])){
       $error[] = "Empty Threat!";
     }else{
       $comment = mysqli_real_escape_string($db, $_POST['box']);
     }

     if(empty($error)){
       $insert = mysqli_query($db, "INSERT INTO comment VALUES(NULL,
                '".$comment."',
                '".$topic_id."',
                '".$username."',
                NOW())") or die (mysqli_error($db));

                $success = "your Comment has been posted ";
                header("Location:comments.php?cat_id=$cate_id&topic_id=$topic_id&success=$success");
     }else{
       foreach($error as $err){
         echo $err;
       }
     }
   }





 ?>



<form action="comments.php?cat_id=<?php echo $cate_id?>&topic_id=<?php echo $topic_id ?>" method="post">

  <p>Post a comment:</p>
<textarea name="box" rows="7" cols="20"></textarea>


    <input type="submit" name="comment" value="Post Comment">
</form>
<hr/>

<?php
$com = mysqli_query($db, "SELECT * FROM comment WHERE topic_id = '".$topic_id."'") or die(mysqli_error($db));


if(isset($_GET['success'])){
  $succ = $_GET['success'];
  echo "<p>$succ</p>";
}
?>

<table >
  <tr>
    <th class="Comment">Comments</th><th>Comment by</th><th>Date</th>
  </tr>
  <tr>
    <?php
    while ($boolean = mysqli_fetch_array($com)){
      extract($boolean);
    ?>
    <td><?php echo $boolean['comment'] ?></td><td><?php echo $boolean['comment_by'] ?></td><td><?php echo $boolean['date']  ?></td>
  </tr>
  <?php } ?>
</table>


  </body>
</html>
