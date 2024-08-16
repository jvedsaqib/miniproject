<?php 
    include_once("php\connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css\nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="topnav" id="home-topnav">
        <nav>
            <a class="active" href="#">Home</a> 
            <a href="#">Summary</a> 
            <a href="pages\student_login.php">Student Login</a> 
            <a href="pages\admin_login.php" class="split">Admin Login</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a> 
        </nav>
    </div>


    <section class="in-progress">

        <img src="work.jpg" alt="">

    </section>

</body>
</html>

<script>
    function myFunction() {
        var x = document.getElementById("home-topnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
</script>
