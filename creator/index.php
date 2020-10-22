<?php
session_start();

include '../config.php';

$connect = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if (!isset($_SESSION['loggedin'])) { 
	header('Location: ../index.html');
	exit;
}




if ($connect->connect_error)  {
    die("Connection failed: " . $connect->connect_error);
} 

$user = $_SESSION["name"];
$sqll = "SELECT * FROM accounts WHERE username='$user'";
$resultt = $connect->query($sqll);
if ($resultt->num_rows > 0) {
    while($roww = $resultt->fetch_assoc()) {
        $hak = $roww['hak'];
        $_SESSION['hak'] = $hak;    

        $perm = $roww['permission'];
        $_SESSION['perm'] = $perm;  
        
    }
}

if($perm == "admin"){
    header('Location: ../admin/index.php');
	exit;
}
if($enablemail == true){
    if($perm == "unverified"){
        header('Location: ../admin/index.php');
        exit;
    }
}


$connect->close();

?>


<html>
    <head>
        <title>
        V1 Kopyalamasyon
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/0eb6ecdd2f.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div id="main-content">
            <div id="nav-bar">
                <a href="#"><button style="font-size:25px;">KEL<BR>V1</button></a>
                <a href="#"><button><i class="fas fa-user"  id="active"></i></button></a>
                <a href="servers.php"><button><i class="fas fa-terminal"></i></button></a>
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
                        <th>Kod </th>
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
                        $user = $_SESSION["name"];
                        $sql = "SELECT * FROM lisans WHERE sahip='$user'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        // output data of each row
                            while($row = $result->fetch_assoc()) {
                                if($row['stat'] === "true"){
                                    $aktif = "Aktif";
                                }
                                if($row['stat'] === "false"){
                                    $aktif = "Aktif Değil";
                                }

                                echo '<tr><td>' . $user. '</td>
                                <td>' . $row['name']. ' - ' . $row['ip']. '</td>
                                <td>' . $aktif. '</td>
                                <td id="backblue" class="getcode" name="' . $row['id']. '">Kodu Al</td>
                                <td id="backred" onclick="location.href = &#39;/creator/sets/change-status.php?id=' . $row['id']. '&#39;">Aktif / Deaktif</td></tr>';

                                      
                                
                            }
                        }
                        $conn->close();
                    ?>
                        
                    </tbody>
                </table>
                <div id="closekod" style="float:right; margin-right:40px; margin-top: 20px; display:none;"><button id="addlicense" class="closecodea"><i class="fas fa-times-circle"></i> Kodu Gizle</button></div>
                
                <div id="tabb"><pre id="code"></pre></div>
                
            </div>
            
        </div>
    </body>
    <script type="text/javascript" src="js/main.js"></script>
</html>

<script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
<script type="text/javascript">
        
        $(function(){
        $('.getcode').click(function(){
            var id= $(this).attr('name');
            $.ajax({
            type:'POST',
            url:'sets/letcode.php',
            data:{id:id},
            success: function(e){ 
				document.getElementById('closekod').style.display = "block";
                document.getElementById('code').innerHTML = e;
			}

                });
            })
        });
    
    $(function(){
        $('.closecodea').click(function(){
            var id= $(this).attr('name');
            $.ajax({
            type:'POST',
            url:'sets/letcode.php',
            data:{id:id},
            success: function(e){ 
				document.getElementById('closekod').style.display = "none";
                document.getElementById('code').innerHTML = "";
			}

                });
            })
        });
        
    </script>
