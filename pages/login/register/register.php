<?php
require_once("dependencies/php/essentials.php");
  session_start();

  $conn = getConnection();
  $errorList = [];

  if(!(isset($_POST['username']) && $_POST['username'] != "") ||
      !(isset($_POST['password']) && $_POST['password'] != "") ||
      !(isset($_POST['password2']) && $_POST['password2'] != "") ||
      !(isset($_POST['email']) && $_POST['email'] != "")){
    array_push($errorList, "I know it's boring to fill in these fields, but you do have to fill in those marked with *. Oh, right. I removed those. It seems like you have to guess, I give you a clue; you need to fill in minimum 4");
  }

  if($_POST['password2'] != $_POST['password']){
    array_push($errorList, "This is why you have to type in the password two times. Please make up your mind about what password you want to use and fill them in again.");
  }else{
    $_POST['password'] = protect($_POST['password']);
  }

  foreach ($_POST as $key => $value) {
    $_POST[$key] = htmlentities($value);
  }

  $users = $conn->query("SELECT * FROM User WHERE `username`='" . $_POST['username'] . "' OR `email`='" . $_POST['email'] . "'");
  if($users->num_rows >= 1){
    $user = $users->fetch_assoc();
    if($user['username'] == $_POST['username']){
      array_push($errorList, "Doesn't this suck, the best usernames are always taken... Here use this awesome unique username!\n" . protect(rand(-99999, 99999)));
    }else if($user['email'] == $_POST['email']){
      array_push($errorList, "Ohh, you thought you could use the same email twice? Nope!");
    }

  }


  if(count($errorList) != 0){
    $_SESSION['from'] = 'register';
    $_SESSION['success'] = false;
    $_SESSION['error'] = $errorList;
    $_SESSION['post'] = $_POST;
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "?p=login/register", true);
    die();
  }else{
    $accepted = $conn->query("INSERT INTO `User`(`username`, `password`, `firstname`, `lastname`, `gender`, `email`, `birthday`) VALUES ('" . $_POST['username'] . "', '" . $_POST['password'] . "', '" . $_POST['firstname'] . "', '" . $_POST['lastname'] . "', '" . $_POST['gender'] . "', '" . $_POST['email'] . "', '" . $_POST['birthday'] . "')");
    if(!$accepted){
      array_push($errorList, "Well... This is embarrasing... Seems like we aren't able to create your user because... There is a spaceship attacking our servers! GTG, Try again soon!");
//      array_push($errorList, "INSERT INTO `User`(`username`, `password`, `firstname`, `lastname`, `gender`, `email`, `year`) VALUES ('" . $_POST['username'] . "', '" . $_POST['password'] . "', " . $_POST['firstname'] . "', " . $_POST['lastname'] . "', " . $_POST['gender'] . "', " . $_POST['email'] . "', " . $_POST['year'] . ")");
      $_SESSION['from'] = 'register';
      $_SESSION['success'] = false;
      $_SESSION['error'] = $errorList;
      $_SESSION['post'] = $_POST;
      header("Location: http://" . $_SERVER['SERVER_NAME'] . "?p=login/register", true);
      die();
    }
    $user = $conn->query("SELECT `id` FROM User WHERE `username`='" . $_POST['username'] . "'")->fetch_assoc();
    $_SESSION['user'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['from'] = 'register';
    $_SESSION['success'] = true;
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "", true);
    die();
  }
?>
