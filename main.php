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
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>System Innovation</title>
<link rel="icon" href="img/favicon.ico">

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet">

<!--Icons-->
<script src="js/lumino.glyphs.js"></script>

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body id="inicio">
    <?php require('header.php');?>  
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">           
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="main.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li class="active">Inicio</li>
            </ol>
        </div><!--/.row-->
        
        <!--<div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
        </div> row-->

        <div class="col-lg-12">


            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center"><strong>HISTORIA</strong></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6 text-center">
                                    <img src="img/logo.jpg" alt="Imagen" width="380">
                                </div>
                                <div class="col-sm-6">
                                    <p class="text-justify">
                                        System Innovation inicio sus actividades en 2009 por lo cual ya cuenta con más de 5 años de presencia y trayectoria en el mercado. Es una empresa de servicios informáticos que centró su actividad en la producción de sistemas de software; iniciando su trayectoria de desarrollo empresarial en el que progresivamente hemos ido abarcando en proyectos de mayor complejidad técnica y volumen.<br>
Contamos con un excelente grupo de especialistas que se capacitan en forma permanente a fin de estar actualizados en los cambios e INNOVACIONES TECNOLÓGICAS que se presentan en nuestro ámbito.<br>
Nuestro objetivo principal es lograr una permanente mejora en nuestras actividades a fin de dar un servicio que asegure una entrega en tiempo y forma con su correspondiente asesoramiento.
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
                                    <img src="img/info.png" alt="Imagen" width="100">
                                </div>
                                <div class="col-sm-12">
                                    <p class="text-justify">
                                        Desarrollar los sistemas para el cliente teniendo criterios de suficiencia, competitividad y sustentabilidad, comprometidos con la satisfacción de los clientes y el desarrollo de software cien por ciento viables.
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
                                    <img src="img/info.png" alt="Imagen" width="100">
                                </div>
                                <div class="col-sm-12">
                                    <p class="text-justify">
                                        La visión de System Innovation es que la nueva tecnología llegue y sea conocida en distintos lugares del país, principalmente en las regiones que no cuentan con la suficiente información de tecnología.
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
                                    <img src="img/info.png" alt="Imagen" width="100">
                                </div>
                                <div class="col-sm-12">
                                    <p class="text-justify">
                                        Responsabilidad<br>
                                        Honestidad<br>
Comunicación<br>
Liderazgo<br>
Respeto
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        
    </div>  <!--/.main-->

    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootbox.min.js" type="text/javascript"></script>
    <script src="js/logout.js" type="text/javascript"></script>
    <script src="js/destroysessiontimeout.js" type="text/javascript"></script>
</body>

</html>
