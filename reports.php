<?php 
    session_name("loginAdmin");
    session_start(); 
    //validamos si se ha hecho o no el inicio de sesion correctamente 
    //si no se ha hecho la sesion nos regresará a login.php 
    if(!isset($_SESSION['nombreUsuario']))  
    { 
        header('Location: index.php');     
        exit(); 
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>System Innovation</title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <link rel="icon" href="img/favicon.ico">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body id="reportes">

<?php require('header.php');?>

<section id="contenido">
    <article>
        <div class="title-modulo">
            <p>Reporte de recomendación de Mecánicos</p>
        </div>

        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading"><span class="glyphicon glyphicon-th-list"></span> Mejores servicios</div>

                <div class="panel-body">

                    <div class="row">
                        <div id="cards-r">
                
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </article>
</section>

<script src="js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/bootbox.min.js" type="text/javascript"></script>
<script src="js/reports.js" type="text/javascript"></script>
<script src="js/logout.js" type="text/javascript"></script>
<script src="js/destroysessiontimeout.js" type="text/javascript"></script>

</body>
</html>