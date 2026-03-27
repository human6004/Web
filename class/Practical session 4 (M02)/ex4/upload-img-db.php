<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/connect-select-db.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Upload ảnh vào DB</title>
</head>
<body>
    <h2>Upload ảnh vào DB</h2>

    <form method="POST" action="" enctype="multipart/form-data">
        <input type="file" name="img_file">
        <input type="submit" value="Upload">
    </form>
    <hr>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES["img_file"]["name"]) &&
        $_FILES["img_file"]["error"] === 0 &&
        getimagesize($_FILES['img_file']['tmp_name']) != false) {

        $image = file_get_contents($_FILES['img_file']['tmp_name']);
        $image = addslashes($image);
        $imgname = basename($_FILES["img_file"]["name"]);

        $query = "INSERT INTO images (imgname, imgdata) VALUES ('$imgname', '$image')";
        $conn->query($query) or die("Cannot insert image into DB: " . $conn->error);

        echo "Uploaded image:<br>";
        echo "<img src='get_img.php?name=" . urlencode($imgname) . "' width='300'>";
    } else {
        echo "No image has been uploaded hoặc file không hợp lệ.";
    }
}

$conn->close();
?>
</body>
</html>