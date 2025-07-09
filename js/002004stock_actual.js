$(document).ready(function () {   
    load(1);

    $('#fil_fecha').datetimepicker({
        date: null,
        viewMode: 'days',
        format: 'MM/YYYY',
        locale: 'es'

    });
 
});

$("#fil_fecha").on("dp.change", function (e) {
  load(1);
});

function load(page) {
    var q = $("#q").val();
    var fil_fecha = $("#fil_fecha").val();
  /*   var fil_estado = $("#fil_estado").val();
     var fil_tipo = $("#fil_tipo").val(); */
    var action = 'ajax';

    $("#loader").fadeIn('slow');
    $.ajax(
        {
            data: {
                q: q,
                  fil_fecha: fil_fecha,
                 /*   fil_estado: fil_estado,
                    fil_tipo: fil_tipo, */
                action: action,
                page: page
            },
            type: "GET",
            url: './ajax/002004buscar_stock.php',
            beforeSend: function (objeto) {
                $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
            },
            success: function (data) {
                $("#resultados").html(data);
                $('#loader').html('');
            }
        }
    )
}

function descargar(id) {
  // Redirige a un script PHP que genera y descarga el PDF
  window.location.href = 'ajax/002004descargar.php?id=' + id;
}
