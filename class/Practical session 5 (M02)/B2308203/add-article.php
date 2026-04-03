<?php
require_once 'db-connect.php';
$success = isset($_GET['success']) && $_GET['success'] == '1';
$error = isset($_GET['error']) ? $_GET['error'] : '';
$new_article_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Add New Article - TechBlog</title>
    <link href="style.css" rel="stylesheet" />
    <link href="layout-sidebar-left.css" rel="stylesheet" />
    <link href="add-article.css" rel="stylesheet" />
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

    <main class="upload-form-container">
        <div class="upload-form-card">
            <h1 class="upload-form-title">Add New Article</h1>

            <?php if ($success && $new_article_id > 0): ?>
                <div class="upload-message upload-message-success">
                    ✓ Article published successfully!
                    <a href="article.php?id=<?php echo $new_article_id; ?>">View Article</a>
                    or
                    <a href="techblog.php">Go to Home</a>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="upload-message upload-message-error">✗ <?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="upload-article.php" enctype="multipart/form-data" id="articleForm">
                <div class="upload-form-group">
                    <label>Article Image <span class="required">*</span></label>
                    <div class="image-upload-area" id="uploadArea">
                        <div class="upload-icon">🖼️</div>
                        <p class="upload-text">Click to upload or drag and drop</p>
                        <p class="upload-hint">JPG, PNG, GIF, WEBP (Max 5MB)</p>
                        <input type="file" name="article_image" id="articleImage" class="file-input-hidden" accept="image/jpeg,image/png,image/gif,image/webp" required>
                    </div>
                    <div class="image-preview-container" id="imagePreviewContainer">
                        <img src="" alt="Preview" class="image-preview" id="imagePreview">
                        <div class="image-info" id="imageInfo"></div>
                        <button type="button" class="remove-image-btn" id="removeImageBtn">Remove Image</button>
                    </div>
                </div>

                <div class="upload-form-group">
                    <label for="title">Article Title <span class="required">*</span></label>
                    <input type="text" id="title" name="title" class="upload-form-input" placeholder="e.g., Getting Started with Machine Learning" required>
                    <span class="upload-input-hint">Choose a clear, descriptive title</span>
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
                                echo '<option value="' . htmlspecialchars($cat['name']) . '">' . htmlspecialchars($cat['name']) . '</option>';
                            }
                        } else {
                            echo '<option value="" disabled>No categories available</option>';
                        }
                        ?>
                    </select>
                    <span class="upload-input-hint">Select the category that best fits your article</span>
                </div>

                <div class="upload-form-group">
                    <label for="author">Author Name <span class="required">*</span></label>
                    <input type="text" id="author" name="author" class="upload-form-input" placeholder="e.g., John Doe" required>
                </div>

                <div class="upload-form-group">
                    <label for="created_at">Published Date <span class="required">*</span></label>
                    <input type="date" id="created_at" name="created_at" class="upload-form-input" required value="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="upload-form-group">
                    <label for="excerpt">Article Excerpt <span class="required">*</span></label>
                    <textarea id="excerpt" name="excerpt" class="upload-form-textarea" placeholder="Write a brief summary (2-3 sentences)" required></textarea>
                    <span class="upload-input-hint">This will appear on the article cards</span>
                </div>

                <div class="upload-form-group">
                    <label for="content">Full Article Content <span class="required">*</span></label>
                    <textarea id="content" name="content" class="upload-form-textarea upload-form-textarea-large" placeholder="Write your full article content here..." required></textarea>
                    <span class="upload-input-hint">Write your complete article here</span>
                </div>

                <div class="upload-form-buttons">
                    <button type="submit" class="upload-btn-submit" id="submitBtn">Publish Article</button>
                    <a href="techblog.php" class="upload-btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </main>

    <script src="add-article.js"></script>
    <script src="techblog.js"></script>
    <?php mysqli_close($conn); ?>
</body>
</html>
