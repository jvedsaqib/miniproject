<?php
// Assuming connection to the database is already established
include_once("../../php/connection.php"); 
include('student_session.php');
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['login_user'])) {
    header("location: ../student_login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch job details
$reference_number = $_GET['ref'];
$query = "SELECT * FROM job_posting WHERE reference_number = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $reference_number);
$stmt->execute();
$job = $stmt->get_result()->fetch_assoc();
$stmt->close(); // Close the statement

// Fetch student details
$student_roll = $_SESSION['login_user']; // Assuming student roll is stored in session
$query = "SELECT * FROM students WHERE StudentEmail = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_roll);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close(); // Close the statement

// Check eligibility
$is_eligible = true;
$reasons = [];

if ($student['NumberOfBacklogs'] > $job['backlogs']) {
    $is_eligible = false;
    $reasons[] = "Your number of backlogs exceeds the allowed limit. | Minimum: " . $job['backlogs'] . " but Present: " . $student['NumberOfBacklogs'];
}
if ($student['ClassXPercentage'] < $job['class_x_percentage']) {
    $is_eligible = false;
    $reasons[] = "Your Class X percentage is below the required minimum. | Minimum: " . $job['class_x_percentage'] . " but Present: " . $student['ClassXPercentage'];
}
if ($student['ClassXIIPercentage'] < $job['class_xii_percentage']) {
    $is_eligible = false;
    $reasons[] = "Your Class XII percentage is below the required minimum. | Minimum: " . $job['class_xii_percentage'] . " but Present: " . $student['ClassXIIPercentage'];
}
if ($student['UndergraduateCGPA'] < $job['graduation_cgpa']) {
    $is_eligible = false;
    $reasons[] = "Your graduation CGPA is below the required minimum. | Minimum: " . $job['graduation_cgpa'] . " but Present: " . $student['UndergraduateCGPA'];
}
if (!empty($student['PostgraduateCGPA']) && $student['PostgraduateCGPA'] < $job['postgraduation_cgpa']) {
    $is_eligible = false;
    $reasons[] = "Your postgraduation CGPA is below the required minimum. | Minimum: " . $job['postgraduation_cgpa'] . " but Present: " . $student['PostgraduateCGPA'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <link rel="stylesheet" href="job_details.css">
    <link rel="stylesheet" href="../../css/nav.css">
</head>
<body>
    <div class="topnav" id="home-topnav">
        <nav>
            <a href="student_logout.php" class="split">Sign Out</a>
            <a href="student_home.php">Profile</a>
            <a href="posted_jobs.php">Posted Jobs</a>
        </nav>
   </div>
    <div class="container">
        <h2>Job Details - <?php echo htmlspecialchars($job['reference_number']); ?></h2>
        <table>
            <tr><td>Reference Number:</td><td><?php echo htmlspecialchars($job['reference_number']); ?></td></tr>
            <tr><td>Date Posted:</td><td><?php echo htmlspecialchars($job['post_date']); ?></td></tr>
            <tr><td>Batch Year:</td><td><?php echo htmlspecialchars($job['batch_year']); ?></td></tr>
            <tr><td>Recruiting Company:</td><td><?php echo htmlspecialchars($job['recruiting_company']); ?></td></tr>
            <tr><td>Streams Considered:</td><td><?php echo htmlspecialchars($job['streams']); ?></td></tr>
            <tr><td>Eligibility Criteria:</td><td>Backlogs: <?php echo htmlspecialchars($job['backlogs']); ?>, Minimum CGPA: <?php echo htmlspecialchars($job['minimum_cgpa']); ?></td></tr>
            <tr><td>Selection Mode:</td><td><?php echo htmlspecialchars($job['selection_mode']); ?></td></tr>
            <tr><td>Designation:</td><td><?php echo htmlspecialchars($job['designation']); ?></td></tr>
            <tr><td>Remuneration:</td><td><?php echo htmlspecialchars($job['remuneration']); ?></td></tr>
            <tr><td>Location:</td><td><?php echo htmlspecialchars($job['location']); ?></td></tr>
        </table>
        
        <div class="apply-section">
            <span class="eligibility-status <?php echo $is_eligible ? 'eligible' : 'not-eligible'; ?>">
                <?php echo $is_eligible ? 'Eligible' : 'Not Eligible'; ?>
            </span>
            <form action="apply_job.php" method="post">
                <input type="hidden" name="reference_number" value="<?php echo htmlspecialchars($job['reference_number']); ?>">
                <button type="submit" <?php echo !$is_eligible ? 'disabled' : ''; ?>>Apply</button>
            </form>
        </div>
        
        <?php if (!$is_eligible && !empty($reasons)): ?>
            <div class="ineligibility-reasons">
                <h3>Reasons for Ineligibility:</h3>
                <ul>
                    <?php foreach ($reasons as $reason): ?>
                        <li><?php echo htmlspecialchars($reason); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
