<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "buger_menu";

$connnection = mysqli_connect($server, $username, $password, $database);
$select_db = mysqli_select_db($connnection, $database);

if (!$select_db) {
    echo ("Connection failed");
}
