<?php
include 'templates/header.php';
include 'data/connect-select-db.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "DELETE FROM employee WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='message success'>Employee deleted successfully!</div>";
    } else {
        echo "<div class='message error'>Error: " . mysqli_error($conn) . "</div>";
    }
}

echo '<h2>Delete Employees</h2>';
$sql = 'SELECT * FROM employee ORDER BY id';
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<table>';
    echo '<tr><th>#</th><th>First Name</th><th>Last Name</th><th>Email Address</th><th>DOB</th><th>Location</th><th>Start Date</th><th>Action</th></tr>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . htmlspecialchars($row['firstname']) . '</td>';
        echo '<td>' . htmlspecialchars($row['lastname']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td>' . $row['dob'] . '</td>';
        echo '<td>' . htmlspecialchars($row['location']) . '</td>';
        echo '<td>' . $row['startdate'] . '</td>';
        echo "<td><a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>";
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
