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
<body id="serviciosmecanicos">

<?php require('header.php');?>

<section id="contenido">
    <article>
        <div class="title-modulo">
            <p>Gestión de Servicios Mecánicos</p>
        </div>

        <div class="alert alert-success hidden" id="messages"></div>

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="glyphicon glyphicon-th-list"></span> Servicios</div>

                <div class="panel-body">

                    <div class="row">
                        <!--BOTÓN PARA MOSTRAR FORMULARIO-->
                        <div class="col-sm-6">
                            <button class="btn btn-default btn-new-s"><i class="glyphicon glyphicon-plus"></i> Agregar nuevo Servicio</button>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <!--DIV QUE MUESTRA LA TABLA CON TODOS LOS Servicios-->
                        <div class="col-sm-12" id="services-view"></div>

                        
                        <!--FORMULARIO OCULTO PARA AGREGAR Servicio-->
                        <div class="col-sm-3 hidden" id="one-s"></div>
                        <div class="col-sm-6 hidden" id="addService">
                            <div class="col-sm-12">
                                <form method="POST" id="service-form" name="servicef">

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="servicename">Nombre del Servicio</label>
                                            <input type="text" name="servicename" id="servicename" class="form-control" placeholder="Nombre del Servicio">
                                            <div class="text-danger" id="div-nameS"></div>
                                        </div>

                                        <input type="hidden" name="option" id="option" value="add">
                                        <input type="hidden" name="update-id" id="update-id" value="">

                                        <div class="form-group">
                                            <a href="#" class="btn btn-md btn-success" id="btn-add-se"><i class="glyphicon glyphicon-ok"></i> Aceptar</a>
                                            <a href="#" class="btn btn-md btn-success hidden" id="btn-update-s"><i class="glyphicon glyphicon-ok"></i> Actualizar</a>
                                            <a href="#" class="btn btn-md btn-danger btn-cancel-s"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="col-sm-3 hidden" id="three-s"></div>
                        <!--FIN DE FORMULARIO-->
                    </div>

                </div>
            </div>
        </div>                  

    </article>
</section>

<script src="js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/bootbox.min.js" type="text/javascript"></script>
<script src="js/services.js" type="text/javascript"></script>
<script src="js/logout.js" type="text/javascript"></script>
<script src="js/destroysessiontimeout.js" type="text/javascript"></script>

</body>
</html>