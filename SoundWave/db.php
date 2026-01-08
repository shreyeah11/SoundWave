<?php
$servername = "127.0.0.1:3307";
$username   = "root";
$password   = "";        // put your MySQL password here
$database   = "soundwave";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
