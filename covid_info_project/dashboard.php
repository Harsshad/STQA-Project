<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

require 'db_connect.php';  // Include database connection

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment = htmlspecialchars($_POST['comment']);
    $query = "INSERT INTO comments (user_id, comment) VALUES ('$user_id', '$comment')";
    mysqli_query($conn, $query);
}

$comments = mysqli_query($conn, "SELECT users.username, comments.comment, comments.date_posted FROM comments INNER JOIN users ON comments.user_id = users.id ORDER BY comments.date_posted DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Welcome to the Dashboard</h1>
        <nav>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <section class="comments-section">
        <form action="dashboard.php" method="POST">
            <textarea name="comment" placeholder="Share your thoughts..." required></textarea>
            <button type="submit">Post Comment</button>
        </form>

        <h2>Comments</h2>
        <?php while ($row = mysqli_fetch_assoc($comments)) { ?>
            <div class="comment-box">
                <p><strong><?php echo $row['username']; ?>:</strong> <?php echo $row['comment']; ?></p>
                <p class="date"><?php echo $row['date_posted']; ?></p>
            </div>
        <?php } ?>
    </section>

    <footer>
        <p>&copy; 2024 COVID Info. Stay Safe!</p>
    </footer>

    <script src="animation.js"></script>
</body>
</html>
