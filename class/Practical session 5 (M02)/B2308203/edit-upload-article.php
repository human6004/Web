<?php
require_once 'db-connect.php';

$article_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($article_id <= 0) {
    die('Invalid article ID.');
}

$sql = "SELECT * FROM articles WHERE id = $article_id";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) !== 1) {
    die('Article not found.');
}
$article = mysqli_fetch_assoc($result);
$success = isset($_GET['updated']) && $_GET['updated'] == '1';
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Edit Article - TechBlog</title>
    <link href="style.css" rel="stylesheet" />
    <link href="layout-sidebar-left.css" rel="stylesheet" />
    <link href="add-article.css" rel="stylesheet" />
    <link href="edit-upload-article.css" rel="stylesheet" />
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo"><a href="techblog.php" style="color: inherit; text-decoration: none;">TechBlog</a></div>
            <ul class="nav-menu">
                <li><a href="techblog.php">Home</a></li>
                <li><a href="techblog.php#articles">Articles</a></li>
                <li><a href="add-article.php">Add New Article</a></li>
                <li><button id="darkModeToggle" type="button">🌙</button></li>
            </ul>
        </div>
    </nav>

    <main class="upload-form-container main-edit-form">
        <div class="upload-form-card">
            <h1 class="upload-form-title">Edit Article</h1>

            <?php if ($success): ?>
                <div class="upload-message upload-message-success">
                    ✓ Article updated successfully!
                    <a href="article.php?id=<?php echo $article_id; ?>">View Article</a>
                    or
                    <a href="techblog.php">Go to Home</a>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="upload-message upload-message-error">✗ <?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="edit-article.php?id=<?php echo $article_id; ?>" enctype="multipart/form-data" id="articleForm">
                <div class="upload-form-group">
                    <label>Article Image</label>
                    <div class="current-image-wrapper">
                        <p class="current-image-label">Current image:</p>
                        <img src="<?php echo htmlspecialchars($article['image_url']); ?>" alt="Current image" class="current-article-image">
                    </div>
                    <div class="image-upload-area" id="uploadArea">
                        <div class="upload-icon">🖼️</div>
                        <p class="upload-text">Click to upload a new image or drag and drop</p>
                        <p class="upload-hint">Leave empty to keep the current image</p>
                        <input type="file" name="article_image" id="articleImage" class="file-input-hidden" accept="image/jpeg,image/png,image/gif,image/webp">
                    </div>
                    <div class="image-preview-container" id="imagePreviewContainer">
                        <img src="" alt="Preview" class="image-preview" id="imagePreview">
                        <div class="image-info" id="imageInfo"></div>
                        <button type="button" class="remove-image-btn" id="removeImageBtn">Remove Selected Image</button>
                    </div>
                </div>

                <div class="upload-form-group">
                    <label for="title">Article Title <span class="required">*</span></label>
                    <input type="text" id="title" name="title" class="upload-form-input" required value="<?php echo htmlspecialchars($article['title']); ?>">
                </div>

                <div class="upload-form-group">
                    <label for="category">Category <span class="required">*</span></label>
                    <select id="category" name="category" class="upload-form-select" required>
                        <option value="">-- Select Category --</option>
                        <?php
                        $cat_sql = "SELECT id, name FROM categories ORDER BY name ASC";
                        $cat_result = mysqli_query($conn, $cat_sql);
                        if ($cat_result && mysqli_num_rows($cat_result) > 0) {
                            while ($cat = mysqli_fetch_assoc($cat_result)) {
                                $selected = ($article['category'] === $cat['name']) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($cat['name']) . '" ' . $selected . '>' . htmlspecialchars($cat['name']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="upload-form-group">
                    <label for="author">Author Name <span class="required">*</span></label>
                    <input type="text" id="author" name="author" class="upload-form-input" required value="<?php echo htmlspecialchars($article['author']); ?>">
                </div>

                <div class="upload-form-group">
                    <label for="created_at">Published Date <span class="required">*</span></label>
                    <input type="date" id="created_at" name="created_at" class="upload-form-input" required value="<?php echo htmlspecialchars($article['created_at']); ?>">
                </div>

                <div class="upload-form-group">
                    <label for="excerpt">Article Excerpt <span class="required">*</span></label>
                    <textarea id="excerpt" name="excerpt" class="upload-form-textarea" required><?php echo htmlspecialchars($article['excerpt']); ?></textarea>
                </div>

                <div class="upload-form-group">
                    <label for="content">Full Article Content <span class="required">*</span></label>
                    <textarea id="content" name="content" class="upload-form-textarea upload-form-textarea-large" required><?php echo htmlspecialchars($article['content']); ?></textarea>
                </div>

                <div class="upload-form-buttons">
                    <button type="submit" class="upload-btn-submit" id="submitBtn">Save Changes</button>
                    <a href="article.php?id=<?php echo $article_id; ?>" class="upload-btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </main>

    <script src="edit-upload-article.js"></script>
    <script src="techblog.js"></script>
    <?php mysqli_close($conn); ?>
</body>
</html>
