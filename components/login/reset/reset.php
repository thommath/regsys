<?php
  require_once("../../php/login.php");
  session_start();
  $conn = getConnection();

  $errorList = [];


  if(!isset($_POST['input'])){
    array_push($errorList, "The whole thing about login is to make sure you are you, but I can't do that if you don't fill inn your username and password.");
    $_SESSION['from'] = 'reset';
    $_SESSION['success'] = false;
    $_SESSION['error'] = $errorList;
    $_SESSION['post'] = $_POST;
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "?p=login/reset", true);
    die();
  }else{
    foreach ($_POST as $key => $value) {
      $_POST[$key] = htmlentities($value);
    }

    $users = $conn->query("SELECT id, email FROM User WHERE `username`='" . $_POST['input'] . "' OR `email`='" . protect($_POST['input']) . "'");

    if($users->num_rows >= 1){
      $user = $users->fetch_assoc();
      $key = protect(rand(0, 999999)) . protect(rand(0, 999999));
      $result = $conn->query("INSERT INTO `ResetPassword` (`link_key`, `link_limit`, `user`) VALUES ('" . $key . "', '" . date("Y-m-d", strtotime("+1 days")) . "', '" . $user['id'] . "')");

      email($user['email'], "Password reset Regsys", "Hi!\n\n You have asked for a password reset for your account at Regsys. If you didn't, just ignore this. \n\n<a href\"http://regsys.raptorphoto.com/p=login/reset&key=" . $key . "\">Click here</a>");
      
      $_SESSION['success'] = true;
      header("Location: http://" . $_SERVER['SERVER_NAME'] . "", true);
    }else{
      array_push($errorList, "Nope, that's not it! Please try again or ask a friend");
      $_SESSION['from'] = 'input';
      $_SESSION['success'] = false;
      $_SESSION['error'] = $errorList;
      $_SESSION['post'] = $_POST;
      header("Location: http://" . $_SERVER['SERVER_NAME'] . "?p=login/reset", true);
      die();
    }
    die();
  }
?>
