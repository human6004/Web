<?php
require "connect-select-db.php";
require "title-delete-process.php";
require "title-add-process.php";
require "title-list-delete-form.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Title Management</title>
</head>
<body>
    <h2>Title Management</h2>

    <?php include "title-add-form.php"; ?>

    <hr>
    <h3>Book List</h3>

    <?php
    $query = "SELECT * FROM classics";
    $result = $conn->query($query) or die("DB Access error: " . $conn->error);

    while ($row = $result->fetch_assoc()) {
        del_form_gen($row);
        echo "<hr>";
    }

    $conn->close();
    ?>
</body>
</html>