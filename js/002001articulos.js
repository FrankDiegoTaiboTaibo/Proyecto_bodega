$(document).ready(function () {
   $('#fechaVencimiento').datetimepicker({
    date: null,
    viewMode: 'days',
    format: 'DD/MM/YYYY',
    locale: 'es',
    minDate: 'now',

  });
 
});


//_____________________________Guardar datos
$("#guardar_articulo").submit(function (event) {
  $('#guardar_datos').attr("disabled", true);
  var nombreArticulo = $("#nombreArticulo").val();
  var dosis = $("#dosis").val();
  var presentacion = $("#presentacion").val();
  var cantidad = $("#cantidad").val();
  var fechaVencimiento = $("#fechaVencimiento").val();
  var observacion = $("#observacion").val();
  var action = 'ajax';

  $.ajax(
    {
      type: "POST",
      url: "ajax/002001registro_articulo.php",
      data: {
        action: action,
        nombreArticulo: nombreArticulo,
        dosis: dosis,
        presentacion: presentacion,
        cantidad: cantidad,
        fechaVencimiento: fechaVencimiento,
        observacion: observacion
      },
      dataType: "json",
      beforeSend: function (objeto) {
        $("#resultados_ajax").html('<img src="./img/ajax-loader.gif"> Cargando...');
      },
      success: function (datos) {
        console.log(datos);
        var errores = '';
        var contenedor = '';
        var msg = '';
        var list_error = '';
        var class_contenedor_error = 'has-error has-feedback';
        var class_span_error = 'glyphicon glyphicon-remove form-control-feedback';
        var valores = ['nombreArticulo',
                       'dosis',
                       'presentacion',
                       'cantidad',
                       'fechaVencimiento',
                       'observacion',
                      'sql'];

        if (datos.hasOwnProperty('errores')) {
          errores = datos['errores'];
        }
        else {
          msg = mensaje_retro('success', 'Bien hecho', datos['exito']);
          $("#resultados_ajax").html('');
       
        }

        for (var i = 0; i < valores.length; i++) {
          contenedor = $('#' + valores[i]).closest(".form-group ");
          span = $('#' + valores[i]).siblings();

          if (errores.hasOwnProperty(valores[i])) {
            list_error += '<li>' + errores[valores[i]] + '</li>';
            contenedor.addClass(class_contenedor_error);
            span.addClass(class_span_error);
          }
          else {
            span.removeClass(class_span_error);
            span.removeClass(class_span_error);
            contenedor.removeClass(class_contenedor_error);
          }
        }

        if (list_error != '') {
          msg += '<p> El formulario cuenta con los siguientes errores: </p>';
          msg += '<ul>' + list_error + '</ul>';
          msg = mensaje_retro('danger', 'Error', msg);
        }
        $("#resultados_ajax").html(msg);
        $('#guardar_datos').attr("disabled", false);
      }
    });
  event.preventDefault();
});

/* function load(page) {
  var q = $("#q").val();
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "./ajax/001002buscar_usuarios.php?action=ajax&page=" + page + "&q=" + q,
    beforeSend: function (objeto) {
      $("#loader").html('<img src="./img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {
      $(".outer_div").html(data).fadeIn("slow");
      $("#loader").html("");
    },
  });
}
 */




/* $("#guardar_usuario").submit(function (event) {
  $("#guardar_datos").attr("disabled", true);

  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "ajax/001002nuevo_usuario.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#resultados_ajax").html("Mensaje: Cargando...");
    },
    success: function (datos) {
      $("#resultados_ajax").html(datos);
      $("#guardar_datos").attr("disabled", false);
      load(1);
    },
  });
  event.preventDefault();
});
 */




//_______________________________Mensajes de retroalimentación
function mensaje_retro(tipo, titulo, texto) {
  var msg = '';

  msg += '<div class="alert alert-' + tipo + ' alert-dismissible" role="alert">';
  msg += '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">';
  msg += '    <span aria-hidden="true">&times;</span>';
  msg += '  </button>';
  msg += '  <div class="row">';
  msg += '    <div class="col-md-2">';
  msg += '      <strong>¡' + titulo + '!</strong>';
  msg += '    </div>';
  msg += '    <div class="col-md-9">';
  msg += texto;
  msg += '    </div>';
  msg += '  </div>';
  msg += '</div>';

  return msg;
} 

