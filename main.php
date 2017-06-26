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
    <meta charset="utf-8">
    <link rel="icon" href="img/favicon.ico">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body id="inicio">

<?php require('header.php');?>

<section id="contenido">
    <article>
        <div class="col-lg-12">


            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center"><strong>HISTORIA</strong></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6 text-center">
                                    <img src="img/info.png" alt="Imagen" width="150">
                                </div>
                                <div class="col-sm-6">
                                    <p class="text-justify">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>MISIÓN</strong></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <img src="img/info.png" alt="Imagen" width="150">
                                </div>
                                <div class="col-sm-12">
                                    <p class="text-justify">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>VISIÓN</strong></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <img src="img/info.png" alt="Imagen" width="150">
                                </div>
                                <div class="col-sm-12">
                                    <p class="text-justify">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>VALORES</strong></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <img src="img/info.png" alt="Imagen" width="150">
                                </div>
                                <div class="col-sm-12">
                                    <p class="text-justify">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    </p>
                                </div>
                            </div>
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
<script src="js/logout.js" type="text/javascript"></script>
<script src="js/destroysessiontimeout.js" type="text/javascript"></script>

</body>
</html>