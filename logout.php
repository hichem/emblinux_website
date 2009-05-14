<?php
     session_start();
     session_unset();
     $_SESSION = array();
     session_destroy();
     header('location:index.php');
?>