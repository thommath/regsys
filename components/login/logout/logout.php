<?php
  require_once("../../../php/essentials.php");
  session_start();
  session_destroy();
  session_start();
  $_SESSION['from'] = 'logout';
  $_SESSION['success'] = true;
  header("Location: http://" . $_SERVER['SERVER_NAME'] . "", true);
  die();
?>
