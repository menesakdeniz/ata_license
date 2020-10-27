<?php
    session_start();

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.html");
    exit;
    }
    include 'config.php';

    $link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_PASS);
 
    // Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    
    
    // Escape user inputs for security
    $name = mysqli_real_escape_string($link, $_REQUEST['name']);
    $serial = mysqli_real_escape_string($link, $_REQUEST['serial']);
    $ip = mysqli_real_escape_string($link, $_REQUEST['ip']);
    $user = $_SESSION['name'];
    $webhook = mysqli_real_escape_string($link, $_REQUEST['webhook']);
    $iporserial = htmlentities($_POST['iporserial'], ENT_QUOTES, "UTF-8");
    
    $sqlll = "SELECT * FROM accounts WHERE username='$user'";
    $result = $link->query($sqlll);
    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            $hak = $row['hak'];
            $isfreeze = $row['isfreeze'];
        }
    }

    
if($isfreeze == "false"){
    if($hak > 0){
        $sql = "INSERT INTO lisans (name, serial, ip, sahip, webhook, cins) VALUES ('$name', '$serial', '$ip', '$user', '$webhook', '$iporserial')";
        if(mysqli_query($link, $sql)){
            
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }

            $newhak = $hak - 1;

            $sqll = "UPDATE accounts SET hak='$newhak' WHERE username = '$user'";
                    
            if ($link->query($sqll) === TRUE) {
              echo "sikuel";
                  
            } else {
              echo "Error updating record: " . $link->error;
            }

        header('Location: creator/index.php'); //If book.php is your main page where you list your all records
        exit;
    }else{
        header('Location: creator/index.php'); //If book.php is your main page where you list your all records
        exit;
    }
}else{
    header('Location: creator/index.php'); //If book.php is your main page where you list your all records
    exit;
}
    
    // Attempt insert query execution
    

    // Close connection
    mysqli_close($link);

?>
