<?php 
    include_once("php/connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .summary-home {
            width: 100%;
            height: calc(100vh - 50px); /* (100vh - the height of the topnav) */
        }

        .summary-home iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

    </style>
</head>
<body>

    <div class="topnav" id="home-topnav">
        <nav>
            <a class="active" href="#">Home</a> 
            <!-- <a href="pages/summary/summary_home.php">Summary</a>  -->
            <a href="pages/student_login.php">Student Login</a> 
            <a href="pages/admin_login.php" class="split">Admin Login</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a> 
        </nav>
    </div>

    <div class="summary-home">
        <iframe align="center" src="pages/summary/summary_home.php?iframe=true"></iframe>
    </div>

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
