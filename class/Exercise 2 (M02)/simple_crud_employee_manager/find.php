<?php
include 'templates/header.php';
include 'data/connect-select-db.php';
?>

<h2>Find user based on location</h2>
<form method="GET" action="find_query.php" class="inline-form">
    <div class="field">
        <label for="location">Location</label>
        <input type="text" name="location" id="location" size="20">
    </div>
    <div>
        <input type="submit" value="View Results">
    </div>
</form>

<p><a href="index.php">Back to home</a></p>

<?php
mysqli_close($conn);
include 'templates/footer.php';
?>
