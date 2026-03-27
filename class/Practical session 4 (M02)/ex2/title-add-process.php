<?php
if (isset($_POST["add"])) {
    $isbn   = $_POST["isbn"];
    $author = $_POST["author"];
    $title  = $_POST["title"];
    $year   = $_POST["year"];
    $type   = $_POST["type"];

    // Bạn chỉnh lại danh sách cột theo đúng bảng classics của bạn
    $query = "INSERT INTO classics (isbn, author, title, type, year)
              VALUES ('$isbn', '$author', '$title', '$type', '$year')";

    if (!$conn->query($query)) {
        echo "<h3>INSERT failed. " . $conn->error . "</h3>";
    } else {
        echo "<p style='color:green;'>* Title '$isbn' has been added</p>";
    }
}
?>