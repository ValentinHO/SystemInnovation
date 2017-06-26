$(document).ready(function()
{
    mostrartabla();
});



    /* BOTON AÑADIR NUEVO SERVICIO*/
    $('.btn-new-s').click(function()
    {
        mostrarform();
    });

    /* BOTON CANCELAR */
    $('.btn-cancel-s').click(function()
    {
        hideform();
    });




    /* BOTON GUARDAR SERVICIO*/
    $('#btn-add-se').click(function()
    {
        var nameS = $('#servicename').val();

        var form = $('#service-form');
        var data = form.serialize(); 

        var verifydata = validators(nameS);

        if (verifydata) 
        {
            $.post("conexion/services.class.php",
            data,
            function(data, status)
            {
                $('#messages').removeClass('hidden');
                $('#messages').empty();

                if (data == "ok") {
                    $('#messages').removeClass('alert-danger');
                    $('#messages').addClass('alert-success');
                    $('#messages').append('<strong><i class="glyphicon glyphicon-ok"></i> ¡Hecho!</strong> El servicio ha sido agregado satisfactoriamente.');
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





/* VALIDA QUE LOS CAMPOS NO ESTÉN VACIOS*/
function validators(nameS)
{
    var iscorrect = true;

    if(nameS.length == 0){
        $('#div-nameS').text('Campo requerido');
        iscorrect = false;
    }

    return iscorrect;
}

/* VACÍA CAMPOS DE TEXTO Y DIVS DE ADVERTENCIAS */
function hides()
{
    /* LIMPIA ADVERTENCIAS */
    $('#div-nameS').text('');

    /* LIMPIA CAJAS DE TEXTO */
    $('#servicename').val('');
}

/* MUESTRA FORMULARIO Y OCULTA TABLA */
function mostrarform()
{
    $('.btn-new-s').hide();
    $('#services-view').hide();
    $('#one-s').removeClass('hidden');
    $('#addService').removeClass('hidden');
    $('#three-s').removeClass('hidden');
    $('#btn-add-se').show();
    $('#btn-update-s').addClass('hidden');
    hides();
}

/* OCULTA FORMULARIO Y MUESTRA TABLA */
function hideform()
{
    $('.btn-new-s').show();
    $('#services-view').show();
    $('#one-s').addClass('hidden');
    $('#addService').addClass('hidden');
    $('#three-s').addClass('hidden');
}


/* FUNCION QUE OBTIENE TABLA CON SERVICIOS */
function mostrartabla()
{
    $.post("conexion/services.class.php",
    {
        option: "index"
    },
    function(data, status)
    {
        $('#services-view').empty();
        $('#services-view').append(data);
    });
}

/* OBTIENE DATOS DEL SERVICIO A EDITAR */
function editTip(ids)
{
    $.post( "conexion/services.class.php", { id : ids, option : "edit" }, null, "json" )
    .done(function( data, textStatus, jqXHR ) 
    {
        mostrarform();
        $('#btn-add-se').hide();
        $('#btn-update-s').removeClass('hidden');

        $('#servicename').val(data.si_service);
        $('#update-id').val(ids);
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus+" "+errorThrown);
        }
    });
}


$('#btn-update-s').click(function()
{
    var nameS = $('#servicename').val();
    var ids = $('#update-id').val();

    var verifydata = validators(nameS);

    if (verifydata) 
    {
        $.post("conexion/services.class.php",
        {name: nameS, option: "update", id: ids},
        function(data, status)
        {
            $('#messages').removeClass('hidden');
            $('#messages').empty();

            if (data == "ok") {
                $('#messages').removeClass('alert-danger');
                $('#messages').addClass('alert-success');
                $('#messages').append('<strong><i class="glyphicon glyphicon-ok"></i> ¡Hecho!</strong> El servicio ha sido actualizado satisfactoriamente.');
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




function deleteTip(ids)
{
    bootbox.confirm("¿Seguro que desea eliminar el servicio seleccionado?",function(result)
    {
        if (result) 
        {
            $.post("conexion/services.class.php",
                { option: "delete", id: ids },
                function(data, status)
                {
                    $('#messages').removeClass('hidden');
                    $('#messages').empty();

                    if (data == "ok") {
                        $('#messages').removeClass('alert-danger');
                        $('#messages').addClass('alert-success');
                        $('#messages').append('<strong><i class="glyphicon glyphicon-ok"></i> ¡Hecho!</strong> El servicio ha sido eliminado satisfactoriamente.');
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


function paginaService(numPag)
{
    $.post("conexion/services.class.php",
    {
        option: "index",numPag: numPag
    },
    function(data, status)
    {
        $('#services-view').empty();
        $('#services-view').append(data);
    });
}