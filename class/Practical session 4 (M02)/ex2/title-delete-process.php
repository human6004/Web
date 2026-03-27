<?php
if (isset($_POST['delete']) && isset($_POST['isbn'])) {
    $isbn = $_POST['isbn'];

    $query = "DELETE FROM classics WHERE isbn='$isbn'";

    if (!$conn->query($query)) {
        echo "<h3>DELETE failed: " . htmlspecialchars($isbn) . ". Error: " . $conn->error . "</h3>";
    } else {
        echo "<p style='color:red;'>* Title '$isbn' has been deleted</p>";
    }
}
?>