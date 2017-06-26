$(document).ready(function()
{

    $.post("conexion/reports.class.php",
    {
        option: "index"
    },
    function(data, status)
    {
        $('#cards-r').append(data);
    });

});

function paginaReports(numPag)
{
	$.post("conexion/reports.class.php",
    {
        option: "index",numPag: numPag
    },
    function(data, status)
    {
    	$('#cards-r').empty();
        $('#cards-r').append(data);
    });
}
