<?php
require_once 'db-connect.php';

$category_slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$category_slug = mysqli_real_escape_string($conn, $category_slug);

$cat_sql = "SELECT * FROM categories WHERE slug = '$category_slug'";
$cat_result = mysqli_query($conn, $cat_sql);

if (mysqli_num_rows($cat_result) == 0) {
    die('Category not found');
}

$category = mysqli_fetch_assoc($cat_result);

$sql = "SELECT * FROM articles WHERE category = '{$category['name']}' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?php echo htmlspecialchars($category['name']); ?> - TechBlog</title>
    <link href="style.css" rel="stylesheet" />
    <link href="layout-sidebar-left.css" rel="stylesheet" />
    <link href="ex2-enhancements.css" rel="stylesheet" />
    <link href="category.css" rel="stylesheet" />
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo"><a href="techblog.php" style="color: inherit; text-decoration: none;">TechBlog</a></div>
            <ul class="nav-menu">
                <li><a href="techblog.php#home">Home</a></li>
                <li><a href="techblog.php#about">About</a></li>
                <li><a href="techblog.php#articles">Articles</a></li>
                <li><a href="techblog.php#contact">Contact</a></li>
                <li><button id="darkModeToggle" type="button">🌙</button></li>
            </ul>
        </div>
    </nav>

    <main class="category-container category-page-spacing">
        <a href="techblog.php" class="back-button">← Back to Home</a>

        <div class="category-header">
            <h1 class="category-title"><?php echo htmlspecialchars($category['name']); ?></h1>
            <p class="category-description"><?php echo htmlspecialchars($category['description']); ?></p>
            <p class="category-count"><?php echo mysqli_num_rows($result); ?> article<?php echo mysqli_num_rows($result) != 1 ? 's' : ''; ?></p>
        </div>

        <div class="articles-grid">
            <?php if (mysqli_num_rows($result) > 0) { ?>
                <?php while ($article = mysqli_fetch_assoc($result)) { ?>
                    <article class="article-card">
                        <img
                            src="<?php echo htmlspecialchars($article['image_url']); ?>"
                            alt="<?php echo htmlspecialchars($article['title']); ?>"
                            class="article-image"
                        >

                        <div class="article-body">
                            <span class="category"><?php echo htmlspecialchars($article['category']); ?></span>
                            <h3 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h3>
                            <p class="article-excerpt"><?php echo htmlspecialchars($article['excerpt']); ?></p>

                            <div class="article-meta">
                                <span class="author">By <?php echo htmlspecialchars($article['author']); ?></span>
                                <span class="date"><?php echo date('M d, Y', strtotime($article['created_at'])); ?></span>
                            </div>

                            <p class="view-count"><span class="views"><?php echo (int) $article['views']; ?></span> views</p>
                            <a href="article.php?id=<?php echo $article['id']; ?>" class="read-more">Read More →</a>
                        </div>
                    </article>
                <?php } ?>
            <?php } else { ?>
                <div class="empty-message">No articles in this category yet.</div>
            <?php } ?>
        </div>
    </main>

    <footer class="footer" id="about">
        <div class="footer-content">
            <div class="footer-section">
                <h4>About TechBlog</h4>
                <p>TechBlog is your go-to source for the latest technology news, tutorials, and insights.
                    Stay updated with the fast-paced world of technology.</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="techblog.php#home">Home</a></li>
                    <li><a href="techblog.php#about">About Us</a></li>
                    <li><a href="techblog.php#contact">Contact</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-section" id="contact">
                <h4>Follow Us</h4>
                <div class="social-links">
                    <a href="#">Facebook</a>
                    <a href="#">Twitter</a>
                    <a href="#">LinkedIn</a>
                    <a href="#">Instagram</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2024 TechBlog. All rights reserved.</p>
        </div>
    </footer>

    <button aria-label="Back to top" id="backToTop" type="button">⬆️</button>
    <div aria-hidden="true" class="newsletter-popup" id="newsletterPopup">
        <span class="close-popup" id="closePopup">×</span>
        <h3>Join our newsletter</h3>
        <p>Subscribe to receive the latest tech news and tutorials every week.</p>
        <input id="popupEmail" placeholder="Enter your email" type="email" />
        <button id="popupSubscribeBtn" type="button">Subscribe Now</button>
    </div>

    <script src="techblog.js"></script>
    <?php mysqli_close($conn); ?>
</body>
</html>
