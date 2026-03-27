<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Book Search</title>
</head>
<body>
    <form action="" method="POST">
        <input type="text" size="40" name="search_kw"
            value="<?php echo isset($_POST['search_kw']) ? htmlspecialchars($_POST['search_kw']) : ''; ?>">
        <input type="submit" value="Search title">
        <hr>
    </form>

    <h3>Search result</h3>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once __DIR__ . '/title-search-func.php';
        search($_POST['search_kw']);
    }
    ?>
</body>
</html>