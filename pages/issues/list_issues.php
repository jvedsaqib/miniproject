<?php
session_start();

if (!isset($_SESSION['login_user']) || $_SESSION['role'] !== 'ADMIN') {
    header("location: ../admin_login.php");
    exit();
}

$login_session = $_SESSION['login_user'];

include_once("../../php/connection.php");

$query = "SELECT * FROM issues";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of Issues</title>
    <link rel="stylesheet" type="text/css" href="list_issues.css">
    <link rel="stylesheet" type="text/css" href="../../css/nav.css">
</head>
<body>
    <div class="topnav" id="home-topnav">
        <nav>
            <a href="../admin/admin_logout.php" class="split">Sign Out</a>
            <a href="../admin/admin_home.php">Home</a>
            <a href="list_issues.php">List Issues</a>
        </nav>
   </div>
    <div class="container">
        <h2>List of Issues</h2>
        <table>
            <thead>
                    <th>Issue ID</th>
                    <th>Student Roll</th>
                    <th>Issue Details</th>
                    <th>Description</th>
                    <th>Date Raised</th>
                    <th>Action</th>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['IssueID']); ?></td>
                    <td><?php echo htmlspecialchars($row['StudentRoll']); ?></td>
                    <td><?php echo htmlspecialchars($row['Issues']); ?></td>
                    <td><?php echo htmlspecialchars($row['Description']); ?></td>
                    <td><?php echo htmlspecialchars($row['DateRaised']); ?></td>
                    <td>
                        <a href="resolve_issues.php?issue_id=<?php echo urlencode($row['IssueID']); ?>" target="_blank">
                            <button class="resolve-button">Resolve</button>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
