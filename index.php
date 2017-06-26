<?php 
    session_name("loginAdmin");
    session_start(); 
    //validamos si se ha hecho o no el inicio de sesion correctamente 
    //si no se ha hecho la sesion nos regresará a index.php 
    if(isset($_SESSION['nombreUsuario']))  
    { 
        header('Location: main.php');      
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>System Innovation</title>
    <meta charset="utf-8">
    <link rel="icon" href="img/favicon.ico">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>

    <div class="login-page">
        <h2>SYSTEM INNOVATION</h2>
        <div class="form">
            <form class="login-form" method="POST" id="login-form">
                <input type="text" placeholder="username" name="username" id="username" />
                <input type="password" placeholder="password" name="password" id="password" />
                <button id="login" name="login">login</button>
                <!--<p class="message">¿Olvidó su contraseña? <a href="#">Recuperar</a></p>-->
            </form><br>
            <div id="result" class="text-danger"></div>
        </div>
    </div>

    <script src="js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/bootbox.min.js" type="text/javascript"></script>
    <script src="js/login.js" type="text/javascript"></script>
</body>
</html>