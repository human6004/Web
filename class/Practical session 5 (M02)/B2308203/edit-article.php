<?php
require_once 'db-connect.php';

$article_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $article_id <= 0) {
    header('Location: techblog.php');
    exit;
}

$check_sql = "SELECT * FROM articles WHERE id = $article_id";
$check_result = mysqli_query($conn, $check_sql);
if (!$check_result || mysqli_num_rows($check_result) !== 1) {
    header('Location: techblog.php');
    exit;
}
$existing_article = mysqli_fetch_assoc($check_result);

$title = mysqli_real_escape_string($conn, trim($_POST['title'] ?? ''));
$excerpt = mysqli_real_escape_string($conn, trim($_POST['excerpt'] ?? ''));
$content = mysqli_real_escape_string($conn, trim($_POST['content'] ?? ''));
$category = mysqli_real_escape_string($conn, trim($_POST['category'] ?? ''));
$author = mysqli_real_escape_string($conn, trim($_POST['author'] ?? ''));
$created_at = mysqli_real_escape_string($conn, $_POST['created_at'] ?? '');
$error = '';
$image_url = $existing_article['image_url'];
$new_upload_path = '';

if (empty($title) || empty($excerpt) || empty($content) || empty($category) || empty($author) || empty($created_at)) {
    $error = 'Please fill in all required fields.';
}

if (!$error && isset($_FILES['article_image']) && $_FILES['article_image']['error'] === 0) {
    $file = $_FILES['article_image'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');

    if (!in_array($file_ext, $allowed_extensions, true)) {
        $error = 'Invalid file type. Allowed: JPG, JPEG, PNG, GIF, WEBP.';
    } elseif ($file_size > 5242880) {
        $error = 'File size too large. Maximum size is 5MB.';
    } else {
        $upload_dir = 'images/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $new_filename = 'article_' . uniqid('', true) . '.' . $file_ext;
        $new_upload_path = $upload_dir . $new_filename;
        if (!move_uploaded_file($file_tmp, $new_upload_path)) {
            $error = 'Failed to upload new image. Please check folder permissions.';
        } else {
            $image_url = $new_upload_path;
        }
    }
}

if ($error) {
    header('Location: edit-upload-article.php?id=' . $article_id . '&error=' . urlencode($error));
    exit;
}

$update_sql = "UPDATE articles
               SET title = '$title',
                   excerpt = '$excerpt',
                   content = '$content',
                   category = '$category',
                   author = '$author',
                   created_at = '$created_at',
                   image_url = '" . mysqli_real_escape_string($conn, $image_url) . "'
               WHERE id = $article_id";

if (mysqli_query($conn, $update_sql)) {
    if ($new_upload_path && !empty($existing_article['image_url']) && $existing_article['image_url'] !== $new_upload_path && file_exists($existing_article['image_url'])) {
        @unlink($existing_article['image_url']);
    }
    header('Location: edit-upload-article.php?id=' . $article_id . '&updated=1');
    exit;
}

if ($new_upload_path && file_exists($new_upload_path)) {
    @unlink($new_upload_path);
}
header('Location: edit-upload-article.php?id=' . $article_id . '&error=' . urlencode('Database Error: ' . mysqli_error($conn)));
exit;
