<?php include 'db-connect.php'; ?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>TechBlog - Technology News</title>
    <!-- add links to your CSS files here -->
    <link href="style.css" rel="stylesheet" />
    <link href="layout-sidebar-left.css" rel="stylesheet" />
    <link href="ex2-enhancements.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation Bar -->
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
    <!-- Hero Section -->
    <header class="hero" id="home">
        <div class="hero-content">
            <h1>Welcome to TechBlog</h1>
            <p class="hero-subtitle">Your daily source for technology news and insights</p>
            <button class="hero-button" id="readLatestBtn" type="button">Read Latest Articles</button>
        </div>
    </header>
    <!-- Main Content Area -->
    <div class="search-wrapper"><input id="searchInput" placeholder="Search articles..." type="text" /></div>
    <main class="container">
        <!-- Featured Article -->
        <section class="featured" id="featured">
            <h2 class="section-title">Featured Article</h2>
            <article class="featured-article">
                <img alt="AI Technology" class="featured-image" src="assets/AITechnology.png" />
                <div class="featured-content">
                    <span class="category">Artificial Intelligence</span>
                    <h3 class="article-title">The Future of AI in 2024</h3>
                    <p class="article-excerpt">
                        Artificial Intelligence continues to revolutionize industries worldwide. From healthcare to
                        finance, AI is transforming the way we live and work. Discover the latest trends and predictions
                        for AI in 2024.
                    </p>
                    <div class="article-meta">
                        <span class="author">By John Doe</span>
                        <span class="date">January 15, 2024</span>
                        <span class="read-time">5 min read</span>
                    </div>
                    <a class="read-more" href="#">Read Full Article →</a>
                </div>
            </article>
        </section>
        <!-- Articles Grid -->
        <section class="articles" id="articles">
            <h2 class="section-title">Latest Articles</h2>
            <div class="sort-controls"><label for="sortSelect">Sort by:</label><select id="sortSelect">
                    <option value="default">Default</option>
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="popular">Most View</option>
                </select></div>
                <div class="articles-grid">
    <?php
    $sql = "SELECT * FROM articles ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($article = mysqli_fetch_assoc($result)) {
    ?>
        <article class="article-card">
            <img
                src="<?php echo htmlspecialchars($article['image_url']); ?>"
                alt="<?php echo htmlspecialchars($article['title']); ?>"
                class="article-image"
            />
            <div class="article-body">
                <span class="category"><?php echo htmlspecialchars($article['category']); ?></span>

                <h3 class="article-title">
                    <?php echo htmlspecialchars($article['title']); ?>
                </h3>

                <p class="article-excerpt">
                    <?php echo htmlspecialchars($article['excerpt']); ?>
                </p>

                <div class="article-meta">
                    <span class="author">By <?php echo htmlspecialchars($article['author']); ?></span>
                    <span class="date"><?php echo date('M d, Y', strtotime($article['created_at'])); ?></span>
                </div>

                <p class="view-count">
                    <span class="views"><?php echo (int)$article['views']; ?></span> views
                </p>

                <a class="read-more" href="article.php?id=<?php echo $article['id']; ?>">
                    Read More →
                </a>
            </div>
        </article>
    <?php
        }
    } else {
        echo "<p>No articles found.</p>";
    }
    ?>
</div>
        </section>
        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Newsletter Signup -->
            <div class="widget newsletter">
                <h3>Subscribe to Newsletter</h3>
                <p>Get the latest tech news delivered to your inbox weekly.</p>
                <form class="newsletter-form">
                    <input class="email-input" placeholder="Your email address" type="email" />
                    <button class="subscribe-button" type="submit">Subscribe</button>
                </form>
            </div>
            <!-- Popular Articles -->
            <div class="widget popular">
                <h3>Popular Articles</h3>
                <ul class="popular-list">
                    <li><a href="#">Introduction to Machine Learning</a></li>
                    <li><a href="#">JavaScript ES2024 Features</a></li>
                    <li><a href="#">Best Programming Languages 2024</a></li>
                    <li><a href="#">Blockchain Beyond Cryptocurrency</a></li>
                    <li><a href="#">5G Technology Explained</a></li>
                </ul>
            </div>
            <!-- Categories -->
            <div class="widget categories">
    <h3>Categories</h3>

    <?php
    $cat_sql = "SELECT c.*, COUNT(a.id) AS article_count
                FROM categories c
                LEFT JOIN articles a ON c.name = a.category
                GROUP BY c.id, c.name, c.slug, c.description";
    $cat_result = mysqli_query($conn, $cat_sql);
    ?>

    <ul class="category-list">
        <?php while ($cat = mysqli_fetch_assoc($cat_result)) { ?>
            <li>
                <a href="category.php?slug=<?php echo urlencode($cat['slug']); ?>">
                    <?php echo htmlspecialchars($cat['name']); ?> (<?php echo $cat['article_count']; ?>)
                </a>
            </li>
        <?php } ?>
    </ul>
</div>
        </aside>
    </main>
    <!-- Footer -->
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
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
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