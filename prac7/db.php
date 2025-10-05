<?php
$host = "localhost";
$user = "root";   // change if your MySQL username is different
$pass = "";       // change if your MySQL password is not empty
$db = "travelease2";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
