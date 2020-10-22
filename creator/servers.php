<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.html');
	exit;	
}

include '../config.php';

$connect = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

error_reporting(0);

if ($connect->connect_error)  {
    die("Connection failed: " . $connect->connect_error);
} 
//MySQL query goes here
$user = $_SESSION["name"];
$sqll = "SELECT * FROM accounts WHERE username='$user'";
$resultt = $connect->query($sqll);
if ($resultt->num_rows > 0) {
// output data of each row
    while($roww = $resultt->fetch_assoc()) {
        $hak = $roww['hak'];
        $_SESSION['hak'] = $hak;

        $perm = $roww['permission'];
        $_SESSION['perm'] = $perm;     
        
    }
}

// $date = date("Y-m-d", strtotime("0 day"));
// $sqlla = "SELECT * FROM accounts WHERE endtime='$date'";
// $resultta = $connect->query($sqlla);
// if ($resultta->num_rows > 0) {
//     while($rowwa = $resultta->fetch_assoc()) {
        
//     }
// }



$connect->close();

if($perm == "admin"){
    header('Location: ../admin/index.php');
	exit;
}

?>


<html>
    <head>
        <title>
        V1 Admin Panel
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/0eb6ecdd2f.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div id="main-content">
            <div id="nav-bar">
                <a href="#"><button style="font-size:25px;">KEL<BR>V1</button></a>
                <a href="index.php"><button><i class="fas fa-user"></i></button></a>
                <a href="servers.php"><button><i class="fas fa-terminal"   id="active"></i></button></a>
                <a href="../logout.php"><button><i class="fas fa-sign-out-alt"></i></button></a>
            </div>
            <div id="content">
                <h1>Servers | <?=$_SESSION['name']?></h1>
                <table id="display-table">
                    <thead>
                        <th>Sahip</th>
                        <th>Sunucu Adı</th>
                        <th>Lisans Durumu</th>
                        <th>Sunucu Durumu</th>
                        <th>Oyuncu Sayısı</th>
                        <th>Sil </th>
                        <th>İşlemler</th>
                    </thead>
                    <tbody>
                    <?php
                        include '../config.php';

                        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
                        // Check connection
                        if ($conn->connect_error)  {
                            die("Connection failed: " . $conn->connect_error);
                        } 
                        //MySQL query goes here
                        
                        $sql = "SELECT * FROM lisans WHERE sahip='$user'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        // output data of each row
                            while($row = $result->fetch_assoc()) {
                                $server_settings['title'] = $row['name']; // Display için sunucu adı
                                $server_settings['ip'] = $row['ip']; // Sunucu bağlantısı için IP adresi
                                $server_settings['port'] = "30120"; // Basic port 30120 olmalı (eğer değiştirilmediyse)
                                $content = json_decode(file_get_contents("http://".$server_settings['ip'].":".$server_settings['port']."/info.json"), true);
                                if($content):
                                    $maxclient =  $content['sv_maxClients'];
                                    $gta5_players = file_get_contents("http://".$server_settings['ip'].":".$server_settings['port']."/players.json");
                                	$content = json_decode($gta5_players, true);
                                	$pl_count = count($content);
                                	$SRV_STATUS = "<font style='color: green;'>Online</font>";
                                else:
                                    $pl_count = "0";
                                	$SRV_STATUS = "<font style='color: red;'>Offline</font>";
                                endif;    
                                if($row['stat'] === "true"){
                                    $aktif = "<font style='color: green;'>Active</font>";
                                }
                                if($row['stat'] === "false"){
                                    $aktif = "<font style='color: red;'>Not Active</font>";
                                }
                                $content = json_decode(file_get_contents("http://".$server_settings['ip'].":".$server_settings['port']."/info.json"), true);

                                echo '<tr><td>' . $user. '</td>
                                <td>' . $row['name']. ' - ' . $row['ip']. '</td>
                                <td>' . $aktif. '</td>
                                <td>' . $SRV_STATUS. '</td>
                                <td>' . $pl_count . '</td>
                                <td id="backblue" onclick="location.href = &#39;'.$link.'/admin/sets/deleterow2.php?id=' . $row['id'] . '&#39;">Sil</td>
                                <td id="backred" onclick="location.href = &#39;'.$link.'/admin/sets/change-status2.php?id=' . $row['id']. '&#39;">Aktif / Deaktif</td></tr>';

                                      
                                
                            }
                        }
                        $conn->close();
                    ?>
                    </tbody>
                </table>
                
            </div>
            
        </div>
    </body>
</html>