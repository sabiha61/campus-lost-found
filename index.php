
<?php
require "db.php";

$lostItems = $conn->query(
    "SELECT item_id, item_name, description, location, item_date, status
     FROM items
     WHERE post_type = 'Lost'
       AND status != 'Returned'
     ORDER BY created_at DESC"
);

$foundItems = $conn->query(
    "SELECT item_id, item_name, description, location, item_date, status
     FROM items
     WHERE post_type = 'Found'
     ORDER BY created_at DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Lost & Found</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="header">
        <div class="container navbar">
            <a href="index.php" class="logo">Campus<span>Find</span></a>

            <nav class="nav-links">
                <a href="index.php" class="active">Home</a>
                <a href="#about">About</a>
                <a href="#lost-items">Lost Items</a>
                <a href="#found-items">Found Items</a>
            </nav>

            <div class="nav-buttons">
                <a href="#login" class="login-btn">Login</a>
                <a href="#register" class="register-btn">Register</a>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container hero-content">
                <span class="hero-tag">YOUR CAMPUS, YOUR COMMUNITY</span>

                <h1>
                    Lost Something?<br>
                    <span>Let's Find It Together.</span>
                </h1>

                <p>
                    Lost your ID card, phone, books, or other belongings?
                    Our campus lost and found platform helps students
                    report lost items and share found belongings easily.
                </p>

                <div class="hero-buttons">
                    <a href="#lost-items" class="primary-btn">
                        Report an Item
                    </a>
                    <a href="#found-items" class="secondary-btn">
                        Explore Found Items
                    </a>
                </div>

                <div class="hero-note">
                    <span class="note-dot"></span>
                    Helping students reconnect with their belongings
                </div>
            </div>
        </section>

        <section class="features section-padding" id="about">
            <div class="container">
                <div class="section-heading">
                    <span class="eyebrow">HOW IT WORKS</span>
                    <h2>A Smarter Way to Find Your Belongings</h2>
                    <p>
                        A simple and organized platform that connects
                        students and helps return lost belongings.
                    </p>
                </div>

                <div class="feature-grid">
                    <article class="feature-card">
                        <div class="feature-icon lost-icon">⌕</div>
                        <h3>Report Lost Items</h3>
                        <p>
                            Report belongings you have lost on campus
                            with their details and last known location.
                        </p>
                        <a href="#lost-items">Report a lost item →</a>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon found-icon">✓</div>
                        <h3>Share Found Items</h3>
                        <p>
                            Help other students by sharing details of
                            belongings you have found on campus.
                        </p>
                        <a href="#found-items">Share a found item →</a>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon safe-icon">⌕</div>
                        <h3>Find Your Belongings</h3>
                        <p>
                            Browse lost and found reports to identify
                            items that may belong to you.
                        </p>
                        <a href="#found-items">Explore items →</a>
                    </article>
                </div>
            </div>
        </section>

        <section class="items-section section-padding" id="lost-items">
            <div class="container">
                <div class="items-heading">
                    <div>
                        <span class="eyebrow">NEED HELP?</span>
                        <h2>Lost Items</h2>
                        <p>
                            Check lost item reports or let others know
                            what you have misplaced.
                        </p>
                    </div>
                    <a href="#report-lost" class="outline-btn">
                        + Report Lost Item
                    </a>
                </div>

                
<div class="item-grid">
    <?php if ($lostItems && $lostItems->num_rows > 0): ?>
        <?php while ($item = $lostItems->fetch_assoc()): ?>
            <article class="item-card">
                <span class="item-badge lost-badge">LOST</span>
                <h3><?= htmlspecialchars($item["item_name"]) ?></h3>
                <p><?= htmlspecialchars($item["description"]) ?></p>
                <p><strong>Location:</strong>
                    <?= htmlspecialchars($item["location"]) ?></p>
                <p><strong>Date:</strong>
                    <?= htmlspecialchars($item["item_date"]) ?></p>
                <p><strong>Status:</strong>
                    <?= htmlspecialchars($item["status"]) ?></p>
            </article>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">⌕</div>
            <h3>No Lost Items Yet</h3>
            <p>Lost item reports will appear here.</p>
        </div>
    <?php endif; ?>
</div>

            </div>
        </section>

        <section class="items-section found-section section-padding"
                 id="found-items">
            <div class="container">
                <div class="items-heading">
                    <div>
                        <span class="eyebrow">HELP SOMEONE TODAY</span>
                        <h2>Found Items</h2>
                        <p>
                            Explore items found by students around
                            your campus.
                        </p>
                    </div>
                    <a href="#report-found" class="outline-btn">
                        + Report Found Item
                    </a>
                </div>

                
<div class="item-grid">
    <?php if ($foundItems && $foundItems->num_rows > 0): ?>
        <?php while ($item = $foundItems->fetch_assoc()): ?>
            <article class="item-card">
                <span class="item-badge found-badge">FOUND</span>
                <h3><?= htmlspecialchars($item["item_name"]) ?></h3>
                <p><?= htmlspecialchars($item["description"]) ?></p>
                <p><strong>Location:</strong>
                    <?= htmlspecialchars($item["location"]) ?></p>
                <p><strong>Date:</strong>
                    <?= htmlspecialchars($item["item_date"]) ?></p>
                <p><strong>Status:</strong>
                    <?= htmlspecialchars($item["status"]) ?></p>
            </article>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">✓</div>
            <h3>No Found Items Yet</h3>
            <p>Found item reports will appear here.</p>
        </div>
    <?php endif; ?>
</div>

            </div>
        </section>

        <section class="cta-section">
            <div class="container cta-content">
                <div>
                    <span class="eyebrow">BE PART OF THE SOLUTION</span>
                    <h2>Found something? Make someone's day.</h2>
                    <p>
                        Your small act of kindness can help another
                        student recover something important.
                    </p>
                </div>
                <a href="#report-found" class="primary-btn">
                    Report an Item
                </a>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container footer-content">
            <a href="index.php" class="logo footer-logo">
                Campus<span>Find</span>
            </a>
            <p>Connecting lost belongings with their owners.</p>
            <p class="copyright">
                &copy; 2026 CampusFind. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>
