<?php
include_once("../../../php/connection.php");

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize search variable
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Fetch jobs from the database with search functionality
$sql = "SELECT * FROM job_posting WHERE reference_number LIKE ? OR recruiting_company LIKE ? OR designation LIKE ?";
$stmt = $conn->prepare($sql);
$like_search = "%" . $search . "%";
$stmt->bind_param("sss", $like_search, $like_search, $like_search);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link rel="stylesheet" href="../../../css/nav.css">
    <link rel="stylesheet" href="list_job.css">
</head>
<body>
    <div class="topnav" id="home-topnav">
            <nav>
                <a href="../admin_logout.php" class="split">Sign Out</a>
                <a href="../admin_home.php">Home</a>
                <a href="post_job.php">Job Posting</a>
                <a href="list_job.php">List Jobs</a>
            </nav>
    </div>
    <div class="container">
        <h1>Job Listings</h1>
        <form method="post" action="">
            <input type="text" name="search" placeholder="Search by Reference Number, Company, or Designation" value="<?php echo htmlspecialchars($search); ?>">
            <input type="submit" value="Search">
        </form>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Reference Number</th>
                        <th>Date Posted</th>
                        <th>Batch Year</th>
                        <th>Recruiting Company</th>
                        <th>Streams</th>
                        <th>Minimum CGPA</th>
                        <th>Backlogs</th>
                        <th>Selection Mode</th>
                        <th>Designation</th>
                        <th>Remuneration</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['reference_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['post_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['batch_year']); ?></td>
                            <td><?php echo htmlspecialchars($row['recruiting_company']); ?></td>
                            <td><?php echo htmlspecialchars($row['streams']); ?></td>
                            <td><?php echo htmlspecialchars($row['minimum_cgpa']); ?></td>
                            <td><?php echo htmlspecialchars($row['backlogs']); ?></td>
                            <td><?php echo htmlspecialchars($row['selection_mode']); ?></td>
                            <td><?php echo htmlspecialchars($row['designation']); ?></td>
                            <td><?php echo htmlspecialchars($row['remuneration']); ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No job postings available.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
