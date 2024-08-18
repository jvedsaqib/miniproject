<?php
   session_start();

   if(!isset($_SESSION['login_user'])){
      header("location: ../admin_login.php");
      die();
   }

   // print_r($_SESSION);
   $login_session = $_SESSION['login_user'];
   $role = $_SESSION['role'];
?>