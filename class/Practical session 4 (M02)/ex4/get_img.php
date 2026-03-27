<?php
require "connect-select-db.php";

if (isset($_GET['name'])) {
    $name = $_GET['name'];

    $stmt = $conn->prepare("SELECT imgdata FROM images WHERE imgname = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($imgdata);
    $stmt->fetch();

    header("Content-Type: image/jpeg");
    echo $imgdata;

    $stmt->close();
}

$conn->close();
?>