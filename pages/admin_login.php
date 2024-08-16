<?php 
    include_once("../php/connection.php");
    include_once("login_session_clear.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    
    <?php
        //  error_reporting(E_ALL);
        //  ini_set('display_errors', 1);
     
         session_start();
         $error = '';

        if($_SERVER["REQUEST_METHOD"] == "POST") {


            $admin_username = $conn->real_escape_string($_POST['username']);
            $admin_password = $conn->real_escape_string($_POST['password']);
        
            $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $admin_username, $admin_password);
            $stmt->execute();
            $result = $stmt->get_result();
        
            // Check if a user is found
            if ($result->num_rows == 1) {
                $_SESSION['login_user'] = $admin_username; // Fixed variable
                header("Location: admin/admin_home.php");
                exit();
            } else {
                $error = "Your Login Name or Password is invalid";
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
                <label>Username :</label>
                <input type="text" name="username" class="box"/><br /><br />
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