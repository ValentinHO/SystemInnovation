//EXPRESIONES REGULARES PARA VALIDAR CAMPOS DE LATITUD, LONGITUD Y TELEFONOS
var numberEx=/^[0-9]+$/;
var numberNegDec=/^-?[0-9]+(\.[0-9]{1,10})?$/;


//FUNCION QUE SE EJECUTA AL CARGAR LA PAGINA mechanics.php
$(document).ready(function()
{
    mostrartabla();
});



    /* BOTON AÑADIR NUEVO MECANICO*/
    $('.btn-new-m').click(function()
    {
        mostrarform();
    });

    /* BOTON CANCELAR */
    $('.btn-cancel-m').click(function()
    {
        hideform();
    });




    /* BOTON GUARDAR MECANICO*/
    $('#btn-add-me').click(function()
    {
        //SE OBTIENEN LOS DATOS DE LOS INPUT
        var nameM = $('#mechanicname').val();
        var lastnameM = $('#lastname').val();
        var phoneM = $('#phone').val();
        var latM = $('#lat').val();
        var lonM = $('#lon').val();

        //SE OBTIENEN LOS SERVICIOS SELECCIONADOS EN UN ARRAY
        var services = []; 
        $('#Sservicios :selected').each(function(i, selected){ 
            services[i] = $(selected).val(); 
        });


        //SE OBTIENEN LOS DATOS DE LA IMAGEN
        var file = $("#images")[0].files[0];
        if (file != undefined) {
            //obtenemos el nombre del archivo
            var fileName = file.name;
            //obtenemos la extensión del archivo
            var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
            //obtenemos el tamaño del archivo
            var fileSize = file.size;
            //obtenemos el tipo de archivo image/png ejemplo
            var fileType = file.type;
        }

        //alert(fileType)
        

        if(fileType != 'image/jpg' && fileType != 'image/gif' && fileType != 'image/png' && fileType != 'image/jpeg' && fileType != undefined && fileType != null && fileType != '') 
        {
            $('#div-imageM').text('No es un archivo de imágen válido. (válidos .png y .jpg)');
            return
        }


        //SE VERIFICA QUE LOS CAMPOS NO ESTEN VACIOS
        var verifydata = validators(nameM,lastnameM,phoneM,latM,lonM,services);

        
        //SI LAS VALIDACIONES SON CORRECTAS
        if (verifydata) 
        {
            

            var formData = new FormData($("#mechanic-form")[0]);
            formData.append('option','add');

            if(file == undefined)
            {
                formData.append('profile','default.png');                
            }
            
            //hacemos la petición ajax  
            $.ajax({
                url: 'conexion/mechanics.class.php',  
                type: 'POST',
                // Form data
                //datos del formulario
                data: formData,
                //necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
                //una vez finalizado correctamente
                success: function(data){
                    $('#messages').removeClass('hidden');
                    $('#messages').empty();
                    if (data == "ok") 
                    {
                        $('#messages').removeClass('bg-danger');
                        $('#messages').addClass('bg-success');
                        $('#messages').append('<strong><i class="glyphicon glyphicon-ok"></i> ¡Hecho!</strong> El mecánico ha sido agregado satisfactoriamente.');
                        hides();
                        hideform();
                        mostrartabla();

                        //OCULTA LA ALERTA DESPUES DE 5 SEGUNDOS
                        setTimeout(function(){ 
                            $('#messages').addClass('hidden');
                            $('#messages').empty(); }, 5000);
                    }
                    else
                    {
                        //SI LA EJECUCION FALLA, MUESTRA ALERTA DE ERROR
                        $('#messages').removeClass('bg-success');
                        $('#messages').addClass('bg-danger');
                        $('#messages').append('<strong><i class="glyphicon glyphicon-alert"></i> ¡Error!</strong> ');
                        $('#messages').append(data);

                    }
                },
                //si ha ocurrido un error
                error: function(){
                    $('#messages').removeClass('hidden');
                    $('#messages').empty();
                    $('#messages').removeClass('bg-success');
                    $('#messages').addClass('bg-danger');
                    $('#messages').append('<strong><i class="glyphicon glyphicon-alert"></i> ¡Error!</strong> ajax');
                }
            });
        }

    });/*END BOTON GUARDAR MECANICO*/





