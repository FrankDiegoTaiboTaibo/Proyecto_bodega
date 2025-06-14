$(document).ready(function () {
   $('#fechaVencimiento').datetimepicker({
    date: null,
    viewMode: 'days',
    format: 'DD/MM/YYYY',
    locale: 'es',
    minDate: 'now',

  });
  load(1);
 
});


//_____________________________Guardar datos
$("#guardar_articulo").submit(function (event) {
  $('#guardar_datos').attr("disabled", true);
  var nombreArticulo = $("#nombreArticulo").val();
  var codigoIsp = $("#codigoIsp").val();
  var codigoBarra = $("#codigoBarra").val();
  var concentracion = $("#concentracion").val();
  var formaFarmaceutica = $("#formaFarmaceutica").val();
  var viaAdministracion = $("#viaAdministracion").val();
  var unidadMedida = $("#unidadMedida").val();
  var laboratorio = $("#laboratorio").val();
  var tipoArticulo = $("#tipoArticulo").val();
  var stockMinimo = $("#stockMinimo").val();
  var action = 'ajax';

  $.ajax(
    {
      type: "POST",
      url: "ajax/002001registro_articulo.php",
      data: {
        action: action,
        nombreArticulo: nombreArticulo,
        codigoIsp: codigoIsp,
        codigoBarra: codigoBarra,
        concentracion: concentracion,
        formaFarmaceutica: formaFarmaceutica,
        viaAdministracion: viaAdministracion,
        unidadMedida: unidadMedida,
        laboratorio: laboratorio,
        tipoArticulo: tipoArticulo,
        stockMinimo: stockMinimo
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
                       'codigoIsp',
                       'codigoBarra',
                       'concentracion',
                       'formaFarmaceutica',
                       'viaAdministracion',
                       'unidadMedida',
                       'laboratorio',
                       'tipoArticulo',
                       'stockMinimo',
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

               if(valores[i] != 'formaFarmaceutica'&& valores[i] != 'viaAdministracion'&& valores[i] != 'unidadMedida'&& valores[i] != 'tipoArticulo')
          span = $('#' + valores[i]).siblings();

          if (errores.hasOwnProperty(valores[i])) {
            list_error += '<li>' + errores[valores[i]] + '</li>';
            contenedor.addClass(class_contenedor_error);
                           if(valores[i] != 'formaFarmaceutica'&& valores[i] != 'viaAdministracion'&& valores[i] != 'unidadMedida'&& valores[i] != 'tipoArticulo')

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

function load(page) {
  var q = $("#q").val();
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "./ajax/002001buscar_articulo.php?action=ajax&page=" +
      page +
      "&q=" +
      q,
    beforeSend: function (objeto) {
      $("#loader").html('<img src="./img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {
      $(".outer_div").html(data).fadeIn("slow");
      $("#loader").html("");
    },
  });
}

function cambiar_estado(id, pagina) {

  var action = 'ajax';

  $.ajax({
    type: "POST",
    url: "./ajax/001002cambiar_estado.php",
    data: {
      action: action,
      id: id
    },
    dataType: "json",
    beforeSend: function (objeto) {
      $('#resultados').html('<img src="./img/ajax-loader.gif"> Cargando...');
    },
    success: function (datos) {

      var msg = '';

      if (datos.hasOwnProperty('error')) {
        msg = mensaje_retro('danger', 'Error', datos['errores']);
      }
      else {
        msg = mensaje_retro('success', 'Bien hecho', datos['exito']);
        load(pagina);
      }

      $('#resultados').html(msg);
    }
  })

}

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

