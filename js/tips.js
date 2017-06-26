$(document).ready(function()
{
    mostrartabla();
});



    /* BOTON AÑADIR NUEVO TIP*/
    $('.btn-new-t').click(function()
    {
        mostrarform();
    });

    /* BOTON CANCELAR */
    $('.btn-cancel-t').click(function()
    {
        hideform();
    });




    /* BOTON GUARDAR TIP*/
    $('#btn-add-t').click(function()
    {
        var nameT = $('#tipname').val();
        var description = $('#description').val();

        var form = $('#tip-form');
        var data = form.serialize(); 

        var verifydata = validators(nameT,description);

        if (verifydata) 
        {
            $.post("conexion/tips.class.php",
            data,
            function(data, status)
            {
                $('#messages').removeClass('hidden');
                $('#messages').empty();

                if (data == "ok") {
                    $('#messages').removeClass('alert-danger');
                    $('#messages').addClass('alert-success');
                    $('#messages').append('<strong>¡Hecho!</strong> El tip ha sido agregado satisfactoriamente.');
                    hides();
                    hideform();
                    mostrartabla();

                    setTimeout(function(){ 
                        $('#messages').addClass('hidden');
                        $('#messages').empty(); }, 5000);

                }else{
                    $('#messages').removeClass('alert-success');
                    $('#messages').addClass('alert-danger');
                    $('#messages').append(data);
                }
            });
        }

    });





/* VALIDA QUE LOS CAMPOS NO ESTÉN VACIOS*/
function validators(nameT,description)
{
    var iscorrect = true;

    if(nameT.length == 0){
        $('#div-nameT').text('Campo requerido');
        iscorrect = false;
    }

    if(description.length == 0){
        $('#div-descriptionT').text('Campo requerido');
        iscorrect = false;
    }

    return iscorrect;
}

/* VACÍA CAMPOS DE TEXTO Y DIVS DE ADVERTENCIAS */
function hides()
{
    /* LIMPIA ADVERTENCIAS */
    $('#div-nameT').text('');
    $('#div-descriptionT').text('');

    /* LIMPIA CAJAS DE TEXTO */
    $('#tipname').val('');
    $('#description').val('');
}

/* MUESTRA FORMULARIO Y OCULTA TABLA */
function mostrarform()
{
    $('.btn-new-t').hide();
    $('#tips-view').hide();
    $('#one-t').removeClass('hidden');
    $('#addTip').removeClass('hidden');
    $('#three-t').removeClass('hidden');
    $('#btn-add-t').show();
    $('#btn-update-t').addClass('hidden');
    hides();
}

/* OCULTA FORMULARIO Y MUESTRA TABLA */
function hideform()
{
    $('.btn-new-t').show();
    $('#tips-view').show();
    $('#one-t').addClass('hidden');
    $('#addTip').addClass('hidden');
    $('#three-t').addClass('hidden');
}


/* FUNCION QUE OBTIENE TABLA CON TIPS */
function mostrartabla()
{
    $.post("conexion/tips.class.php",
    {
        option: "index"
    },
    function(data, status)
    {
        $('#tips-view').empty();
        $('#tips-view').append(data);
    });
}

/* OBTIENE DATOS DEL TIP A EDITAR */
function editTip(ids)
{
    $.post( "conexion/tips.class.php", { id : ids, option : "edit" }, null, "json" )
    .done(function( data, textStatus, jqXHR ) 
    {
        mostrarform();
        $('#btn-add-t').hide();
        $('#btn-update-t').removeClass('hidden');

        $('#tipname').val(data.si_t_name);
        $('#description').val(data.si_description);
        $('#update-id').val(ids);
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus+" "+errorThrown);
        }
    });
}


$('#btn-update-t').click(function()
{
    var nameT = $('#tipname').val();
    var description = $('#description').val();
    var ids = $('#update-id').val();

    var verifydata = validators(nameT,description);

    if (verifydata) 
    {
        $.post("conexion/tips.class.php",
        {name: nameT, description: description, option: "update", id: ids},
        function(data, status)
        {
            $('#messages').removeClass('hidden');
            $('#messages').empty();

            if (data == "ok") {
                $('#messages').removeClass('alert-danger');
                $('#messages').addClass('alert-success');
                $('#messages').append('<strong>¡Hecho!</strong> El tip ha sido actualizado satisfactoriamente.');
                hides();
                hideform();
                mostrartabla();

                setTimeout(function(){ 
                    $('#messages').addClass('hidden');
                    $('#messages').empty(); }, 5000);

            }else{
                $('#messages').removeClass('alert-success');
                $('#messages').addClass('alert-danger');
                $('#messages').append(data);
            }
        });
    }
});




function deleteTip(ids)
{
    bootbox.confirm("¿Seguro que desea eliminar el tip seleccionado?",function(result)
    {
        if (result) 
        {
            $.post("conexion/tips.class.php",
                { option: "delete", id: ids },
                function(data, status)
                {
                    $('#messages').removeClass('hidden');
                    $('#messages').empty();

                    if (data == "ok") {
                        $('#messages').removeClass('alert-danger');
                        $('#messages').addClass('alert-success');
                        $('#messages').append('<strong>¡Hecho!</strong> El tip ha sido eliminado satisfactoriamente.');
                        hides();
                        hideform();
                        mostrartabla();

                        setTimeout(function(){ 
                            $('#messages').addClass('hidden');
                            $('#messages').empty(); }, 5000);

                    }else{
                        $('#messages').removeClass('alert-success');
                        $('#messages').addClass('alert-danger');
                        $('#messages').append(data);
                    }
            });
        }
    });
}


function paginaTips(numPag)
{
    $.post("conexion/tips.class.php",
    {
        option: "index",numPag: numPag
    },
    function(data, status)
    {
        $('#tips-view').empty();
        $('#tips-view').append(data);
    });
}