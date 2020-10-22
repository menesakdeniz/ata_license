<?php
session_start();

include '../../config.php';
// Try and connect using the info above.
$connect = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

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
        if(empty($roww["verfcode"])){
            $newcode = md5(uniqid(mt_rand(), true));
            $sqlla = "UPDATE accounts SET verfcode='$newcode' WHERE username='$user'";
            $resultta = $connect->query($sqlla);
            $mailbody = "Bu linke tıklayarak hesabını doğrulayabilirsin <a href='".$link."/unverified/sets/confirm.php?id=" . $newcode."'>http://localhost/unverified/sets/confirm.php?id=" . $newcode."</a>";
        }else{
            $mailbody = "Bu linke tıklayarak hesabını doğrulayabilirsin <a href='".$link."/unverified/sets/confirm.php?id=" . $roww["verfcode"]."'>http://localhost/unverified/sets/confirm.php?id=" . $roww["verfcode"]."</a>";
        }
    }
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Gerekli dosyaları include ediyoruz
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer(true);

try {
    //SMTP Sunucu Ayarları
    $toemail = @$_POST['email'];
    $mail->SMTPDebug = 0;										// DEBUG Kapalı: 0, DEBUG Açık: 2 // Detaylı bilgi için: https://github.com/PHPMailer/PHPMailer/wiki/SMTP-Debugging
    $mail->isSMTP();											// SMTP gönderimi kullan
    $mail->Host       = $emailserverhost;					// Email sunucu adresi. Genellikle mail.domainadi.com olarak kullanilir. Bu adresi hizmet saglayiciniza sorabilirsiniz
    $mail->SMTPAuth   = true;									// SMTP kullanici dogrulama kullan
    $mail->Username   = $emailserverid;				// SMTP sunucuda tanimli email adresi
    $mail->Password   = $emailserverpass;							// SMTP email sifresi
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;			// SSL icin `PHPMailer::ENCRYPTION_SMTPS` kullanin. SSL olmadan 587 portundan gönderim icin `PHPMailer::ENCRYPTION_STARTTLS` kullanin
    $mail->Port       = 465;									// Eger yukaridaki deger `PHPMailer::ENCRYPTION_SMTPS` ise portu 465 olarak guncelleyin. Yoksa 587 olarak birakin
    $mail->setFrom($emailserverid, 'E-Posta Doğrulama'); // Gonderen bilgileri yukaridaki $mail->Username ile aynı deger olmali

    //Alici Ayarları
    $mail->addAddress($toemail); // Alıcı bilgileri
    //$mail->addReplyTo('YANITADRESI@domainadi.com');			// Alıcı'nın emaili yanıtladığında farklı adrese göndermesini istiyorsaniz aktif edin
    //$mail->addCC('CC@domainadi.com');
    //$mail->addBCC('BCC@domainadi.com');

    // Mail Ekleri
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Attachment ekleme
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Opsiyonel isim degistirerek Attachment ekleme

    // İçerik
    $mail->isHTML(true); // Gönderimi HTML türde olsun istiyorsaniz TRUE ayarlayin. Düz yazı (Plain Text) icin FALSE kullanin
    $mail->Subject = 'E-Postanı Doğrula';
    $mail->Body    = $mailbody;

    $mail->send();
    echo("basarili");
} catch (Exception $e) {
    echo "Ops! Email iletilemedi. Hata: {$mail->ErrorInfo}";
}