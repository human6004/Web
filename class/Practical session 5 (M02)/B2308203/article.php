<?php
include 'db-connect.php';

$article_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$sql = "SELECT * FROM articles WHERE id = $article_id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) === 1) {
    $article = mysqli_fetch_assoc($result);
    $update_sql = "UPDATE articles SET views = views + 1 WHERE id = $article_id";
    mysqli_query($conn, $update_sql);
    $article['views'] = ((int) $article['views']) + 1;
} else {
    die('Article not found!');
}

$related_sql = "SELECT id, title, image_url, excerpt, author, created_at, views
                FROM articles
                WHERE category = '" . mysqli_real_escape_string($conn, $article['category']) . "'
                  AND id != $article_id
                ORDER BY created_at DESC, id DESC
                LIMIT 3";
$related_result = mysqli_query($conn, $related_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?php echo htmlspecialchars($article['title']); ?> - TechBlog</title>
    <link href="style.css" rel="stylesheet" />
    <link href="layout-sidebar-left.css" rel="stylesheet" />
    <link href="ex2-enhancements.css" rel="stylesheet" />
    <link href="article.css" rel="stylesheet" />
    <link href="article-related.css" rel="stylesheet" />
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo"><a href="techblog.php" style="color: inherit; text-decoration: none;">TechBlog</a></div>
            <ul class="nav-menu">
                <li><a href="techblog.php#home">Home</a></li>
                <li><a href="techblog.php#about">About</a></li>
                <li><a href="techblog.php#articles">Articles</a></li>
                <li><a href="add-article.php">Add New Article</a></li>
                <li><a href="techblog.php#contact">Contact</a></li>
                <li><button id="darkModeToggle" type="button">🌙</button></li>
            </ul>
        </div>
    </nav>

    <main class="article-container article-page-spacing">
        <div class="article-page-header article-actions-top">
            <a href="techblog.php" class="back-to-articles">← Back to All Articles</a>
        </div>

        <article class="single-article">
            <img src="<?php echo htmlspecialchars($article['image_url']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="article-header-image">

            <div class="article-body-content">
                <span class="article-category-badge"><?php echo htmlspecialchars($article['category']); ?></span>
                <h1 class="article-main-title"><?php echo htmlspecialchars($article['title']); ?></h1>

                <div class="article-metadata">
                    <span><strong>Author:</strong> <?php echo htmlspecialchars($article['author']); ?></span>
                    <span><strong>Published:</strong> <?php echo date('F d, Y', strtotime($article['created_at'])); ?></span>
                    <span><strong>Views:</strong> <?php echo number_format((int) $article['views']); ?></span>
                </div>

                <div class="article-excerpt-box"><?php echo htmlspecialchars($article['excerpt']); ?></div>
                <div class="article-full-content"><?php echo nl2br(htmlspecialchars($article['content'])); ?></div>

                <div class="article-action-links">
                    <a href="edit-upload-article.php?id=<?php echo $article_id; ?>" class="back-to-articles">✏️ Edit Article</a>
                    <a href="delete-article.php?id=<?php echo $article_id; ?>" class="back-to-articles delete-article-btn" onclick="return confirm('Are you sure you want to delete this article? This action cannot be undone!');">Delete Article</a>
                </div>
            </div>
        </article>

        <section class="related-articles-section">
            <h3>Related Articles</h3>
            <div class="related-articles-grid">
                <?php
                if ($related_result && mysqli_num_rows($related_result) > 0) {
                    while ($related = mysqli_fetch_assoc($related_result)) {
                ?>
                    <article class="related-card">
                        <img src="<?php echo htmlspecialchars($related['image_url']); ?>" alt="<?php echo htmlspecialchars($related['title']); ?>" class="related-image">
                        <div class="related-content">
                            <h4 class="related-title"><?php echo htmlspecialchars($related['title']); ?></h4>
                            <p class="related-excerpt"><?php echo substr(htmlspecialchars($related['excerpt']), 0, 100) . '...'; ?></p>
                            <div class="related-meta">
                                <span>By <?php echo htmlspecialchars($related['author']); ?></span>
                                <span class="date"><?php echo date('M d, Y', strtotime($related['created_at'])); ?></span>
                            </div>
                            <a href="article.php?id=<?php echo $related['id']; ?>" class="read-more">Read More →</a>
                            <p class="view-count"><span class="views"><?php echo (int) $related['views']; ?></span> views</p>
                        </div>
                    </article>
                <?php
                    }
                } else {
                    echo '<p class="no-related">No related articles found.</p>';
                }
                ?>
            </div>
        </section>
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
