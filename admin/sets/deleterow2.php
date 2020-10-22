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

// Create connection
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_GET["id"];

if($perm === "admin"){
  $sql = "DELETE FROM lisans WHERE id='$id'";
  $result = $conn->query($sql);
}


if(isset($_SESSION["loggedin"])){
  header("location: ../../admin/servers.php");
}

$conn->close();
?>