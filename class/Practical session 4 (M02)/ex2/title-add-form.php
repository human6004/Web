<form action="title-management.php" method="POST">
    <pre>
ISBN      <input type="text" name="isbn" required>
Title     <input type="text" name="title" required>
Author    <input type="text" name="author" required>
Year      <input type="text" name="year" required>
Category  <input type="text" name="type" required>
          <input type="submit" value="Add Record">
    </pre>
    <input type="hidden" name="add" value="yes">
</form>