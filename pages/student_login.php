<?php 
    include_once("../php/connection.php");
    include_once("login_session_clear.php");
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
    <?php
        session_start();
        $error='';
        if($_SERVER["REQUEST_METHOD"] == "POST") {

            $student_username = $conn->real_escape_string($_POST['email']);
            $student_password = $conn->real_escape_string($_POST['password']);
        
            $sql = "SELECT * FROM student_login_credentials WHERE email = ? AND password = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $student_username, $student_password);
            $stmt->execute();
            $result = $stmt->get_result();
        
            // Check if a user is found
            if ($result->num_rows == 1) {
                $_SESSION['login_user'] = $student_username; // Fixed variable
                header("Location: student/student_home.php");
                exit(); // Ensure that the script stops execution after redirect
            } else {
                $error = "Your Login Email or Password is invalid";
            }
        }
    ?>

    <div class="topnav" id="home-topnav">
            <nav>
                <a href="../home.php">Home</a>
            </nav>
    </div>

    <div class="login-container">
    <div class="login-box">
        <div class="login-header"><b>Login</b></div>
        <div class="login-form">
            <form action="" method="post">
                <label>Email :</label>
                <input type="text" name="email" class="box"/><br /><br />
                <label>Password :</label>
                <input type="password" name="password" class="box" /><br/><br />
                <input type="submit" value=" Submit "/><br />
            </form>
            <div class="error-message"><?php echo $error; ?></div>
        </div>
    </div>
    </div>

</body>
</html>