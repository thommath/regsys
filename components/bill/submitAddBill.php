<?php
require_once("dependencies/php/login.php");
  session_start();

  $conn = getConnection();

  $errorList = [];

  if(!isset($_POST['sum']) || !isset($_POST['category']) || !isset($_POST['date'])){
      array_push($errorList, "How on earth can you expect us to help you when you give us no information? Please fill inn sum and category");
      $_SESSION['from'] = 'addBill';
      $_SESSION['success'] = false;
      $_SESSION['error'] = $errorList;
      $_SESSION['post'] = $_POST;
      header("Location: http://" . $_SERVER['SERVER_NAME'] . "/bill/addbill.php", true);
      die();
  }else{
    foreach ($_POST as $key => $value) {
      $_POST[$key] = htmlentities($value);
    }

    $accepted = $conn->query("INSERT INTO `Bill`(`voucher`, `description`, `category`, `user`, `sum`, `date`) VALUES (" . $_POST['voucher'] . ", '" . $_POST['description'] . "', " . $_POST['category'] . ", " . $_SESSION['user'] . ", " . $_POST['sum'] . ", '" . $_POST['date'] . "')");

    if(!$accepted){
        array_push($errorList, "Ohh no! It seems like there is a bug in here? It's hiding, can you help me catch it by emailing us? Thank you :)");
        $_SESSION['from'] = 'addBill';
        $_SESSION['success'] = false;
        $_SESSION['error'] = $errorList;
        $_SESSION['post'] = $_POST;
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/bill/addbill.php", true);
        die();
    }else{
        $_SESSION['from'] = 'addBill';
        $_SESSION['success'] = true;
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/regnskap", true);
        die();
    }
  }
?>
