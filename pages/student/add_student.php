<?php

include_once("../../php/connection.php"); 

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    $StudentName = $_POST['StudentName'];
    $StudentRoll = $_POST['StudentRoll'];
    $StudentEmail = $_POST['StudentEmail'];
    $StudentPassword = $_POST['StudentPassword'];
    $StudentPhoneNo = $_POST['StudentPhoneNo'];
    $StudentAltPhoneNo = $_POST['StudentAltPhoneNo'];
    $StudentSex = $_POST['StudentSex'];
    $StudentDOB = $_POST['StudentDOB'];
    $StudentDept = $_POST['StudentDept'];
    $StudentSpecialisation = $_POST['StudentSpecialisation'];
    $ClassXPercentage = $_POST['ClassXPercentage'];
    $ClassXIIPercentage = $_POST['ClassXIIPercentage'];
    $UndergraduateCGPA = $_POST['UndergraduateCGPA'];
    $PostgraduateCGPA = $_POST['PostgraduateCGPA'];
    $NumberOfBacklogs = $_POST['NumberOfBacklogs'];
    $PassoutYear = $_POST['PassoutYear'];

    // Handle file upload
    $base_dir = "images/";
    $target_dir = $base_dir . $StudentDept . "/" . (!empty($StudentSpecialisation) ? $StudentSpecialisation . "/" : "") . $PassoutYear . "/" . $StudentRoll . "/";
    $imageFileType = strtolower(pathinfo($_FILES["StudentPhoto"]["name"], PATHINFO_EXTENSION));
    $final_file = $target_dir . $StudentRoll . ".JPG";

    // Check for upload errors
    if ($_FILES['StudentPhoto']['error'] !== UPLOAD_ERR_OK) {
        echo "File upload error: " . $_FILES['StudentPhoto']['error'];
        exit();
    }

    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
            echo "Failed to create directories: " . $target_dir;
            exit();
        }
    }

    // Move uploaded file to the target directory
    if (move_uploaded_file($_FILES["StudentPhoto"]["tmp_name"], $final_file)) {
        $StudentPhotoPath = $final_file;
        echo "File uploaded successfully!";
    } else {
        echo "Sorry, there was an error uploading your file.";
        error_log("Failed to move uploaded file. Source: " . $_FILES["StudentPhoto"]["tmp_name"] . " Destination: " . $final_file);
        exit();
    }

    $StudentSpecialisation = !empty($_POST['StudentSpecialisation']) ? $_POST['StudentSpecialisation'] : NULL;

    $stmt = $conn->prepare("INSERT INTO students 
        (StudentName, StudentRoll, StudentEmail, StudentPassword, StudentPhoneNo, StudentAltPhoneNo, StudentSex, StudentDOB, StudentDept, StudentSpecialisation, ClassXPercentage, ClassXIIPercentage, UndergraduateCGPA, PostgraduateCGPA, NumberOfBacklogs, PassoutYear, StudentPhotoPath) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sissssssssddddsis", $StudentName, $StudentRoll, $StudentEmail, $StudentPassword, $StudentPhoneNo, $StudentAltPhoneNo, $StudentSex, $StudentDOB, $StudentDept, $StudentSpecialisation, $ClassXPercentage, $ClassXIIPercentage, $UndergraduateCGPA, $PostgraduateCGPA, $NumberOfBacklogs, $PassoutYear, $StudentPhotoPath);

    if ($stmt->execute()) {
    echo "Student added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    echo "DONE ! Redirecting to Home in 5 seconds !";
    sleep(5);

    header("Location: ../../home.php");
        
    

}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="add_student.css">
    <link rel="stylesheet" href="../../css/nav.css">
</head>
<body>
    <div class="topnav" id="home-topnav">
        <nav>
            <a href="student_logout.php" class="split">Sign Out</a>
            <a href="posted_jobs.php">Posted Jobs</a>
        </nav>
   </div>
    <div class="container">
        <h2>Register</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="StudentName">Student Name:</label>
            <input type="text" name="StudentName" required><br>

            <label for="StudentRoll">Student Roll:</label>
            <input type="number" name="StudentRoll" required><br>

            <label for="StudentEmail">Student Email:</label>
            <input type="email" name="StudentEmail" required><br>

            <label for="StudentPassword">Student Password:</label>
            <input type="password" name="StudentPassword" required><br>

            <label for="StudentPhoneNo">Phone Number:</label>
            <input type="text" name="StudentPhoneNo" required><br>

            <label for="StudentAltPhoneNo">Alternate Phone Number:</label>
            <input type="text" name="StudentAltPhoneNo"><br>

            <label for="StudentSex">Sex:</label>
            <select name="StudentSex" required>
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select><br>

            <label for="StudentDOB">Date of Birth:</label>
            <input type="date" name="StudentDOB" required><br>

            <label for="StudentDept">Department:</label>
            <select name="StudentDept" required>
                <option value="BTech">BTech</option>
                <option value="MCA">MCA</option>
                <option value="MTech">MTech</option>
                <option value="BE">BE</option>
            </select><br>

            <label for="StudentSpecialisation">Specialisation:</label>
            <select name="StudentSpecialisation">
                <option value="">None</option>
                <option value="AEIE">AEIE</option>
                <option value="CSBS">CSBS</option>
                <option value="CSE">CSE</option>
                <option value="DS">DS</option>
                <option value="AIML">AIML</option>
                <option value="CE">CE</option>
                <option value="IT">IT</option>
                <option value="ECE">ECE</option>
                <option value="EE">EE</option>
            </select><br>

            <label for="ClassXPercentage">Class X Percentage:</label>
            <input type="number" step="0.01" name="ClassXPercentage" required><br>

            <label for="ClassXIIPercentage">Class XII Percentage:</label>
            <input type="number" step="0.01" name="ClassXIIPercentage" required><br>

            <label for="UndergraduateCGPA">Undergraduate CGPA:</label>
            <input type="number" step="0.01" name="UndergraduateCGPA"><br>

            <label for="PostgraduateCGPA">Postgraduate CGPA:</label>
            <input type="number" step="0.01" name="PostgraduateCGPA"><br>

            <label for="NumberOfBacklogs">Number of Backlogs:</label>
            <input type="number" name="NumberOfBacklogs" value="0"><br>

            <label for="PassoutYear">Passout Year:</label>
            <input type="number" name="PassoutYear" required><br>

            <label for="StudentPhoto">Profile Photo:</label>
            <input type="file" name="StudentPhoto" accept="image/*" required><br>

            <input type="submit" name="submit" value="Add Student">
        </form>
    </div>
</body>
</html>
