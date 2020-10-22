<?php

$id = $_GET["id"];

include '../../config.php';
// Try and connect using the info above.
$connect = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($connect->connect_error)  {
    die("Connection failed: " . $connect->connect_error);
} 

if(!empty($id)){
    $sqll = "SELECT * FROM accounts WHERE verfcode='$id'";
    $resultt = $connect->query($sqll);
    if ($resultt->num_rows > 0) {
    // output data of each row
        while($roww = $resultt->fetch_assoc()) {
            if($roww['permission'] == "unverified"){
                $sqlla = "UPDATE accounts SET permission='creator' WHERE verfcode='$id'";
                $resultta = $connect->query($sqlla);
                echo "Başarıyla onaylandı.";
                header('Location: ../../');
            }else{
                echo "Zaten onaylandı.";
                header('Location: ../../');
            }
        }
    }
}else{
    header('Location: ../../');
}



