function getConnection(){
  $servername = "pdb6.awardspace.net";
  $user = "2063185_regsys";
  $password = "DetKanHendeJegGlemtePass0rdet";
  $dbname = "2063185_regsys";

  $conn = new mysqli($servername, $user, $password, $dbname);

  if($conn->connect_error){
  	die("Connection failed: " . $conn->connect_error);
  }else{
    return $conn;
  }
}
function protect($string){
  $salt = "A@igqSmNb4CmA8OPKIzY71z(ARcp8_s1";
  return hash("sha256", $salt . $string);
}
