<?php
include 'templates/header.php';
include 'data/connect-select-db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);

    $sql = "INSERT INTO employee (firstname, lastname, email, dob, location)
            VALUES ('$firstname', '$lastname', '$email', '$dob', '$location')";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='message success'>Employee added successfully!</div>";
    } else {
        echo "<div class='message error'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<h2>Create New Employee</h2>
<!-- <form method="POST"> -->
<form method="POST" accept-charset="UTF-8">
    <table>
        <tr>
            <td>First Name:</td>
            <td><input type="text" name="firstname" required></td>
        </tr>
        <tr>
            <td>Last Name:</td>
            <td><input type="text" name="lastname" required></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="email" name="email" required></td>
        </tr>
        <tr>
            <td>Date of Birth:</td>
            <td><input type="date" name="dob"></td>
        </tr>
        <tr>
            <td>Location:</td>
            <td><input type="text" name="location"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Create Employee"></td>
        </tr>
    </table>
</form>

<p><a href="index.php">Back to home</a></p>

<?php
mysqli_close($conn);
include 'templates/footer.php';
?>
