<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce_db";

$con = mysqli_connect($server, $username, $password, $dbname);

if($con){
    echo "<script>console.log('connected')</script>";
}else{
    echo "<script>console.log('not connected')</script>";
}

?>