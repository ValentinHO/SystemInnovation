var numberEx=/^[0-9]+$/;
var numberNegDec=/^-?[0-9]+(\.[0-9]{1,10})?$/;

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
        var nameM = $('#mechanicname').val();
        var lastnameM = $('#lastname').val();
        var phoneM = $('#phone').val();
        var latM = $('#lat').val();
        var lonM = $('#lon').val();
        var services = []; 
        $('#Sservicios :selected').each(function(i, selected){ 
            services[i] = $(selected).val(); 
        });

        var verifydata = validators(nameM,lastnameM,phoneM,latM,lonM,services);

        if (verifydata) 
        {
            $.post("conexion/mechanics.class.php",
            {mechanicname: nameM, lastname: lastnameM, phone: phoneM, lat: latM, lon: lonM, services: services, option: "add"},
            function(data, status)
            {
                $('#messages').removeClass('hidden');
                $('#messages').empty();

                if (data == "ok") {
                    $('#messages').removeClass('alert-danger');
                    $('#messages').addClass('alert-success');
                    $('#messages').append('<strong>¡Hecho!</strong> El mecánico ha sido agregado satisfactoriamente.');
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

                    /*setTimeout(function(){ 
                        $('#messages').addClass('hidden');
                        $('#messages').empty(); }, 5000);*/
                }
            });
        }

    });





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

    if(latM.length == 0){
        $('#div-latM').text('Campo requerido');
        iscorrect = false;
    }else if(!latM.match(numberNegDec)){
        $('#div-latM').text('Contiene caracteres inválidos, verifique el formato en el botón azul mostrado abajo.');
        iscorrect = false;
    }

    if(lonM.length == 0){
        $('#div-lonM').text('Campo requerido');
        iscorrect = false;
    }else if (!lonM.match(numberNegDec)) {
        $('#div-lonM').text('Contiene caracteres inválidos, verifique el formato en el botón azul mostrado abajo.');
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
    /* LIMPIA CAJAS DE TEXTO */
    $('#mechanicname').val('');
    $('#lastname').val('');
    $('#phone').val('');
    $('#lat').val('');
    $('#lon').val('');
}

/* MUESTRA FORMULARIO Y OCULTA TABLA */
function mostrarform()
{
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

    var verifydata = validators(nameM,lastnameM,phoneM,latM,lonM,services);

    if (verifydata) 
    {
        $.post("conexion/mechanics.class.php",
        {name: nameM, lastname: lastnameM, phone: phoneM, option: "update", id: ids, lat: latM, lon: lonM,services: services,check: check},
        function(data, status)
        {
            $('#messages').removeClass('hidden');
            $('#messages').empty();

            if (data == "ok") {
                $('#messages').removeClass('alert-danger');
                $('#messages').addClass('alert-success');
                $('#messages').append('<strong>¡Hecho!</strong> El mecánico ha sido actualizado satisfactoriamente.');
                hides();
                hideform();
                mostrartabla();
                $('#checkinfo').addClass('hidden');
                services = [];

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
                        $('#messages').append('<strong>¡Hecho!</strong> El mecánico ha sido eliminado satisfactoriamente.');
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