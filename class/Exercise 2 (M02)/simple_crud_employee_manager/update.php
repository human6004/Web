<?php
include 'templates/header.php';
include 'data/connect-select-db.php';

echo '<h2>Update Employee Information</h2>';
$sql = 'SELECT * FROM employee ORDER BY id';
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<table>';
    echo '<tr><th>#</th><th>First Name</th><th>Last Name</th><th>Email Address</th><th>DOB</th><th>Location</th><th>Start Date</th><th>Edit</th></tr>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . htmlspecialchars($row['firstname']) . '</td>';
        echo '<td>' . htmlspecialchars($row['lastname']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td>' . $row['dob'] . '</td>';
        echo '<td>' . htmlspecialchars($row['location']) . '</td>';
        echo '<td>' . $row['startdate'] . '</td>';
        echo "<td><a href='update-single.php?id=" . $row['id'] . "'>Edit</a></td>";
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo '<p>No employees found.</p>';
}

echo "<p><a href='index.php'>Back to home</a></p>";

mysqli_close($conn);
include 'templates/footer.php';
?>
