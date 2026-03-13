<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'mydb'; // nhớ đúng tên database bạn đang dùng

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8mb4');
mysqli_query($conn, "SET NAMES utf8mb4");
mysqli_query($conn, "SET CHARACTER SET utf8mb4");
?>