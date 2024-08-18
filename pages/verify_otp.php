<?php
session_start();
include_once("../php/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = intval($_POST['otp']);
    $email = $_SESSION['login_email'];
    
    if ($entered_otp === $_SESSION['otp'] && time() <= $_SESSION['otp_expires_at']) {
        
        $_SESSION['role'] = 'STUDENT';
        $_SESSION['login_user'] = $email;
        header("Location: student/student_home.php");
        exit();
    } else {
        echo "Invalid or expired OTP";
        echo "<a href='student_login.php'> Try Again </a>";
    }
}
?>
