<?php
$server = "localhost";
$username = "root"; 
$password = ""; 
$database = "buger_menu";

$conn = new mysqli($server, $username, $password, $database, '3306');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>