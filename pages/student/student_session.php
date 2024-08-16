<?php
   session_start();

   if(!isset($_SESSION['login_user'])){
      header("location: ../student_login.php");
      die();
   }
   $login_session = $_SESSION['login_user'];
?>