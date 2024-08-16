<?php
// Assuming connection to database is already established
    include_once("../../php/connection.php"); 
    include('student_session.php');
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (!isset($_SESSION['login_user'])) {
        header("location: ../student_login.php"); // Redirect to login page if not logged in
        exit();
    }

// Fetch posted jobs
$query = "SELECT reference_number, post_date, recruiting_company FROM job_posting";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posted Jobs</title>
    <link rel="stylesheet" href="posted_jobs.css">
    <link rel="stylesheet" href="../../css/nav.css">
</head>
<body>
    <div class="topnav" id="home-topnav">
        <nav>
            <a href="student_logout.php" class="split">Sign Out</a>
            <a href="student_home.php">Profile</a>
        </nav>
   </div>
    <div class="container">
        <h2>Posted Jobs</h2>
        <table>
            <thead>
                <tr>
                    <th>Reference Number</th>
                    <th>Date Posted</th>
                    <th>Recruiting Company</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($job = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($job['reference_number']); ?></td>
                    <td><?php echo htmlspecialchars($job['post_date']); ?></td>
                    <td><?php echo htmlspecialchars($job['recruiting_company']); ?></td>
                    <td><a href="job_details.php?ref=<?php echo htmlspecialchars($job['reference_number']); ?>" class="details-button">View Details</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
