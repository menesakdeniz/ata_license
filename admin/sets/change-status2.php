<?php
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../index.html");
    exit;
}

include '../../config.php';

$perm = $_SESSION["perm"];

if($perm != "admin"){
  header('Location: ../../creator/index.php');
exit;
}

// Create connection
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_GET["id"];

if($perm === "admin"){
  $user = $_SESSION["name"];
  $sql = "SELECT * FROM lisans WHERE id='$id'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
  // output data of each row
      while($row = $result->fetch_assoc()) {
          if($row['stat'] === "true"){
            $sqll = "UPDATE lisans SET stat='false' WHERE id = '$id'";

            if ($conn->query($sqll) === TRUE) {
              echo "sikuel";

            } else {
              echo "Error updating record: " . $conn->error;
            }
          }
          if($row['stat'] === "false"){
            $sqll = "UPDATE lisans SET stat='true' WHERE id = '$id'";

            if ($conn->query($sqll) === TRUE) {
              echo "sikuel";

            } else {
              echo "Error updating record: " . $conn->error;
            }
          }         
     }
  }
}


if(isset($_SESSION["loggedin"])){
  header("location: ../../admin/servers.php");
}

$conn->close();
?>