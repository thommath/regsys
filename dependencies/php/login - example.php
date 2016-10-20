<?php
function getConnection(){
  $servername = "";
  $user = "";
  $password = "";
  $dbname = "";

  $conn = new mysqli($servername, $user, $password, $dbname);

  if($conn->connect_error){
  	die("Connection failed: " . $conn->connect_error);
  }else{
    return $conn;
  }
}
function protect($string){
  $salt = "";
  return hash("", $salt . $string);
}
?>
