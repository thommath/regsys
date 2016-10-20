<?php
require_once("dependencies/php/login.php");
  session_start();
  $conn = getConnection();

  $errorList = [];


  if(!isset($_POST['username']) || !isset($_POST['password'])){
    array_push($errorList, "The whole thing about login is to make sure you are you, but I can't do that if you don't fill inn your username and password.");
    $_SESSION['from'] = 'login';
    $_SESSION['success'] = false;
    $_SESSION['error'] = $errorList;
    $_SESSION['post'] = $_POST;
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/login", true);
    die();
  }else{
    foreach ($_POST as $key => $value) {
      $_POST[$key] = htmlentities($value);
    }

    $users = $conn->query("SELECT * FROM User WHERE `username`='" . $_POST['username'] . "' AND `password`='" . protect($_POST['password']) . "'");
    if($users->num_rows >= 1){
      $user = $conn->query("SELECT * FROM User WHERE `username`='" . $_POST['username'] . "'")->fetch_assoc();
      $_SESSION['user'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['from'] = 'register';
      $_SESSION['success'] = true;
      header("Location: http://" . $_SERVER['SERVER_NAME'] . "", true);
    }else{
      array_push($errorList, "Nope, that's not it! Please try again or ask a friend");
      $_SESSION['from'] = 'login';
      $_SESSION['success'] = false;
      $_SESSION['error'] = $errorList;
      $_SESSION['post'] = $_POST;
      header("Location: http://" . $_SERVER['SERVER_NAME'] . "/login", true);
      die();
    }
    die();
  }
?>
