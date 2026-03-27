<?php
require "connect-select-db.php";

function gen_tinh_options() {
    global $conn;

    $query = "SELECT * FROM tinh ORDER BY tentinh";
    $result = $conn->query($query) or die("SELECT failed: " . $conn->error);

    echo "<option value=''>-- Chọn tỉnh --</option>";

    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . (int)$row['matinh'] . "'>"
            . htmlspecialchars($row['tentinh']) .
            "</option>";
    }
}
?>