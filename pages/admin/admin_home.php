<?php
   include('admin_session.php');
   print_r($_SESSION);
?>
<html>
<head>
   <title>Admin Panel</title>

   <link rel="stylesheet" href="../../css/nav.css">

</head>
<body>
   <div class="topnav" id="home-topnav">
        <nav>
            <a href="admin_logout.php" class="split">Sign Out</a>
            <a href="jobs/post_job.php">Job Posting</a>
            <a href="jobs/list_job.php">List Jobs</a>
            <a href="../issues/list_issues.php">List Issues</a>
            <a href="../student/add_student_admin.php">Add Student</a>
        </nav>
   </div>
   <h2>Welcome <?php echo $login_session; ?></h2> 



</body>
</html>
