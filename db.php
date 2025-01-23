<?php
$host = '185.149.230.166';
$db = 'lillebror_andet';
$user = 'lillebror_lillebror';
$password = 'KamLT6N7123';

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
$conn->set_charset("utf8");
?>
