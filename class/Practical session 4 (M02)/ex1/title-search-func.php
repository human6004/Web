<?php
function search($keyword) {
    require __DIR__ . '/connect-select-db.php';

    $keyword = trim($keyword);

    if ($keyword === '') {
        echo "Please enter a keyword.";
        return;
    }

    $keyword = mysqli_real_escape_string($conn, $keyword);

    $query = "SELECT * FROM classics WHERE title LIKE '%$keyword%'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<p><i>Title: " . htmlspecialchars($row['title']) . "</i> - Author: "
                . htmlspecialchars($row['author']) . " (" . htmlspecialchars($row['year']) . ")</p>";
        }
    } else {
        echo "No title found";
    }

    mysqli_close($conn);
}
?>