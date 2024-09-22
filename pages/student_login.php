<?php 
include_once("../php/connection.php");
include_once("../php/mail_details.php");
include_once("login_session_clear.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../php/phpmailer/src/PHPMailer.php';
require '../php/phpmailer/src/SMTP.php';
require '../php/phpmailer/src/Exception.php';

session_start();
$error = '';
$otp_sent = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    
    $sql = "SELECT * FROM students WHERE StudentEmail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $otp = rand(100000, 999999); 
        $expires_at = time() + 300; 
        
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expires_at'] = $expires_at;
        $_SESSION['login_email'] = $email;
        
        $mail = new PHPMailer(true);
        $mail->CharSet    = 'UTF-8';
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $send_email;
        $mail->Password   = $email_password; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('jvedsaqib1@gmail.com', 'OTP-Miniproject');
        $mail->addAddress($email);
        $mail->Subject    = 'Your OTP Code';
        $mail->Body       = 'Your OTP code is: ' . $otp;

        try {
            $mail->send();
            $otp_sent = true;
        } catch (Exception $e) {
            $error = "Failed to send OTP: " . $mail->ErrorInfo;
        }
    } else {
        $error = "Email not registered";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="topnav" id="home-topnav">
        <nav>
            <a href="../index.php">Home</a>
        </nav>
    </div>

    <div class="login-container">
        <div class="login-box">
            <div class="login-header"><b>Login</b></div>
            <div class="login-form">
                <?php if (!$otp_sent) { ?>
                <form action="" method="post">
                    <label>Email :</label>
                    <input type="text" name="email" class="box"/><br /><br />
                    <input type="submit" value="Send OTP"/><br />
                </form>
                <?php } ?>
                
                <?php if ($otp_sent) { ?>
                <form action="verify_otp.php" method="post">
                    <label>OTP :</label>
                    <input type="text" name="otp" class="box"/><br /><br />
                    <input type="submit" value="Verify OTP"/><br />
                </form>
                <?php } ?>
                
                <div class="error-message"><?php echo $error; ?></div>
            </div>
        </div>
    </div>

    <section>
        <h3>If not registered, click below</h3>
        <a href="student/add_student.php">REGISTER</a>
    </section>

</body>
</html>

