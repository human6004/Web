<?php
include 'db-connect.php';

$sql = "SELECT COUNT(*) as total FROM articles";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

echo "Database connected successfully!<br>";
echo "Total articles in database: " . $row['total'];

mysqli_close($conn);
?>