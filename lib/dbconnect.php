<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


require_once "db_config.php";

$host='localhost';
$db = 'Test';
$user=$DB_USER;
$pass=$DB_PASS;

global $mysqli;
$mysqli = new mysqli($host, $user, $pass, $db);    

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . 
    $mysqli->connect_errno . ") " . $mysqli->connect_error;
}?>