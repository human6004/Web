<?php
include 'templates/header.php';
include 'data/connect-select-db.php';

echo '<h2>Find user based on location</h2>';
echo "<form method='GET' action='find_query.php' class='inline-form'>";
echo "<div class='field'><label for='location'>Location</label>";
echo "<input type='text' id='location' name='location' value='" . htmlspecialchars($_GET['location'] ?? '') . "' size='20'></div>";
echo "<div><input type='submit' value='View Results'></div>";
echo '</form>';
echo "<p><a href='index.php'>Back to home</a></p>";

if (isset($_GET['location']) && !empty($_GET['location'])) {
    $location = mysqli_real_escape_string($conn, $_GET['location']);
    $sql = "SELECT * FROM employee WHERE location LIKE '%$location%'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

    echo '<h2>Search Result</h2>';
    echo "<p class='result-count'>$count employee(s) found</p>";

    if ($count > 0) {
        echo '<table>';
        echo '<tr><th>#</th><th>First Name</th><th>Last Name</th><th>Email Address</th><th>DOB</th><th>Location</th><th>Start Date</th></tr>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . htmlspecialchars($row['firstname']) . '</td>';
            echo '<td>' . htmlspecialchars($row['lastname']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . $row['dob'] . '</td>';
            echo '<td>' . htmlspecialchars($row['location']) . '</td>';
            echo '<td>' . $row['startdate'] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    }
}

mysqli_close($conn);
include 'templates/footer.php';
?>
