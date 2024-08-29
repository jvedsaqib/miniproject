<?php
include_once("../../php/connection.php"); 
include_once("../../php/mail_details.php"); 
include('student_session.php');
session_start();

require('../../php/phpmailer/src/PHPMailer.php');
require('../../php/phpmailer/src/SMTP.php');
require('../../php/phpmailer/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['login_user'])) {
    header("location: ../student_login.php"); 
    exit();
}

$reference_number = $_POST['reference_number'];
$job_posting_id = $_POST['job_posting_id'];
$student_rollno = $_POST['student_rollno'];

$query = "SELECT * FROM job_posting WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $job_posting_id);
$stmt->execute();
$job = $stmt->get_result()->fetch_assoc();
$stmt->close();

$query = "INSERT INTO applications (student_roll, job_post_id, application_date) VALUES (?, ?, NOW())";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $student_rollno, $job_posting_id);
$stmt->execute();
$stmt->close();


$query = "SELECT * FROM students WHERE StudentRoll = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_rollno);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

$student_email = $student['StudentEmail'];
$student_name = $student['StudentName'];
$subject = "Application Received - Further Steps Required";

$body = "
<html>
<head>
<title>Application Received</title>
</head>
<body>
<p>Dear Student,</p>
<p>Your application for the position at <b>" . htmlspecialchars($job['recruiting_company']) . "</b> has been received by the TPO.</p>
<p>Please complete the company’s application process by filling out the application form using the link below:</p>
<br><br>
<h3><a href='" . htmlspecialchars($job['job_link']) . "'>Company Application Form</a></h3>
<p>Best of luck!</p>
<p>Sincerely,</p>
<p>Training and Placement Office</p>
</body>
</html>
";

// Use PHPMailer to send the email
$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';

$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = $send_email;
$mail->Password   = $email_password; 
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;
$mail->SMTPDebug  = 0; // Set to 2 for debugging output

$mail->setFrom('jvedsaqib1@gmail.com', 'ADMIN');
$mail->addReplyTo('jvedsaqib1@gmail.com', 'no-reply');
$mail->addAddress($student_email, $student_name);
$mail->Subject    = $subject;
$mail->msgHTML($body);

try {
    $mail->send();
    
    header('location: posted_jobs.php');

} catch (Exception $e) {
    echo "Failed to send notification email: " . $mail->ErrorInfo;
}

?>
