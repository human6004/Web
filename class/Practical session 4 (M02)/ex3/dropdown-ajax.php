<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>AJAX Dropdown JSON</title>
    <script src="dropdown-ajax-functions.js"></script>
</head>
<body>
    <?php require_once __DIR__ . '/dropdown-php-function.php'; ?>

    <form name="f_profile" action="" method="GET">
        <p>
            Chọn tỉnh
            <select name="s_tinh" onchange="chonTinh(this.value)">
                <?php gen_tinh_options(); ?>
            </select>
        </p>

        <p>
            Chọn huyện
            <select name="s_huyen">
                <option value="">-- Chọn huyện --</option>
            </select>
        </p>
    </form>

    <script>
        window.onload = function () {
            const selectTinh = document.forms["f_profile"].elements["s_tinh"];
            if (selectTinh.value) {
                chonTinh(selectTinh.value);
            }
        };
    </script>
</body>
</html>