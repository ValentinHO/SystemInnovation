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
<body id="tips">

<?php require('header.php');?>

<section id="contenido">
    <article>
        <div class="title-modulo">
            <p>Gestión de Tips</p>
        </div>

        <div class="alert alert-success hidden" id="messages"></div>
        
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="glyphicon glyphicon-th-list"></span> Tips</div>

                <div class="panel-body">

                    <div class="row">
                        <!--BOTÓN PARA MOSTRAR FORMULARIO-->
                        <div class="col-md-6">
                            <button class="btn btn-default btn-new-t"><i class="glyphicon glyphicon-plus"></i> Agregar nuevo Tip</button>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <!--DIV QUE MUESTRA LA TABLA CON TODOS LOS TIPSS-->
                        <div class="col-md-12" id="tips-view"></div>

                        
                        <!--FORMULARIO OCULTO PARA AGREGAR TIPS-->
                        <div class="col-md-3 hidden" id="one-t"></div>
                        <div class="col-md-6 hidden" id="addTip">
                            <div class="col-md-12">
                                <form method="POST" id="tip-form">
                                    <div class="form-group">
                                        <label for="tipname">Nombre del Tip</label>
                                        <input type="text" name="tipname" id="tipname" class="form-control" placeholder="Nombre del Tip">
                                        <div class="text-danger" id="div-nameT"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Descripción</label>
                                        <textarea name="description" id="description" class="form-control" placeholder="Escriba los detalles del Tip."></textarea>
                                        <div class="text-danger" id="div-descriptionT"></div>
                                    </div>

                                    <input type="hidden" name="option" id="option" value="add">
                                    <input type="hidden" name="update-id" id="update-id" value="">

                                    <div class="form-group">
                                        <a href="#" class="btn btn-md btn-success" id="btn-add-t"><i class="glyphicon glyphicon-ok"></i> Aceptar</a>
                                        <a href="#" class="btn btn-md btn-success hidden" id="btn-update-t"><i class="glyphicon glyphicon-ok"></i> Actualizar</a>
                                        <a href="#" class="btn btn-md btn-danger btn-cancel-t"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-3 hidden" id="three-t"></div>
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
<script src="js/tips.js" type="text/javascript"></script>
<script src="js/logout.js" type="text/javascript"></script>
<script src="js/destroysessiontimeout.js" type="text/javascript"></script>

</body>
</html>