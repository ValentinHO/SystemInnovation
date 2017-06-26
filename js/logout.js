$(document).ready(function()
{

    $('#logout').click(function(e)
    {
        e.preventDefault();

        $.post("conexion/login.php",
            { logout: "yes" },
            function(data, status)
            {
                if(data == "useremptyok")
                {
                    window.location = "index.php";
                }
                else
                {
                    bootbox.alert(data);
                }
            });
    });

});

