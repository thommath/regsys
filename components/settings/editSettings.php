<?php
  require_once("../../php/login.php");
  session_start();

  $conn = getConnection();

  $errorList = [];

  if(!isset($_POST['startDay'])){
      array_push($errorList, "How on earth can you expect us to help you when you give us no information? Please fill inn sum and category");
      $_SESSION['from'] = 'editSettings';
      $_SESSION['success'] = false;
      $_SESSION['error'] = $errorList;
      $_SESSION['post'] = $_POST;
      header("Location: http://" . $_SERVER['SERVER_NAME'] . "?p=settings", true);
      die();
  }else{
    foreach ($_POST as $key => $value) {
      $_POST[$key] = htmlentities($value);
    }

    $accepted = $conn->query("UPDATE `Settings` SET `startDay`='" . $_POST['startDay'] . "' WHERE `user`=" . $_SESSION['user']);

    if(!$accepted){
        array_push($errorList, "Ohh no! It seems like there is a bug in here? It's hiding, can you help me catch it by emailing us? Thank you :)");
        $_SESSION['from'] = 'editSettings';
        $_SESSION['success'] = false;
        $_SESSION['error'] = $errorList;
        $_SESSION['post'] = $_POST;
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "?p=settings", true);
        die();
    }else{
        $_SESSION['from'] = 'editSettings';
        $_SESSION['success'] = true;
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "?p=settings", true);
        die();
    }
  }
?>
