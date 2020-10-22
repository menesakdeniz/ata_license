<?php

if (!empty($_SERVER['HTTP_CLIENT_IP']))   
  {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
  }
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
  {
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
//whether ip is from remote address
else
  {
    $ip_address = $_SERVER['REMOTE_ADDR'];
  }

include '../config.php';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if(!empty($_GET['id'])){
  $id = $_GET['id'];
  $sql = "SELECT id, name, serial, ip, stat, sahip, webhook, cins FROM lisans WHERE ip = '$ip_address' AND serial = '$id' AND cins = 'ipandserial' ";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $status = $row["stat"];
      if($status === "true"){
          echo "True";    
      }elseif ($status == "false"){
      echo "False"; 
      }
    }
  } else{
    echo "False";
  }
}elseif(empty($_GET['id'])){
  $sql = "SELECT id, name, serial, ip, stat, sahip, webhook, cins FROM lisans WHERE ip = '$ip_address' AND cins = 'ip'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $status = $row["stat"];
      if($status === "true"){
          echo "True";    
      }elseif ($status == "false"){
      echo "False"; 
      }
    }
  } else{
    echo "False";
  } 
}else{
  echo "False";
}

?>
