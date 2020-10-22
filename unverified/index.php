<?php
// Change this to your connection info.
	session_start();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
	<title>Lisans Sistemi V2</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div id="nav-bar">
		<div id="dogrulandi"><h3>E-Posta Gönderildi</h3></div>
        
	</div>
	<div id="first-content">
        <div id="texts">
			<div id="textss" style="opacity: 1.0;">
                <div class="login100-form validate-form">            
                    <span class="login-title">
						<b>E-POSTANI DOĞRULA</b>
					</span>

					<div class="login-btn">
						<input class="login100-form-btn" id="sendmail" type="submit" style="cursor: pointer;" value="E-Posta Göner">
					</div>
				</div>
			</div>
			<div id="registerss" style="opacity: 0; display: none;">
                <div class="login100-form validate-form">            
                   <h2>E-Posta adresinden onayla.</h2>
				</div>
			</div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script type="text/javascript">
		var main = document.getElementById("textss");
		var dogrula = document.getElementById("registerss");
		var bildirim = document.getElementById("dogrulandi");

		$("#sendmail.login100-form-btn").click(function(){
			main.style.opacity = '0';
			setTimeout(function(){
				main.innerHTML = dogrula.innerHTML;
				main.style.opacity = '1';
			}, 500);

		  	$.post("sets/sendemail.php",
		  	{
		  	  email: "<?=$_SESSION['email']?>",
		  	},function(data, status){
		    
				if(data == "basarili"){
					bildirim.style.display = "block";
					setTimeout(function(){
						bildirim.style.display = "none";
					}, 3000);
				}else{
					alert("Yarra yering kardeşim. Email bozuldu.");
				}
		  	});
		  
		});


		// var login = document.getElementById("loginss"); ucretlendirme
		// var texts = document.getElementById("textss");
		// var register = document.getElementById("registerss");

		  
         
        // $( ".login-button" ).click(function() { 
		// 	register.style.opacity = '0';  		
		// 	texts.style.opacity = '0';
		// 	login.style.display = 'block';
		// 	setTimeout(function(){
        //         register.style.display = 'none';
		// 		texts.style.display = 'none';
		// 		login.style.opacity = '1';
		// 	}, 500);				 
        // });

		// $( ".register-button" ).click(function() {   			
		// 	texts.style.opacity = '0';
		// 	login.style.opacity = '0';
		// 	register.style.display = 'block';
		// 	setTimeout(function(){
		// 		texts.style.display = 'none';
		// 		login.style.display = 'none';
		// 		register.style.opacity = '1';
		// 	}, 500);
        // });

		// $( ".main-buttons" ).click(function() {   			
		// 	register.style.opacity = '0';
		// 	login.style.opacity = '0';
			
		// 	setTimeout(function(){
		// 		register.style.display = 'none';
		// 		login.style.display = 'none';
		// 		texts.style.opacity = '1';
		// 	}, 500);
        // });


        
</script>
</html>


