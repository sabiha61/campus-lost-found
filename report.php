
<?php
require "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $item_name = trim($_POST["item_name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $location = trim($_POST["location"] ?? "");
    $item_date = $_POST["item_date"] ?? "";
    $post_type = $_POST["post_type"] ?? "";
    $category_id = (int)($_POST["category_id"] ?? 0);

    if (
        $item_name === "" ||
        $description === "" ||
        $location === "" ||
        $item_date === "" ||
        !in_array($post_type, ["Lost", "Found"], true) ||
        $category_id <= 0
    ) {
        $message = "Please fill in all fields correctly.";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO items
            (item_name, description, location, item_date, post_type, category_id, status)
            VALUES (?, ?, ?, ?, ?, ?, 'Active')"
        );

        $stmt->bind_param(
            "sssssi",
            $item_name,
            $description,
            $location,
            $item_date,
            $post_type,
            $category_id
        );

        if ($stmt->execute()) {
            $message = "Item report submitted successfully!";
        } else {
            $message = "Could not submit the report.";
        }

        $stmt->close();
    }
}

$categories = $conn->query(
    "SELECT category_id, category_name FROM categories ORDER BY category_name"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report an Item | CampusFind</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container" style="max-width: 650px; padding-top: 40px; padding-bottom: 40px;">
    <h1>Report a Lost or Found Item</h1>

    <?php if ($message !== ""): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" action="report.php">
        <label for="item_name">Item Name</label><br>
        <input id="item_name" type="text" name="item_name"
               maxlength="100" required><br><br>

        <label for="post_type">Report Type</label><br>
        <select id="post_type" name="post_type" required>
            <option value="">Select type</option>
            <option value="Lost">Lost</option>
            <option value="Found">Found</option>
        </select><br><br>

        <label for="category_id">Category</label><br>
        <select id="category_id" name="category_id" required>
            <option value="">Select category</option>
            <?php while ($category = $categories->fetch_assoc()): ?>
                <option value="<?= (int)$category["category_id"] ?>">
                    <?= htmlspecialchars($category["category_name"]) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="description">Description</label><br>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="location">Location</label><br>
        <input id="location" type="text" name="location"
               maxlength="150" required><br><br>

        <label for="item_date">Date Lost or Found</label><br>
        <input id="item_date" type="date" name="item_date" required><br><br>

        <button type="submit" class="primary-btn">Submit Report</button>
    </form>

    <p><a href="index.php">Back to Home</a></p>
</div>

</body>
</html>
