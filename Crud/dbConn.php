<?php 
$servername = "localhost";
$username = "root";
$password = "root";
$myDB= "crudop";

$conn = mysqli_connect($servername, $username, $password, $myDB);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>