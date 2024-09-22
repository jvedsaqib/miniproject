<?php
include_once("../../../php/connection.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Sanitize and validate POST variables
$new_stts = trim($_POST['new_status']);
$application_id = intval($_POST['application_id']);
$student_roll = intval($_POST['student_roll']); // Assuming it's an integer, change this if it's a string
$job_post_id = intval($_POST['job_post_id']);

// Validate if necessary data is available
if (empty($new_stts) || empty($student_roll) || empty($job_post_id)) {
    die('Invalid input. Please make sure all fields are filled.');
}

// Prepare and execute the SQL update statement
$sql = "UPDATE applications
        SET application_status = ?
        WHERE student_roll = ? AND job_post_id = ?";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("sii", $new_stts, $student_roll, $job_post_id);
$execution_result = $stmt->execute();

if ($execution_result === false) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}

// Redirect to list_applications.php after successful update
header("Location: list_applications.php");
exit;

// $sql = "SELECT applications.*, students.*, job_posting.* 
//         FROM applications
//         JOIN students ON applications.student_roll = students.StudentRoll
//         JOIN job_posting ON applications.job_post_id = job_posting.id
//         WHERE 1=1"; 

?>
