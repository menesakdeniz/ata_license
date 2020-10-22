<?php
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../index.html");
    exit;
}

$perm = $_SESSION['perm'];

if($perm != "admin"){
  header('Location: ../../creator/index.php');
exit;
}

include '../../config.php';


$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$userr = $_SESSION["name"];
$id = $_GET["id"];



if($perm == "admin"){
  $sqlll = "SELECT * FROM accounts WHERE id=$id";
  $resulttt = $conn->query($sqlll);
  
  if ($resulttt->num_rows > 0) {
    while($row = $resulttt->fetch_assoc()) {
        $accname = $row['username'];
        if($accname === $userr){
                     
          if(isset($_SESSION["loggedin"])){
            header("location: ../../admin/accounts.php");
          }
                 
        }else{
                
          $sql = "DELETE FROM accounts WHERE id='$id'";
          $result = $conn->query($sql);

          $sqll = "DELETE FROM lisans WHERE sahip='$accname'";
          $result = $conn->query($sqll);
          if(isset($_SESSION["loggedin"])){
            header("location: ../../admin/accounts.php");
          }
          
        }             
    }
  }
}


//if(isset($_SESSION["loggedin"])){
//  header("location: ../../creator/index.php");
//}

$conn->close();
?>