/* VALIDA QUE LOS CAMPOS NO ESTÉN VACIOS*/
function validators(nameM,lastnameM,phoneM,latM,lonM,services)
{
    var iscorrect = true;

    if(nameM.length == 0){
        $('#div-nameM').text('Campo requerido');
        iscorrect = false;
    }

    if(lastnameM.length == 0){
        $('#div-lastnameM').text('Campo requerido');
        iscorrect = false;
    }

    if(phoneM.length == 0){
        $('#div-phoneM').text('Campo requerido');
        iscorrect = false;
    }else if(!phoneM.match(numberEx))
    {
        $('#div-phoneM').text('Campo teléfono debe ser númerico.');
        iscorrect = false;
    }
    else if(phoneM.length<10){
        $('#div-phoneM').text('Teléfono incorrecto, verifique su información.');
        iscorrect = false;   
    }

    if(latM.length == 0){
        $('#div-latM').empty();
        $('#div-latM').append('Campo requerido');
        iscorrect = false;
    }else if(!latM.match(numberNegDec)){
        $('#div-latM').empty();
        $('#div-latM').append('Contiene caracteres inválidos, verifique el formato en el botón azul mostrado abajo.');
        iscorrect = false;
    }else if(latM.length < 8){
        $('#div-latM').empty();
        $('#div-latM').append('Verifique formato de coordenadas en el botón con el icono <span class="glyphicon glyphicon-info-sign"></span> mostrado abajo.');
        iscorrect = false;
    }

    if(lonM.length == 0){
        $('#div-lonM').empty();
        $('#div-lonM').append('Campo requerido');
        iscorrect = false;
    }else if (!lonM.match(numberNegDec)) {
        $('#div-lonM').empty();
        $('#div-lonM').append('Contiene caracteres inválidos, verifique el formato en el botón azul mostrado abajo.');
        iscorrect = false;
    }else if(lonM.length < 8){
        $('#div-lonM').empty();
        $('#div-lonM').append('Verifique formato de coordenadas en el botón con el icono <span class="glyphicon glyphicon-info-sign"></span> mostrado abajo.');
        iscorrect = false;
    }

    if(services.length == 0 || services == null)
    {
        $('#div-servM').text('Debe seleccionar servicios');
        iscorrect = false;
    }

    return iscorrect;
}

/* VACÍA CAMPOS DE TEXTO Y DIVS DE ADVERTENCIAS */
function hides()
{
    /* LIMPIA ADVERTENCIAS */
    $('#div-nameM').text('');
    $('#div-lastnameM').text('');
    $('#div-phoneM').text('');
    $('#div-latM').text('');
    $('#div-lonM').text('');
    $('#div-servM').text('');
    $('#div-imageM').text('');
    /* LIMPIA CAJAS DE TEXTO */
    $('#mechanicname').val('');
    $('#lastname').val('');
    $('#phone').val('');
    $('#lat').val('');
    $('#lon').val('');
    $('#mechanic-form')[0].reset();
    $('#checkinfo').addClass('hidden');
}

/* MUESTRA FORMULARIO Y OCULTA TABLA */
function mostrarform()
{
    //ESCONDE BOTON DE NUEVO MECANICO Y LA TABLA Y MUESTRA EL FORMULARIO
    $('.btn-new-m').hide();
    $('#mechanics-view').hide();
    $('#addMechanic').removeClass('hidden');
    $('#btn-add-me').show();
    $('#btn-update-me').addClass('hidden');
    hides();

    $.post("conexion/mechanics.class.php",
    {
        option: "services"
    },
    function(data, status)
    {
        $('#servicesS').empty();
        $('#servicesS').append(data);
    });
}

/* OCULTA FORMULARIO Y MUESTRA TABLA */
function hideform()
{
    $('.btn-new-m').show();
    $('#mechanics-view').show();
    $('#addMechanic').addClass('hidden');
}


/* FUNCION QUE OBTIENE TABLA CON MECANICOS */
function mostrartabla()
{
    $.post("conexion/mechanics.class.php",
    {
        option: "index"
    },
    function(data, status)
    {
        $('#mechanics-view').empty();
        $('#mechanics-view').append(data);
    });
}

/* OBTIENE DATOS DEL MECANICO A EDITAR */
function editMec(ids)
{
    $.post( "conexion/mechanics.class.php", { id : ids, option : "edit" }, null, "json" )
    .done(function( data, textStatus, jqXHR ) 
    {
        mostrarform();
        $('#btn-add-me').hide();
        $('#btn-update-me').removeClass('hidden');
        $('#checkinfo').removeClass('hidden');

        $('#mechanicname').val(data.si_m_name);
        $('#lastname').val(data.si_m_lastname);
        $('#phone').val(data.si_phone);
        $('#update-id').val(ids);
        $('#lat').val(data.si_lat);
        $('#lon').val(data.si_lon);
        //alert(data);

        aplicarSelect(ids);
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus+" "+errorThrown);
        }
    });
}

function aplicarSelect(id)
{
    $.post("conexion/mechanics.class.php",
        {option: "obtain",id: id},
        function(data, status)
        {
            //$('Sservicios').val(data);
            //$('#Sservicios option[value=' + data.[0] + ']').attr('selected', true);
            var json_obj = $.parseJSON(data);
            var arr = [];
            var i=1;
            for(var x in json_obj){
                if (i<=json_obj.total) {
                    $('#Sservicios option[value=' + json_obj[x] + ']').attr('selected', true);
                }
                i++;
            }

        });
}


