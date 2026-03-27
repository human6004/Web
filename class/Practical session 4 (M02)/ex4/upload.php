<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_FILES['up-file'])) {
    die("Không nhận được file upload.");
}

if ($_FILES['up-file']['error'] !== 0) {
    die("Upload error: " . $_FILES['up-file']['error']);
}

$uploadDir = __DIR__ . '/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$filename = basename($_FILES['up-file']['name']);
$targetPath = $uploadDir . $filename;

if (move_uploaded_file($_FILES["up-file"]["tmp_name"], $targetPath)) {
    echo "File uploaded: " . htmlspecialchars($_FILES["up-file"]["name"]) . "<br>";
    echo "Type: " . htmlspecialchars($_FILES['up-file']['type']) . "<br>";
    echo "Size: " . $_FILES['up-file']['size'] . "b<br>";
    echo '<img src="uploads/' . rawurlencode($filename) . '" width="300">';
} else {
    echo "Không thể lưu file.";
}
?>