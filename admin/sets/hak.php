<?php
    session_start();

    $perm = $_SESSION['perm'];

    if($perm != "admin"){
      header('Location: ../../creator/index.php');
    exit;
    }

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../index.html");
    exit;
    }
    include '../../config.php';

    $link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
 
    // Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    
    // Escape user inputs for security
    $id = mysqli_real_escape_string($link, $_REQUEST['id']);
    $hak = mysqli_real_escape_string($link, $_REQUEST['hak']);

    if($perm == "admin"){
        $sql = "UPDATE accounts SET hak='$hak' WHERE id = '$id'";
        if(mysqli_query($link, $sql)){

        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }

        header('Location: ../index.php'); //If book.php is your main page where you list your all records
        exit;
    }
    

    // Close connection
    mysqli_close($link);

?>
