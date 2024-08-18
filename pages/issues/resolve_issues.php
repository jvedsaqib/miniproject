<?php
session_start();

if (!isset($_SESSION['login_user']) || $_SESSION['role'] !== 'ADMIN') {
    header("location: ../admin_login.php");
    exit();
}

include_once("../../php/connection.php");

if (isset($_GET['issue_id'])) {
    $issue_id = $_GET['issue_id'];

    // Fetch issue details
    $query = "SELECT * FROM issues WHERE IssueID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $issue_id);
    $stmt->execute();
    $issue = $stmt->get_result()->fetch_assoc();

    // Fetch student details
    $student_roll = $issue['StudentRoll'];
    $query = "SELECT * FROM students WHERE StudentRoll = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_roll);
    $stmt->execute();
    $student = $stmt->get_result()->fetch_assoc();

    if (!$student) {
        die("Student not found.");
    }
} else {
    die("Issue ID not specified.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resolve Issue</title>
    <link rel="stylesheet" type="text/css" href="resolve_issues.css">
</head>
<body>
    <div class="container">
        <h2>Resolve Issue</h2>
        <form action="submit_resolve.php" method="post">
            <input type="hidden" name="issue_id" value="<?php echo htmlspecialchars($issue_id); ?>">

            <input type="hidden" name="student_roll" value="<?php echo htmlspecialchars($student['StudentRoll']); ?>">

            <label for="StudentName">Name:</label>
            <input type="text" name="StudentName" value="<?php echo htmlspecialchars($student['StudentName']); ?>" required><br>

            <label for="StudentEmail">Email:</label>
            <input type="email" name="StudentEmail" value="<?php echo htmlspecialchars($student['StudentEmail']); ?>" required><br>

            <label for="StudentPhoneNo">Phone Number:</label>
            <input type="text" name="StudentPhoneNo" value="<?php echo htmlspecialchars($student['StudentPhoneNo']); ?>" required><br>

            <label for="StudentAltPhoneNo">Alternate Phone Number:</label>
            <input type="text" name="StudentAltPhoneNo" value="<?php echo htmlspecialchars($student['StudentAltPhoneNo']); ?>"><br>

            <label for="StudentSex">Sex:</label>
            <input type="text" name="StudentSex" value="<?php echo htmlspecialchars($student['StudentSex']); ?>" required><br>

            <label for="StudentDOB">Date of Birth:</label>
            <input type="date" name="StudentDOB" value="<?php echo htmlspecialchars($student['StudentDOB']); ?>" required><br>

            <label for="StudentDept">Department:</label>
            <input type="text" name="StudentDept" value="<?php echo htmlspecialchars($student['StudentDept']); ?>" required><br>

            <label for="StudentSpecialisation">Specialization:</label>
            <input type="text" name="StudentSpecialisation" value="<?php echo htmlspecialchars($student['StudentSpecialisation']); ?>"><br>

            <label for="ClassXPercentage">Class X Percentage:</label>
            <input type="text" name="ClassXPercentage" value="<?php echo htmlspecialchars($student['ClassXPercentage']); ?>"><br>

            <label for="ClassXIIPercentage">Class XII Percentage:</label>
            <input type="text" name="ClassXIIPercentage" value="<?php echo htmlspecialchars($student['ClassXIIPercentage']); ?>"><br>

            <label for="UndergraduateCGPA">Undergraduate CGPA:</label>
            <input type="text" name="UndergraduateCGPA" value="<?php echo htmlspecialchars($student['UndergraduateCGPA']); ?>"><br>

            <label for="PostgraduateCGPA">Postgraduate CGPA:</label>
            <input type="text" name="PostgraduateCGPA" value="<?php echo htmlspecialchars($student['PostgraduateCGPA']); ?>"><br>

            <label for="NumberOfBacklogs">Number of Backlogs:</label>
            <input type="text" name="NumberOfBacklogs" value="<?php echo htmlspecialchars($student['NumberOfBacklogs']); ?>"><br>

            <label for="PassoutYear">Passout Year:</label>
            <input type="text" name="PassoutYear" value="<?php echo htmlspecialchars($student['PassoutYear']); ?>"><br>

            <button type="submit">Update and Resolve</button>
        </form>
    </div>
</body>
</html>
