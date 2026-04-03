<?php
require_once 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: add-article.php');
    exit;
}

$title = mysqli_real_escape_string($conn, trim($_POST['title'] ?? ''));
$excerpt = mysqli_real_escape_string($conn, trim($_POST['excerpt'] ?? ''));
$content = mysqli_real_escape_string($conn, trim($_POST['content'] ?? ''));
$category = mysqli_real_escape_string($conn, trim($_POST['category'] ?? ''));
$author = mysqli_real_escape_string($conn, trim($_POST['author'] ?? ''));
$created_at = mysqli_real_escape_string($conn, $_POST['created_at'] ?? '');

$image_url = '';
$upload_success = false;
$error = '';

if (isset($_FILES['article_image']) && $_FILES['article_image']['error'] == 0) {
    $file = $_FILES['article_image'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');

    if (in_array($file_ext, $allowed_extensions, true)) {
        if ($file_size <= 5242880) {
            $new_filename = 'article_' . uniqid('', true) . '.' . $file_ext;
            $upload_dir = 'images/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            $upload_path = $upload_dir . $new_filename;
            if (move_uploaded_file($file_tmp, $upload_path)) {
                $image_url = $upload_path;
                $upload_success = true;
            } else {
                $error = 'Failed to upload image. Please check folder permissions.';
            }
        } else {
            $error = 'File size too large. Maximum size is 5MB.';
        }
    } else {
        $error = 'Invalid file type. Allowed: JPG, JPEG, PNG, GIF, WEBP.';
    }
} else {
    $error = 'Please select an image to upload.';
}

if (empty($title) || empty($excerpt) || empty($content) || empty($category) || empty($author) || empty($created_at)) {
    $error = 'Please fill in all required fields.';
}

if (!$error && $upload_success) {
    $sql = "INSERT INTO articles (title, excerpt, content, category, author, created_at, image_url)
            VALUES ('$title', '$excerpt', '$content', '$category', '$author', '$created_at', '$image_url')";
    if (mysqli_query($conn, $sql)) {
        $new_article_id = mysqli_insert_id($conn);
        header('Location: add-article.php?success=1&id=' . $new_article_id);
        exit;
    }

    $error = 'Database Error: ' . mysqli_error($conn);
    if ($image_url && file_exists($image_url)) {
        unlink($image_url);
    }
}

header('Location: add-article.php?error=' . urlencode($error));
exit;
