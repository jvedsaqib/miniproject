<?php 
   include_once("../../php/connection.php"); 
   include('student_session.php');
   session_start();

   // print_r($_SESSION);

   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);

   if (!isset($_SESSION['login_user'])) {
      header("location: ../student_login.php"); // Redirect to login page if not logged in
      exit();
   }

   $student_email = $_SESSION['login_user'];
   $query = "SELECT * FROM students WHERE StudentEmail = ?";
   $stmt = $conn->prepare($query);
   $stmt->bind_param("s", $student_email);
   $stmt->execute();
   $result = $stmt->get_result();
   $student = $result->fetch_assoc();
   
?>
<html>
<head>
   <title>Student</title>
   <link rel="stylesheet" href="../../css/nav.css">
   <link rel="stylesheet" href="student_home.css">
</head>
<body>
   <div class="topnav" id="home-topnav">
   <nav>
      <a href="student_logout.php" class="split">Sign Out</a>
      <a href="posted_jobs.php">Posted Jobs</a>
   </nav>
   </div>
   <h1>Welcome <?php echo $login_session; ?></h1> 
   <div class="container">
        <div class="student-photo">
            <img src="<?php echo $student['StudentPhotoPath']; ?>" alt="Student Photo">
        </div>
        <table>
            <tr><td>Student Roll:</td><td><?php echo $student['StudentRoll']; ?></td></tr>
            <tr><td>Email:</td><td><?php echo $student['StudentEmail']; ?></td></tr>
            <tr><td>Phone Number:</td><td><?php echo $student['StudentPhoneNo']; ?></td></tr>
            <tr><td>Alternate Phone Number:</td><td><?php echo $student['StudentAltPhoneNo']; ?></td></tr>
            <tr><td>Sex:</td><td><?php echo $student['StudentSex']; ?></td></tr>
            <tr><td>Date of Birth:</td><td><?php echo $student['StudentDOB']; ?></td></tr>
            <tr><td>Department:</td><td><?php echo $student['StudentDept']; ?></td></tr>
            <tr><td>Specialization:</td><td><?php echo $student['StudentSpecialisation']; ?></td></tr>
            <tr><td>Class X Percentage:</td><td><?php echo $student['ClassXPercentage']; ?></td></tr>
            <tr><td>Class XII Percentage:</td><td><?php echo $student['ClassXIIPercentage']; ?></td></tr>
            <tr><td>Undergraduate CGPA:</td><td><?php echo $student['UndergraduateCGPA']; ?></td></tr>
            <tr><td>Postgraduate CGPA:</td><td><?php echo $student['PostgraduateCGPA']; ?></td></tr>
            <tr><td>Number of Backlogs:</td><td><?php echo $student['NumberOfBacklogs']; ?></td></tr>
            <tr><td>Passout Year:</td><td><?php echo $student['PassoutYear']; ?></td></tr>
        </table>
        <form action="../issues/raise_issue.php" method="post">
            <input type="hidden" name="student_roll" value="<?php echo $student['StudentRoll']; ?>">
            <button type="submit">Raise an Issue</button>
        </form>
    </div>
</body>
</html>