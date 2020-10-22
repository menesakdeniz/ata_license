<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.html');
	exit;	
}


include '../config.php';

$connect = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

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

$date = date("Y-m-d", strtotime("0 day"));
$sqlla = "SELECT * FROM accounts WHERE endtime='$date'";
$resultta = $connect->query($sqlla);
if ($resultta->num_rows > 0) {
    while($rowwa = $resultta->fetch_assoc()) {
        
    }
}



$connect->close();

if($perm != "admin"){
    header('Location: ../creator/index.php');
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
                <a href="#"><button>KEL V1</button></a>
                <a href="#"><button><i class="fas fa-user"  id="active"></i></button></a>
                <a href="servers.php"><button><i class="fas fa-terminal"></i></button></a>
                <a href="accounts.php"><button><i class="fas fa-users"></i></button></a>
                <a href="../logout.php"><button><i class="fas fa-sign-out-alt"></i></button></a>
            </div>
            <div id="content">
                <h1>Lisanslar | <?=$_SESSION['name']?></h1>
                <p>Kalan Hakkınız: <?=$hak?></p>
                <form id="addlicenseform" action="../insert.php" method="post">
                    <input type="text" id="name" name="name" placeholder="Sunucu Adı" required>
                    <input type="text" id="ip" name="ip" placeholder="IP Adresi" required>
                    <input type="text" id="serial" name="serial" placeholder="Bios Seri Numarası" required>
                    <input type="text" id="webhook" name="webhook" placeholder="Discord Webhook Link" required>
                    <select name="iporserial" id="iporserial" class="select">
                        <option value="ip">IP Lisanslama</option>
                        <option value="ipandserial">IP ve Serial Lisanslama</option>
                    </select>
                    <button id="addlicense" type="submit"><i class="fas fa-plus"></i> Sunucu Ekle</button>
                </form>
                <table id="display-table">
                    <thead>
                        <th>Sahip</th>
                        <th>Sunucu Adı</th>
                        <th>Lisans Durumu</th>
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
                        
                        $sql = "SELECT * FROM lisans";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        // output data of each row
                            while($row = $result->fetch_assoc()) {
                                $user = $row['sahip'];
                                if($row['stat'] === "true"){
                                    $aktif = "Aktif";
                                }
                                if($row['stat'] === "false"){
                                    $aktif = "Aktif Değil";
                                }

                                echo '<tr><td>' . $user. '</td>
                                <td>' . $row['name']. ' - ' . $row['ip']. '</td>
                                <td>' . $aktif. '</td>
                                <td id="backblue" onclick="location.href = &#39;/admin/sets/deleterow.php?id=' . $row['id']. '&#39;">Sil</td>
                                <td id="backred" onclick="location.href = &#39;/admin/sets/change-status.php?id=' . $row['id']. '&#39;">Aktif / Deaktif</td></tr>';

                                      
                                
                            }
                        }
                        $conn->close();
                    ?>
                    </tbody>
                </table>
                <div id="addHak">
                    <form id="addlicenseform" action="sets/hak.php" method="post">
                        <input type="text" id="id" name="id" placeholder="Kullanıcı ID" required>
                        <input type="number" id="hak" name="hak" value="1" placeholder="Hak" min="1" max="500" required>
                        <button id="addlicense" type="submit"><i class="fas fa-plus"></i> Hak Tanımla</button>
                    </form>
                </div>
                <table id="display-table">
                    <thead>
                        <th>ID</th>
                        <th>Adı</th>
                        <th>Yetkisi</th>
                        <th>Hakkı</th>
                        <th>E-Posta</th>
                        <th>Dondur</th>
                        <th>Sil</th>
                    </thead>
                    <tbody>
                    <?php 
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "fivem";
                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        // Check connection
                        if ($conn->connect_error)  {
                            die("Connection failed: " . $conn->connect_error);
                        } 
                        //MySQL query goes here
                        
                        $sql = "SELECT * FROM accounts";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        // output data of each row
                            while($row = $result->fetch_assoc()) {
                                $user = $row['username'];
                                $guncelhak = "0";
                                if($row['hak'] >= "500"){
                                    $guncelhak = "Sınırsız";
                                }else{
                                    $guncelhak = $row['hak'];
                                }
                                echo '<tr><td>' . $row['id']. '</td>
                                <td>' . $user. '</td>
                                <td>' . $row['permission']. '</td>
                                <td>' . $guncelhak. '</td>
                                <td>' . $row['email']. '</td>
                                <td id="backmavi" onclick="location.href = &#39;/admin/sets/freeze.php?id=' . $row['id']. '&#39;">Dondur</td>
                                <td id="backred" onclick="location.href = &#39;/admin/sets/delete.php?id=' . $row['id']. '&#39;">Sil</td></tr>';                             
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