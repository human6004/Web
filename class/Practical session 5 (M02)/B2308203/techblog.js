document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const darkModeToggle = document.getElementById('darkModeToggle');
    const navLinks = document.querySelectorAll('.nav-menu a');
    const backToTopBtn = document.getElementById('backToTop');
    const articleCards = document.querySelectorAll('.article-card');
    const sortSelect = document.getElementById('sortSelect');
    const articlesGrid = document.querySelector('.articles-grid');
    const originalArticles = articlesGrid ? Array.from(articlesGrid.querySelectorAll('.article-card')) : [];
    const newsletterPopup = document.getElementById('newsletterPopup');
    const closePopup = document.getElementById('closePopup');
    const popupSubscribeBtn = document.getElementById('popupSubscribeBtn');
    const popupEmail = document.getElementById('popupEmail');
    const heroButton = document.getElementById('readLatestBtn');
    const sidebarNewsletterForm = document.querySelector('.newsletter-form');
    const sidebarEmailInput = document.querySelector('.newsletter-form .email-input');

    function parseArticleDate(card) {
        const rawDate = card.querySelector('.date') ? card.querySelector('.date').textContent.trim() : '';
        const parsedDate = new Date(rawDate);
        return isNaN(parsedDate.getTime()) ? new Date(0) : parsedDate;
    }

    function initSearchFilter() {
        const searchTerm = (searchInput.value || '').toLowerCase().trim();

        articleCards.forEach(function (card) {
            const title = (card.querySelector('.article-title')?.textContent || '').toLowerCase();
            const excerpt = (card.querySelector('.article-excerpt')?.textContent || '').toLowerCase();
            const isMatch = title.includes(searchTerm) || excerpt.includes(searchTerm);

            card.style.display = isMatch ? '' : 'none';
        });
    }

    function updateDarkModeIcon() {
        if (!darkModeToggle) return;
        darkModeToggle.textContent = document.body.classList.contains('dark-mode') ? '☀️' : '🌙';
    }

    function initDarkMode() {
        document.body.classList.toggle('dark-mode');

        if (document.body.classList.contains('dark-mode')) {
            localStorage.setItem('darkMode', 'enabled');
        } else {
            localStorage.removeItem('darkMode');
        }

        updateDarkModeIcon();
    }

    function initSmoothScroll(event) {
        const targetId = this.getAttribute('href');

        if (!targetId || !targetId.startsWith('#')) {
            return;
        }

        const targetSection = document.querySelector(targetId);

        if (targetSection) {
            event.preventDefault();
            targetSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    function initBackToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    function loadViewCounts() {
        articleCards.forEach(function (card, index) {
            const viewSpan = card.querySelector('.views');
            if (!viewSpan) return;

            const storedViews = localStorage.getItem(`article-${index}-views`) || '0';
            viewSpan.textContent = storedViews;

            card.addEventListener('click', function (event) {
                const clickedLink = event.target.closest('a, button, select, input, label');
                if (clickedLink && clickedLink.id === 'sortSelect') return;

                const currentViews = parseInt(viewSpan.textContent, 10) || 0;
                const newViews = currentViews + 1;

                viewSpan.textContent = String(newViews);
                localStorage.setItem(`article-${index}-views`, String(newViews));
            });
        });
    }

    function initSort() {
        if (!articlesGrid) return;

        const sortBy = this.value;
        let articles = [];

        if (sortBy === 'default') {
            articles = [...originalArticles];
        } else {
            articles = Array.from(articlesGrid.querySelectorAll('.article-card'));

            if (sortBy === 'newest') {
                articles.sort(function (a, b) {
                    return parseArticleDate(b) - parseArticleDate(a);
                });
            }

            if (sortBy === 'oldest') {
                articles.sort(function (a, b) {
                    return parseArticleDate(a) - parseArticleDate(b);
                });
            }

            if (sortBy === 'popular') {
                articles.sort(function (a, b) {
                    const viewA = parseInt(a.querySelector('.views')?.textContent || '0', 10);
                    const viewB = parseInt(b.querySelector('.views')?.textContent || '0', 10);
                    return viewB - viewA;
                });
            }
        }

        articles.forEach(function (article) {
            articlesGrid.appendChild(article);
        });
    }

    function closeNewsletterPopup() {
        if (!newsletterPopup) return;
        newsletterPopup.style.display = 'none';
        newsletterPopup.setAttribute('aria-hidden', 'true');
        localStorage.setItem('newsletterPopupClosed', 'true');
    }

    function initNewsletterPopup() {
        const email = (popupEmail?.value || '').trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(email)) {
            alert('Please enter a valid email address.');
            if (popupEmail) popupEmail.focus();
            return;
        }

        localStorage.setItem('newsletterSubscribed', 'true');
        localStorage.removeItem('newsletterPopupClosed');

        if (sidebarEmailInput) {
            sidebarEmailInput.value = email;
        }

        alert('Subscription successful. Thank you for joining TechBlog!');
        if (newsletterPopup) {
            newsletterPopup.style.display = 'none';
            newsletterPopup.setAttribute('aria-hidden', 'true');
        }
    }

    function initSidebarNewsletter(event) {
        event.preventDefault();
        const email = (sidebarEmailInput?.value || '').trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(email)) {
            alert('Please enter a valid email address.');
            if (sidebarEmailInput) sidebarEmailInput.focus();
            return;
        }

        localStorage.setItem('newsletterSubscribed', 'true');
        alert('Thanks for subscribing to TechBlog!');
        if (newsletterPopup) {
            newsletterPopup.style.display = 'none';
            newsletterPopup.setAttribute('aria-hidden', 'true');
        }
    }

    function maybeShowNewsletterPopup() {
        if (!newsletterPopup) return;

        const alreadySubscribed = localStorage.getItem('newsletterSubscribed') === 'true';
        const popupClosed = localStorage.getItem('newsletterPopupClosed') === 'true';

        if (!alreadySubscribed && !popupClosed) {
            setTimeout(function () {
                newsletterPopup.style.display = 'block';
                newsletterPopup.setAttribute('aria-hidden', 'false');
            }, 5000);
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', initSearchFilter);
    }

    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', initDarkMode);
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
        }
        updateDarkModeIcon();
    }

    navLinks.forEach(function (link) {
        link.addEventListener('click', initSmoothScroll);
    });

    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', initBackToTop);

        window.addEventListener('scroll', function () {
            backToTopBtn.style.display = window.pageYOffset > 300 ? 'flex' : 'none';
        });
    }

    if (heroButton) {
        heroButton.addEventListener('click', function () {
            const articlesSection = document.getElementById('articles');
            if (articlesSection) {
                articlesSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    }

    // loadViewCounts();

    if (sortSelect) {
        sortSelect.addEventListener('change', initSort);
    }

    if (closePopup) {
        closePopup.addEventListener('click', closeNewsletterPopup);
    }

    if (popupSubscribeBtn) {
        popupSubscribeBtn.addEventListener('click', initNewsletterPopup);
    }

    if (sidebarNewsletterForm) {
        sidebarNewsletterForm.addEventListener('submit', initSidebarNewsletter);
    }

    maybeShowNewsletterPopup();
});