$('#btn-update-me').click(function()
{
    var nameM = $('#mechanicname').val();
    var lastnameM = $('#lastname').val();
    var phoneM = $('#phone').val();
    var ids = $('#update-id').val();
    var latM = $('#lat').val();
    var lonM = $('#lon').val();
    var services = [];
    var check = null; 
        $('#Sservicios :selected').each(function(i, selected){ 
            services[i] = $(selected).val(); 
        });
    if($('#adicionar').is(':checked'))
        check = true;
    else
        check = false;  // checked


     //SE OBTIENEN LOS DATOS DE LA IMAGEN
    var file = $("#images")[0].files[0];
    if (file != undefined) {
            //obtenemos el nombre del archivo
            var fileName = file.name;
            //obtenemos la extensión del archivo
            var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
            //obtenemos el tamaño del archivo
            var fileSize = file.size;
            //obtenemos el tipo de archivo image/png ejemplo
            var fileType = file.type;
    }


    if(fileType != 'image/jpg' && fileType != 'image/gif' && fileType != 'image/png' && fileType != 'image/jpeg' && fileType != undefined && fileType != null && fileType != '') 
    {
        $('#div-imageM').text('No es un archivo de imágen válido. (válidos .png y .jpg)');
        return
    }

    var verifydata = validators(nameM,lastnameM,phoneM,latM,lonM,services);

    if (verifydata) 
    {
         var formData = new FormData($("#mechanic-form")[0]);
            formData.append('option','update');
            formData.append('check',check);

            if(file == undefined)
            {
                formData.append('profile','default.png');                
            }
            var message = ""; 
            //hacemos la petición ajax  
            $.ajax({
                url: 'conexion/mechanics.class.php',  
                type: 'POST',
                // Form data
                //datos del formulario
                data: formData,
                //necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
                //una vez finalizado correctamente
                success: function(data){
                    $('#messages').removeClass('hidden');
                    $('#messages').empty();
                    if (data == "ok") 
                    {
                        $('#messages').removeClass('bg-danger');
                        $('#messages').addClass('bg-success');
                        $('#messages').append('<strong><i class="glyphicon glyphicon-ok"></i> ¡Hecho!</strong> El mecánico ha sido actualizado satisfactoriamente.');
                        hides();
                        hideform();
                        mostrartabla();

                        //OCULTA LA ALERTA DESPUES DE 5 SEGUNDOS
                        setTimeout(function(){ 
                            $('#messages').addClass('hidden');
                            $('#messages').empty(); }, 5000);
                    }
                    else
                    {
                        //SI LA EJECUCION FALLA, MUESTRA ALERTA DE ERROR
                        $('#messages').removeClass('bg-success');
                        $('#messages').addClass('bg-danger');
                        $('#messages').append('<strong><i class="glyphicon glyphicon-alert"></i> ¡Error!</strong> ');
                        $('#messages').append(data);

                    }
                },
                //si ha ocurrido un error
                error: function(){
                    $('#messages').removeClass('hidden');
                    $('#messages').empty();
                    $('#messages').removeClass('bg-success');
                    $('#messages').addClass('bg-danger');
                    $('#messages').append('<strong><i class="glyphicon glyphicon-alert"></i> ¡Error!</strong> ajax');
                }
            });
    }
});




function deleteMec(ids)
{
    bootbox.confirm("¿Seguro que desea eliminar al mecánico seleccionado?",function(result)
    {
        if (result) 
        {
            $.post("conexion/mechanics.class.php",
                { option: "delete", id: ids },
                function(data, status)
                {
                    $('#messages').removeClass('hidden');
                    $('#messages').empty();

                    if (data == "ok") {
                        $('#messages').removeClass('alert-danger');
                        $('#messages').addClass('alert-success');
                        $('#messages').append('<strong><i class="glyphicon glyphicon-ok"></i> ¡Hecho!</strong> El mecánico ha sido eliminado satisfactoriamente.');
                        hides();
                        hideform();
                        mostrartabla();

                        setTimeout(function(){ 
                            $('#messages').addClass('hidden');
                            $('#messages').empty(); }, 5000);

                    }else{
                        $('#messages').removeClass('alert-success');
                        $('#messages').addClass('alert-danger');
                        $('#messages').append('<strong><i class="glyphicon glyphicon-alert"></i> ¡Error!</strong> ');
                        $('#messages').append(data);
                    }
            });
        }
    });
}

function paginaMechanic(numPag)
{
    $.post("conexion/mechanics.class.php",
    {
        option: "index",numPag: numPag
    },
    function(data, status)
    {
        $('#mechanics-view').empty();
        $('#mechanics-view').append(data);
    });
}