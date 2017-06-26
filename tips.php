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

<body id="tips">
    <?php require('header.php');?>  
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">           
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="main.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li class="active">Tips</li>
            </ol>
        </div><!--/.row-->
        
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Gestión de Tips</h1>
            </div>
        </div><!--/.row-->


        <div class="alert bg-success hidden" id="messages"></div>
        
        <div class="col-lg-12">
            <div class="panel panel-primary">
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

        
        
    </div>  <!--/.main-->

    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootbox.min.js" type="text/javascript"></script>
    <script src="js/tips.js" type="text/javascript"></script>
    <script src="js/logout.js" type="text/javascript"></script>
    <script src="js/destroysessiontimeout.js" type="text/javascript"></script>
</body>

</html>