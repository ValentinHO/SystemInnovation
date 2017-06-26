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
<body id="mecanicos">

<?php require('header.php');?>

<section id="contenido">
    <article>
        <div class="title-modulo">
            <p>Gestión de Mecánicos</p>
        </div>

        <div class="alert alert-success hidden" id="messages"></div>

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="glyphicon glyphicon-th-list"></span> Mecánicos</div>

                <div class="panel-body">

                    <div class="row">
                        <!--BOTÓN PARA MOSTRAR FORMULARIO-->
                        <div class="col-sm-6">
                            <button class="btn btn-default btn-new-m"><i class="glyphicon glyphicon-plus"></i> Agregar nuevo Mecánico</button>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <!--DIV QUE MUESTRA LA TABLA CON TODOS LOS MECANICOS-->
                        <div class="col-sm-12" id="mechanics-view"></div>

                        
                        <!--FORMULARIO OCULTO PARA AGREGAR MECANICO-->
                        <!--<div class="col-md-3 hidden" id="one"></div>-->
                        <div class="col-sm-12 hidden" id="addMechanic">
                            <div class="col-sm-12">
                                <form method="POST" id="mechanic-form" name="mecanicosf">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mechanicname">Nombre de Mecánico</label>
                                            <input type="text" name="mechanicname" id="mechanicname" class="form-control" placeholder="Nombre de Mecánico">
                                            <div class="text-danger" id="div-nameM"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="lastname">Apellido(s)</label>
                                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Apellido(s)">
                                            <div class="text-danger" id="div-lastnameM"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="phone">Teléfono</label>
                                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Teléfono" maxlength="10">
                                            <div class="text-danger" id="div-phoneM"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        
                                        <fieldset>
                                            <legend>Localización del Mecánico</legend>
                                            <div class="form-group">
                                                <label for="lat">Latitud</label>
                                                <input type="text" name="lat" id="lat" class="form-control" placeholder="Latitud" maxlength="15">
                                                <div class="text-danger" id="div-latM"></div>
                                            </div>

                                            <div class="form-group">
                                            <label for="lon">Longitud</label>
                                                <input type="text" name="lon" id="lon" class="form-control" placeholder="Longitud" maxlength="15">
                                                <div class="text-danger" id="div-lonM"></div>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn-inf dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="fa fa-info"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#">El formato para la longitud y latitud debe ser como lo siguiente:<br>1. 00.0000000000 (máximo 10 decimales)<br>2. -00.0000000000</a></li>
                                                </ul>
                                            </div>
                                        </fieldset>
                                            

                                        <input type="hidden" name="option" id="option" value="add">
                                        <input type="hidden" name="update-id" id="update-id" value="">

                                        <br><br>
                                        
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div id="servicesS">
                                                
                                            </div>
                                            <div class="text-danger" id="div-servM"></div>
                                        </div>    
                                    </div>

                                    <div class="col-sm-6 hidden" id="checkinfo">
                                        <div class="form-group">
                                            <input type="checkbox" name="adicionar" id="adicionar"> Adicionar nuevos servicios seleccionados
                                        </div>
                                        <div class="alert alert-info" role="alert">
                                            <span class="glyphicon glyphicon-info-sign"></span> 
                                            Si selecciona esta opción, además de los servicios con los que el mecánico ya cuenta, se agregarán los nuevos servicios elegidos.
                                            En caso contrario, el mecánico solo tendrá los servicios que seleccione en este formulario.
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-center">
                                        <div class="form-group">
                                            <a href="#" class="btn btn-md btn-success" id="btn-add-me"><i class="glyphicon glyphicon-ok"></i> Aceptar</a>
                                            <a href="#" class="btn btn-md btn-success hidden" id="btn-update-me"><i class="glyphicon glyphicon-ok"></i> Actualizar</a>
                                            <a href="#" class="btn btn-md btn-danger btn-cancel-m"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!--<div class="col-md-3 hidden" id="three"></div>-->
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
<script src="js/mechanics.js" type="text/javascript"></script>
<script src="js/logout.js" type="text/javascript"></script>
<script src="js/destroysessiontimeout.js" type="text/javascript"></script>

</body>
</html>