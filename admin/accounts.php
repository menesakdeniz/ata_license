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
                <a href="index.php"><button><i class="fas fa-user"></i></button></a>
                <a href="servers.php"><button><i class="fas fa-terminal"></i></button></a>
                <a href="#"><button><i class="fas fa-users" id="active"></i></button></a>
                <a href="../logout.php"><button><i class="fas fa-sign-out-alt"></i></button></a>
            </div>
            <div id="content">
                <h1>Hak Ekle | <?=$_SESSION['name']?></h1>
                <form id="addlicenseform" action="sets/addtime.php" method="post">
                    <select name="hak" id="hak" class="select">
                        <option value="5">5 Lisans</option>
                        <option value="10">10 Lisans</option>
                        <option value="15">15 Lisans</option>
                        <option value="500">Sınırsız</option>
                    </select>
                    <select name="time" id="time" class="select">
                        <option value="30">1 Ay</option>
                        <option value="180">6 Ay</option>
                        <option value="365">1 Yıl</option>
                    </select>
                    <select name="user" id="user" class="select">
                        <?php 
                        include '../config.php';

                        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
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

                                echo '<option value="' . $row['username']. '">' . $row['username']. '</option>';

                                      
                                
                            }
                        }
                        $conn->close();
                    ?>
                    </select>
                    <button id="addtime" type="submit"><i class="fas fa-plus"></i> Hak Ekle</button>
                </form>
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
                        include '../config.php';

                        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
                        // Check connection
                        if ($conn->connect_error)  {
                            die("Connection failed: " . $conn->connect_error);
                        } 
                        //MySQL query goes here
                        
                        $sql = "SELECT * FROM accounts";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
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
                                <td id="backmavi" onclick="location.href = &#39;'.$link.'/admin/sets/freeze2.php?id=' . $row['id']. '&#39;">Dondur</td>
                                <td id="backred" onclick="location.href = &#39;'.$link.'/admin/sets/delete2.php?id=' . $row['id']. '&#39;">Sil</td></tr>';

                                      
                                
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