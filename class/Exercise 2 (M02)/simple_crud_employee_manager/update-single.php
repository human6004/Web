<?php
include 'templates/header.php';
include 'data/connect-select-db.php';

$id = mysqli_real_escape_string($conn, $_GET['id'] ?? '');

if ($id === '') {
    echo "<div class='message error'>Missing employee id.</div>";
    echo "<p><a href='update.php'>Back to update page</a></p>";
    include 'templates/footer.php';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);

    $sql = "UPDATE employee SET firstname='$firstname',
            lastname='$lastname', email='$email', dob='$dob',
            location='$location' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        header('Location: update.php');
        exit();
    } else {
        echo "<div class='message error'>Error: " . mysqli_error($conn) . "</div>";
    }
}

$sql = "SELECT * FROM employee WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$employee = mysqli_fetch_assoc($result);

if (!$employee) {
    echo '<p>Employee not found.</p>';
    include 'templates/footer.php';
    exit();
}
?>

<h2>Update Employee #<?php echo $id; ?></h2>
<!-- <form method="POST"> -->
<form method="POST" accept-charset="UTF-8">
    <table>
        <tr>
            <td>First Name:</td>
            <td><input type="text" name="firstname" value="<?php echo htmlspecialchars($employee['firstname']); ?>" required></td>
        </tr>
        <tr>
            <td>Last Name:</td>
            <td><input type="text" name="lastname" value="<?php echo htmlspecialchars($employee['lastname']); ?>" required></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required></td>
        </tr>
        <tr>
            <td>Date of Birth:</td>
            <td><input type="date" name="dob" value="<?php echo $employee['dob']; ?>"></td>
        </tr>
        <tr>
            <td>Location:</td>
            <td><input type="text" name="location" value="<?php echo htmlspecialchars($employee['location']); ?>"></td>
        </tr>
        <tr>
            <td></td>
            <td class="actions">
                <input type="submit" value="Update Employee">
                <a href="update.php">Cancel</a>
            </td>
        </tr>
    </table>
</form>

<p><a href="index.php">Back to home</a></p>

<?php
mysqli_close($conn);
include 'templates/footer.php';
?>
