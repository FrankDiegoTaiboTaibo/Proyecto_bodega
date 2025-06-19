$(document).ready(function () {
  $('#fechaVencimiento').datetimepicker({
    date: null,
    viewMode: 'days',
    format: 'DD/MM/YYYY',
    locale: 'es',
    minDate: 'now',
  });

  $('#desArticulo').on('change', function () {
    var idArticulo = $(this).val();

    if (idArticulo !== '') {
      $.ajax({
        type: "POST",
        url: "ajax/002002buscar_articulos.php",
        data: { id_articulo: idArticulo },
        dataType: "json",
        success: function (data) {
          if (data) {
            $('#viaAdmin').val(data.forma_farmaceutica + ' ' + data.via_administracion || '');
            $('#lab').val(data.laboratorio || '');
            $('#codIsp').val(data.codigo_isp || '');
            $('#codBarra').val(data.codigo_barra || '');
          }
        },
        error: function () {
          alert("Hubo un error al obtener los datos del artículo.");
        }
      });
    }
  });

  $("#archivo").fileinput({
    language: "es",
    browseClass: "btn btn-primary",
    showUpload: false,
    allowedFileExtensions: ["pdf"]
  });

  // Aquí se activa el envío solo cuando se hace click en #btn_guardar
  $("#btn_guardar").on("click", function (e) {
    e.preventDefault(); // Evita comportamiento por defecto

    $(this).prop("disabled", true);

    var action = "guardar";
    var cantidad = $("#cantidad").val();
    var lote = $("#lote").val();
    var fecha_vencimiento = $("#fechaVencimiento").val();
    var tipo_ingreso = $("#tipoIngreso").val();
    var proveedor = $("#proveedor").val();
    var observacion = $("#observacion").val();
    var id_articulo = $("#desArticulo").val();

    var archivoInput = $("#archivo")[0];

    var formData = new FormData();
    formData.append("action", action);
    formData.append("cantidad", cantidad);
    formData.append("lote", lote);
    formData.append("fecha_vencimiento", fecha_vencimiento);
    formData.append("tipo_ingreso", tipo_ingreso);
    formData.append("proveedor", proveedor);
    formData.append("id_articulo", id_articulo);
    formData.append("observacion", observacion);

    if (archivoInput.files.length > 0) {
      var archivo = archivoInput.files[0];
      formData.append("archivo", archivo);
    }

    $.ajax({
      type: "POST",
      url: "./ajax/002002registro_ingreso.php",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      beforeSend: function () {
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

        var valores = ['id_articulo','cantidad', 'lote', 'fecha_ingreso', 'tipo_ingreso','proveedor','observacion','archivos','sql'];

        if (datos.hasOwnProperty('errores')) {
          errores = datos['errores'];
        } else {
          msg = mensaje_retro('success', 'Bien hecho', datos['exito']);
          $("#resultados_ajax").html('');
          $("#archivo").fileinput("upload");
          $("#archivo").fileinput("clear");
        }

        for (var i = 0; i < valores.length; i++) {
          contenedor = $('#' + valores[i]).closest(".form-group ");
          if (valores[i] != 'tipo_ingreso' && valores[i] != 'id_articulo')
            span = $('#' + valores[i]).siblings();

          if (errores.hasOwnProperty(valores[i])) {
            list_error += '<li>' + errores[valores[i]] + '</li>';
            contenedor.addClass(class_contenedor_error);

            if (valores[i] != 'tipo_ingreso' && valores[i] != 'id_articulo')
              span.addClass(class_span_error);
          } else {
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

        // Rehabilita el botón
        $("#btn_guardar").prop("disabled", false);
      }
    });
  });
});

// Función para mostrar alertas
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
