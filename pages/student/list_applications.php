<?php
include_once("../../php/connection.php"); 
include('student_session.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['login_user'])) {
    header("location: ../student_login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the logged-in student's email from the session
$login_session = $_SESSION['login_user'];

// Fetch student roll number based on email
$sql = "SELECT StudentRoll FROM students WHERE StudentEmail = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $login_session);
$stmt->execute();
$result = $stmt->get_result();
$student_data = $result->fetch_assoc();
$StudentRoll = $student_data['StudentRoll'];

// Fetch the applied jobs by the student
$sql = "SELECT applications.application_id, applications.job_post_id, applications.application_status, applications.application_date, 
               job_posting.recruiting_company, job_posting.selection_date 
        FROM applications
        JOIN job_posting ON applications.job_post_id = job_posting.id
        WHERE applications.student_roll = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $StudentRoll);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applied Jobs</title>
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="list_applications.css">
</head>
<body>
    <div class="topnav" id="home-topnav">
   <nav>
      <a href="student_logout.php" class="split">Sign Out</a>
      <a href="student_home.php">Profile</a>
      <a href="list_applications.php">List Applied Jobs</a>
   </nav>
   </div>
    <h2>Applied Jobs for <?php echo htmlspecialchars($login_session); ?></h2>

    <table border="1">
        <thead>
            <tr>
                <th>Application ID</th>
                <th>Job Post ID</th>
                <th>Application Status</th>
                <th>Application Date</th>
                <th>Company Name</th>
                <th>Selection Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Iterate through the fetched result and display each row in the table
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['application_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['job_post_id']) . "</td>";
                echo "<td class=status-".strtolower(htmlspecialchars($row['application_status'])).">";
                echo htmlspecialchars($row['application_status']);
                echo "</td>";
                echo "<td>" . htmlspecialchars($row['application_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['recruiting_company']) . "</td>";
                echo "<td>" . htmlspecialchars($row['selection_date']) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
