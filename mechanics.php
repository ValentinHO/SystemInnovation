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
<link href="css/pagination.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet">

<!--Icons-->
<script src="js/lumino.glyphs.js"></script>

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body id="mecanicos">
    <?php require('header.php');?>  
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">           
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="main.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li class="active">Mecánicos</li>
            </ol>
        </div><!--/.row-->
        
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Gestión de Mecánicos</h1>
            </div>
        </div><!--/.row-->


        <div class="alert bg-success hidden" id="messages"></div>

        <div class="col-lg-12">
            <div class="panel panel-primary">
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
                                <form method="POST" enctype="multipart/form-data" id="mechanic-form" name="mecanicosf">
                                    <div class="col-sm-12">
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
                                            <div class="form-group">
                                                <label for="images">Seleccione una imágen</label>
                                                <input type="file" name="images" id="images" class="form-control"  maxlength="10">
                                                <div class="text-danger" id="div-imageM"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            
                                            <fieldset>
                                                <legend>Localización del Mecánico</legend>
                                                <div class="form-group">
                                                    <label for="lat">Latitud</label>
                                                    <input type="text" name="lat" id="lat" class="form-control" placeholder="Latitud" maxlength="12">
                                                    <div class="text-danger" id="div-latM"></div>
                                                </div>

                                                <div class="form-group">
                                                <label for="lon">Longitud</label>
                                                    <input type="text" name="lon" id="lon" class="form-control" placeholder="Longitud" maxlength="12">
                                                    <div class="text-danger" id="div-lonM"></div>
                                                </div>
                                                <div class="btn-group">
                                                    <button type="button" class="btn-inf dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="glyphicon glyphicon-info-sign"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#">El formato para la longitud y latitud debe ser como lo siguiente:<br>1. 00.00000000 (máximo 8 decimales)<br>2. -00.00000000</a></li>
                                                    </ul>
                                                </div>
                                            </fieldset>
                                                

                                            <input type="hidden" name="option" id="option" value="add">
                                            <input type="hidden" name="update-id" id="update-id" value="">

                                            <br><br>
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12">
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

        
        
    </div>  <!--/.main-->

    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootbox.min.js" type="text/javascript"></script>
    <script src="js/mechanics.js" type="text/javascript"></script>
    <script src="js/logout.js" type="text/javascript"></script>
    <script src="js/destroysessiontimeout.js" type="text/javascript"></script>
</body>

</html>