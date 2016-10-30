
if(!isset($_SESSION['user']) && !startsWith($_SERVER['REQUEST_URI'], "/login")){
  header("Location: http://" . $_SERVER['SERVER_NAME'] . "/login", true);
  die();
}else if(isset($_SESSION['user']) && startsWith($_SERVER['REQUEST_URI'], "/login") && !startsWith($_SERVER['REQUEST_URI'], "/login/reset")){
  header("Location: http://" . $_SERVER['SERVER_NAME'], true);
  die();
}else if(startsWith($_SERVER['REQUEST_URI'], "/login/reset/updatePassword/index.php") && !isset($_GET['key'])){
  header("Location: http://" . $_SERVER['SERVER_NAME'] . "/login/reset", true);
  die();
}
