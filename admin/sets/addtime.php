<?php
    session_start();

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.html");
    exit;
    }

    include '../../config.php';

    $link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
 
    // Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    
    $user = $_SESSION['name'];
    
    $sqlll = "SELECT * FROM accounts WHERE username='$user'";
    $result = $link->query($sqlll);
    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            $hak = $row['hak'];
            $isfreeze = $row['isfreeze'];
            $perm = $row['permission'];
        }
    }

    
if($perm == "admin"){
        $hak = htmlentities($_POST['hak'], ENT_QUOTES, "UTF-8");
        $time = htmlentities($_POST['time'], ENT_QUOTES, "UTF-8");
        $kullanici = htmlentities($_POST['user'], ENT_QUOTES, "UTF-8");
    
    
        
        //echo $updatetime;
        $newdate = date("Y-m-d", strtotime("$time day"));
        $sqlaa = "UPDATE accounts SET endtime='$newdate' WHERE  username = '$kullanici'";
        if(mysqli_query($link, $sqlaa)){
            $sqla = "UPDATE accounts SET hak='$hak' WHERE username = '$kullanici'";
            if(mysqli_query($link, $sqla)){
                
            } else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
            }        
        } else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }

            


        header('Location: ../accounts.php'); //If book.php is your main page where you list your all records
        exit;
}else{
    header('Location: ../accounts.php'); //If book.php is your main page where you list your all records
    exit;
}
    
    // Attempt insert query execution
    

    // Close connection
    mysqli_close($link);

?>
