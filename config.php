<?php

$server = "localhost";
$username = "ezystay_user";
$password = "password";
$database = "ezystay";

$conn = mysqli_connect($server,$username,$password,$database);

if(!$conn){
    die("<script>alert('connection Failed.')</script>");
}
// else{
//     echo "<script>alert('connection successfully.')</script>";
// }
?>