<?php
   session_start();
   unset($_SESSION["signed_in"]);
   unset($_SESSION["user_id"]);
   unset($_SESSION["user_name"]);
   unset($_SESSION["user_level"]);
   
   echo 'You have cleaned session';
   header('Refresh: 2; URL = signin.php');
?>