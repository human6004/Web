<?php
require_once 'db-connect.php';

$article_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($article_id <= 0) {
    header('Location: techblog.php');
    exit;
}

$sql = "SELECT image_url FROM articles WHERE id = $article_id";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) !== 1) {
    header('Location: techblog.php');
    exit;
}

$article = mysqli_fetch_assoc($result);
$image_url = $article['image_url'] ?? '';

$delete_sql = "DELETE FROM articles WHERE id = $article_id";
if (mysqli_query($conn, $delete_sql)) {
    if (!empty($image_url) && file_exists($image_url)) {
        @unlink($image_url);
    }
    header('Location: techblog.php?deleted=success');
    exit;
}

header('Location: article.php?id=' . $article_id);
exit;
