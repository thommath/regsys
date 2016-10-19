<?php
require_once("dependencies/php/login.php");
  session_start();
  $conn = getConnection();

  $errorList = [];


  $reset = $conn->query("SELECT * FROM ResetPassword WHERE `link_key`='" . $_POST['key'] . "' AND `link_limit`>='" . date("Y-m-d h:i:s") . "' AND `used`=0");

  if($reset->num_rows >= 1){
    $reset = $reset->fetch_assoc();

    if(!isset($_POST['password']) || !isset($_POST['password2'])){
      array_push($errorList, "The whole thing about login is to make sure you are you, but I can't do that if you don't fill inn your username and password.");
      $_SESSION['from'] = 'reset/updatePassword';
      $_SESSION['success'] = false;
      $_SESSION['error'] = $errorList;
      $_SESSION['post'] = $_POST;
      header("Location: http://" . $_SERVER['SERVER_NAME'] . "?p=login/reset/updatePassword&key=" . $_POST['key'], true);
      die();
    }else if($_POST['password'] != $_POST['password2']){
      array_push($errorList, "Not equal passwords.");
      $_SESSION['from'] = 'reset/updatePassword';
      $_SESSION['success'] = false;
      $_SESSION['error'] = $errorList;
      $_SESSION['post'] = $_POST;
      header("Location: http://" . $_SERVER['SERVER_NAME'] . "?p=login/reset/updatePassword&key=" . $_POST['key'], true);
      die();
    }else{
      foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlentities($value);
      }

      $conn->query("UPDATE `User` SET `password`='" . protect($_POST['password']) . "' WHERE `id`=" . $reset['user']);
      $conn->query("UPDATE `ResetPassword` SET `used`='1' WHERE `id`=" . $reset['id']);
      $user = $conn->query("SELECT * FROM User WHERE `id`='" . $reset['user'] . "'")->fetch_assoc();

      $_SESSION['user'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['from'] = 'reset/updatePassword';
      $_SESSION['success'] = true;
      $_SESSION['message'] = "Your password is updated, please log in";
      header("Location: http://" . $_SERVER['SERVER_NAME'] . "", true);
      die();
    }
  }else{
    array_push($errorList, "Invalid Key");
    $_SESSION['from'] = 'reset/updatePassword';
    $_SESSION['success'] = false;
    $_SESSION['error'] = $errorList;
    $_SESSION['post'] = $_POST;
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "?p=login/reset/updatePassword", true);
    die();
  }
?>
