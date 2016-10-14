<?php
  require_once("../../../../php/login.php");
  session_start();
  $conn = getConnection();

  $errorList = [];


  if(!isset($_POST['password']) || !isset($_POST['password2'])){
    array_push($errorList, "The whole thing about login is to make sure you are you, but I can't do that if you don't fill inn your username and password.");
    $_SESSION['from'] = 'reset/updatePassword';
    $_SESSION['success'] = false;
    $_SESSION['error'] = $errorList;
    $_SESSION['post'] = $_POST;
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "?p=login/reset/updatePassword", true);
    die();
  }else if($_POST['password'] != $_POST['password']){
    array_push($errorList, "Not equal passwords.");
    $_SESSION['from'] = 'reset/updatePassword';
    $_SESSION['success'] = false;
    $_SESSION['error'] = $errorList;
    $_SESSION['post'] = $_POST;
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "?p=login/reset/updatePassword", true);
    die();
  }else{
    foreach ($_POST as $key => $value) {
      $_POST[$key] = htmlentities($value);
    }

    $users = $conn->query("UPDATE `User` SET `password`='" . protect($_POST['password']) . "' WHERE `id`=" . $_POST['id']);
    $users = $conn->query("UPDATE `ResetPassword` SET `used`='1' WHERE `user`=" . $_POST['id']);

    if($users){
      $_SESSION['success'] = true;
      $_SESSION['message'] = "Your password is updated, please log in";
      header("Location: http://" . $_SERVER['SERVER_NAME'] . "", true);
    }else{
      array_push($errorList, "Uhm, just try again...");
      $_SESSION['from'] = 'reset/updatePassword';
      $_SESSION['success'] = false;
      $_SESSION['error'] = $errorList;
      $_SESSION['post'] = $_POST;
      header("Location: http://" . $_SERVER['SERVER_NAME'] . "?p=login/reset/updatePassword", true);
      die();
    }
    die();
  }
?>
