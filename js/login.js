$(document).ready(function()
{
    $("#login").click(function(e)
    {
        e.preventDefault();
        var form = $('#login-form');
        var data = form.serialize(); 


        $.post("conexion/login.php",
        data,
        function(data, status)
        {
            if(data == "ok")
            {
                $('#result').hide();
                window.location = "main.php";
            }
            else if(data == "userempty")
            {
                $('#result').text("Campo usuario vacio.");
            }
            else if(data == "passwordempty")
            {
                $('#result').text("Campo password vacio.");
            }
            else
            {
                $('#result').text("Usuario o contraseña incorrectos.");
            }
        });
    });

});
