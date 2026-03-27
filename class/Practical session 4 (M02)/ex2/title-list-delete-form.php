<?php
function del_form_gen($row) {
    echo "
    <form action='title-management.php' method='POST'
          onsubmit=\"return confirm('Do you really want to delete the book?');\">
        <pre>
ISBN      " . htmlspecialchars($row['isbn']) . "
Title     " . htmlspecialchars($row['title']) . "
Author    " . htmlspecialchars($row['author']) . "
Year      " . htmlspecialchars($row['year']) . "
Category  " . htmlspecialchars($row['type']) . "
          <input type='submit' value='DELETE'>
        </pre>
        <input type='hidden' name='delete' value='yes'>
        <input type='hidden' name='isbn' value='" . htmlspecialchars($row['isbn']) . "'>
    </form>";
}
?>