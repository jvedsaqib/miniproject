<?php 
include_once("../../php/connection.php"); 
session_start();

if (!isset($_SESSION['login_user'])) {
    header("location: ../student_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_roll = $_POST['student_roll'];
    $query = "SELECT * FROM students WHERE StudentRoll = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_roll);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Raise an Issue</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Raise an Issue for Incorrect Details</h2>
    <form action="submit_issue.php" method="post">
        <input type="hidden" name="student_roll" value="<?php echo $student['StudentRoll']; ?>">
        
        <label><input type="checkbox" name="issues[]" value="StudentName"> Name</label><br>
        <label><input type="checkbox" name="issues[]" value="StudentEmail"> Email</label><br>
        <label><input type="checkbox" name="issues[]" value="StudentPhoneNo"> Phone Number</label><br>
        <label><input type="checkbox" name="issues[]" value="StudentAltPhoneNo"> Alternate Phone Number</label><br>
        <label><input type="checkbox" name="issues[]" value="StudentSex"> Sex</label><br>
        <label><input type="checkbox" name="issues[]" value="StudentDOB"> Date of Birth</label><br>
        <label><input type="checkbox" name="issues[]" value="StudentDept"> Department</label><br>
        <label><input type="checkbox" name="issues[]" value="StudentSpecialisation"> Specialization</label><br>
        <label><input type="checkbox" name="issues[]" value="ClassXPercentage"> Class X Percentage</label><br>
        <label><input type="checkbox" name="issues[]" value="ClassXIIPercentage"> Class XII Percentage</label><br>
        <label><input type="checkbox" name="issues[]" value="UndergraduateCGPA"> Undergraduate CGPA</label><br>
        <label><input type="checkbox" name="issues[]" value="PostgraduateCGPA"> Postgraduate CGPA</label><br>
        <label><input type="checkbox" name="issues[]" value="NumberOfBacklogs"> Number of Backlogs</label><br>
        <label><input type="checkbox" name="issues[]" value="PassoutYear"> Passout Year</label><br>
        
        <label>Description:</label><br>
        <textarea name="description" rows="5" cols="50" placeholder="Describe the issue..."></textarea><br>
        
        <button type="submit">Submit Issue</button>
    </form>
</body>
</html>