<?php
session_start();
require 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user's ID

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    if (!empty($comment)) {
        $query = "INSERT INTO comments (user_id, comment) VALUES ('$user_id', '$comment')";
        mysqli_query($conn, $query);
    }
}

// Fetch all comments
$query = "SELECT comments.comment, comments.date_posted, users.username 
          FROM comments 
          INNER JOIN users ON comments.user_id = users.id 
          ORDER BY comments.date_posted DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Section</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="form-section">
    <h2>Post a Comment</h2>
    <form action="comment.php" method="POST">
        <textarea name="comment" rows="4" placeholder="Write your comment here..." required></textarea>
        <button type="submit">Submit</button>
    </form>
</div>

<div class="comment-section">
    <h2>Comments</h2>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="comment-box">
            <strong><?php echo htmlspecialchars($row['username']); ?></strong>
            <p><?php echo htmlspecialchars($row['comment']); ?></p>
            <span class="date"><?php echo $row['date_posted']; ?></span>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>
