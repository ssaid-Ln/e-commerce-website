<?php
  include 'dbcon.php';

$form_username= $_GET['form_username'];
$form_email= $_GET['form_email'];
$form_password= $_GET['form_password'];

// $_POST

$sql2 = "INSERT INTO `user_tbl` (`username`,`email`, `password` ) VALUES ('$form_username','$form_email', '$form_password')";

mysqli_query($con, $sql2);

header("location: register.php" );
?>