<?php
include('admin_session.php');
include_once("../../php/connection.php");

// Check if the user is admin head
$isAdminHead = ($login_session === 'ADMIN');

// Handle form submission for adding a notice
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isAdminHead) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO notices (title, content, created_by) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $login_session);
    $stmt->execute();
}

// Handle deletion of a notice
if (isset($_GET['delete_id']) && $isAdminHead) {
    $delete_id = $_GET['delete_id'];
    $delete_stmt = $conn->prepare("DELETE FROM notices WHERE id = ?");
    $delete_stmt->bind_param("i", $delete_id);
    $delete_stmt->execute();
}

// Fetch all notices
$result = $conn->query("SELECT * FROM notices ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notice Board</title>
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="admin_home.css">
</head>
<body>
    <div class="topnav" id="home-topnav">
        <nav>
            <a href="admin_logout.php" class="split">Sign Out</a>
            <a href="jobs/post_job.php">Job Posting</a>
            <a href="jobs/list_job.php">List Jobs</a>
            <a href="jobs/list_applications.php">List Applications</a>
            <a href="../issues/list_issues.php">List Issues</a>
            <a href="../student/add_student_admin.php">Add Student</a>
        </nav>
    </div>

    <h2>Welcome <?php echo $login_session; ?></h2>

    <?php if ($isAdminHead): ?>
        <h3>Add Notice</h3>
        <form method="POST">
            <input type="text" name="title" placeholder="Notice Title" required>
            <textarea name="content" placeholder="Notice Content" required></textarea>
            <input type="submit" value="Post Notice">
        </form>
    <?php endif; ?>

    <h3>Notices</h3>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <strong><?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?></strong>
                <p><?php echo htmlspecialchars($row['content'], ENT_QUOTES, 'UTF-8'); ?></p>
                <small>Posted by <?php echo htmlspecialchars($row['created_by'], ENT_QUOTES, 'UTF-8'); ?> on <?php echo $row['created_at']; ?></small>
                <?php if ($isAdminHead): ?>
                    <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this notice?');">Delete</a>
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>

<?php
$conn->close();
?>
