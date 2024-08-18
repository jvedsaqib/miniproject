<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['login_user']) || $_SESSION['role'] !== 'ADMIN') {
    header("location: ../admin_login.php");
    exit();
}

$login_session = $_SESSION['login_user'];

include_once("../../php/connection.php");

require('../../php/phpmailer/src/PHPMailer.php');
require('../../php/phpmailer/src/SMTP.php');
require('../../php/phpmailer/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $issue_id = intval($_POST['issue_id']);
    $student_roll = intval($_POST['student_roll']);
    $student_name = $_POST['StudentName'];
    $student_email = $_POST['StudentEmail'];
    $student_phone = $_POST['StudentPhoneNo'];
    $student_alt_phone = $_POST['StudentAltPhoneNo'];
    $student_sex = $_POST['StudentSex'];
    $student_dob = $_POST['StudentDOB'];
    $student_dept = $_POST['StudentDept'];
    $student_specialization = !empty($_POST['StudentSpecialisation']) ? $_POST['StudentSpecialisation'] : NULL;
    $class_x_percentage = !empty($_POST['ClassXPercentage']) ? floatval($_POST['ClassXPercentage']) : NULL;
    $class_xii_percentage = !empty($_POST['ClassXIIPercentage']) ? floatval($_POST['ClassXIIPercentage']) : NULL;
    $undergraduate_cgpa = !empty($_POST['UndergraduateCGPA']) ? floatval($_POST['UndergraduateCGPA']) : NULL;
    $postgraduate_cgpa = !empty($_POST['PostgraduateCGPA']) ? floatval($_POST['PostgraduateCGPA']) : NULL;
    $number_of_backlogs = !empty($_POST['NumberOfBacklogs']) ? intval($_POST['NumberOfBacklogs']) : NULL;
    $passout_year = !empty($_POST['PassoutYear']) ? intval($_POST['PassoutYear']) : NULL;

    $query = "UPDATE students SET 
        StudentName = ?, 
        StudentEmail = ?, 
        StudentPhoneNo = ?, 
        StudentAltPhoneNo = ?, 
        StudentSex = ?, 
        StudentDOB = ?, 
        StudentDept = ?, 
        StudentSpecialisation = ?, 
        ClassXPercentage = ?, 
        ClassXIIPercentage = ?, 
        UndergraduateCGPA = ?, 
        PostgraduateCGPA = ?, 
        NumberOfBacklogs = ?, 
        PassoutYear = ?
        WHERE StudentRoll = ?";
    
    $stmt = $conn->prepare($query);
    
    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    
    $bind_result = $stmt->bind_param("ssssssssddddiii", 
        $student_name, 
        $student_email, 
        $student_phone, 
        $student_alt_phone, 
        $student_sex, 
        $student_dob, 
        $student_dept, 
        $student_specialization, 
        $class_x_percentage, 
        $class_xii_percentage, 
        $undergraduate_cgpa, 
        $postgraduate_cgpa, 
        $number_of_backlogs, 
        $passout_year, 
        $student_roll);
    
    if ($bind_result === false) {
        die("Bind failed: " . htmlspecialchars($stmt->error));
    }
    
    if ($stmt->execute()) {

        $query = "SELECT Issues, Description, DateRaised FROM issues WHERE IssueID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $issue_id);
        $stmt->execute();
        $stmt->bind_result($issue, $description, $time_raised);
        $stmt->fetch();
        $stmt->close();


        $query = "DELETE FROM issues WHERE IssueID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $issue_id);
        $stmt->execute();
        $stmt->close();

        // HTML email body
        $body = '
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; }
                    table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                    th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
                    th { background-color: #f4f4f4; }
                    h2 { color: #333; }
                </style>
            </head>
            <body>
                <h2>Issue Resolved Notification</h2>
                <p>Hello ' . htmlspecialchars($student_name) . ',</p>
                <p>We are pleased to inform you that your issue has been resolved. Here are the details of the issue:</p>
                <table>
                    <tr>
                        <th>Issue ID</th>
                        <td>' . htmlspecialchars($issue_id) . '</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>' . htmlspecialchars($student_email) . '</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>' . htmlspecialchars($student_name) . '</td>
                    </tr>
                    <tr>
                        <th>Roll Number</th>
                        <td>' . htmlspecialchars($student_roll) . '</td>
                    </tr>
                    <tr>
                        <th>Issue</th>
                        <td>' . htmlspecialchars($issue) . '</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>' . htmlspecialchars($description) . '</td>
                    </tr>
                    <tr>
                        <th>Time Raised</th>
                        <td>' . htmlspecialchars($time_raised) . '</td>
                    </tr>
                </table>
                <p>Thank you for your patience.</p>
                <p>Best regards,<br>Admin</p>
            </body>
            </html>
        ';

        // Use PHPMailer to send the email
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jvedsaqib1@gmail.com'; // Your email address
        $mail->Password   = ''; // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->SMTPDebug  = 0; // Set to 2 for debugging output

        $mail->setFrom('jvedsaqib1@gmail.com', 'ADMIN');
        $mail->addReplyTo('jvedsaqib1@gmail.com', 'no-reply');
        $mail->addAddress($student_email, $student_name);
        $mail->Subject    = 'Issue #' . $issue_id . ' Resolved';
        $mail->msgHTML($body);

        try {
            $mail->send();
            echo "Notification email sent successfully.";
        } catch (Exception $e) {
            echo "Failed to send notification email: " . $mail->ErrorInfo;
        }

        // Close the current tab
        echo "<script>
            window.opener = window.open('', '_self');
            window.opener.close();
            window.close();
        </script>";
    } else {
        echo "Error updating student record: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>
