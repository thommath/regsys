<?php
  require_once("../../php/essentials.php");
  session_start();

  $conn = getConnection();

  $errorList = [];

  if(!isset($_POST['name'])){
    array_push($errorList, "I wont ask for much, but I do ask for a name for your category. ");
    $_SESSION['from'] = 'addCategory';
    $_SESSION['success'] = false;
    $_SESSION['error'] = $errorList;
    $_SESSION['post'] = $_POST;
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "?p=addCategory", true);
    die();
  }else{
    foreach ($_POST as $key => $value) {
      $_POST[$key] = htmlentities($value);
    }

    $accepted = $conn->query("INSERT INTO `Category`(`name`, `description`, `user`) VALUES ('" . $_POST['name'] . "', '" . $_POST['desc'] . "', " . $_SESSION['user'] . ")");
    if(!$accepted){
        array_push($errorList, "Sorry, my bad! I guss though I don't have a clue what went wrong. It would help if you could send me an email");
        $_SESSION['from'] = 'addCategory';
        $_SESSION['success'] = false;
        $_SESSION['error'] = $errorList;
        $_SESSION['post'] = $_POST;
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "?p=addCategory", true);
        die();
    }else{
        $_SESSION['from'] = 'addCategory';
        $_SESSION['success'] = true;
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "?p=addCategory", true);
        die();
    }
  }
?>
