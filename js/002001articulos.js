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
  var fil_estado = $("#fil_estado").val();
  var fil_tipo = $("#fil_tipo").val();
  var action = 'ajax';

  $("#loader").fadeIn('slow');
  $.ajax(
    {
      data: {
        q: q,
        fil_estado: fil_estado,
        fil_tipo: fil_tipo,
        action: action,
        page: page
      },
      type: "GET",
      url: './ajax/002001buscar_articulo.php',
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


function cambiar_estado(id, pagina) {

  var action = 'ajax';

  $.ajax({
    type: "POST",
    url: "./ajax/002001cambiar_estado.php",
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

$('#editarArticulo').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal 
    var id_articulo = button.data('id_articulo')
    var nombre_articulo = button.data('nombre_articulo')
    var codigo_isp = button.data('codigo_isp')
     var codigo_barra = button.data('codigo_barra')
      var concentracion = button.data('concentracion')
      var forma_farmaceutica = button.data('forma_farmaceutica')
       var via_administracion = button.data('via_administracion')
        var unidad_medida = button.data('unidad_medida')
         var laboratorio = button.data('laboratorio')
          var tipo_articulo = button.data('tipo_articulo')
           var stock_minimo = button.data('stock_minimo')
         
  
    $("#id_articulo").val(id_articulo);
    $("#nombreArticulo_mod").val(nombre_articulo);
    $("#codigoIsp_mod").val(codigo_isp);
    $("#codigoBarra_mod").val(codigo_barra);
    $("#concentracion_mod").val(concentracion);
  $("#formaFarmaceutica_mod").selectpicker("val", forma_farmaceutica);
  $("#viaAdministracion_mod").selectpicker("val", via_administracion);
  $("#unidadMedida_mod").selectpicker("val", unidad_medida);
    $("#laboratorio_mod").val(laboratorio);
  $("#tipoArticulo_mod").selectpicker("val", tipo_articulo);
    $("#stockMinimo_mod").val(stock_minimo);

  })

    function eliminar(id) {

    var action = 'ajax';
    var pagina = $('#pagina_actual ').val();
  
    if (confirm("¿Realmente deseas eliminar el registro?")) {
      $.ajax({
        type: "POST",
        url: "./ajax/002001eliminar_articulo.php",
        data: {
          action: action,
          id: id
        },
        dataType: "json",
        beforeSend: function (objeto) {
          $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
        },
        success: function (datos) {
          var msg = '';
  
          if (datos.hasOwnProperty('error')) {
            msg = mensaje_retro('danger', 'Error', datos['error']);
            $("#resultados_msg").html('');
            load(pagina);
  
          }
          else {
            msg = mensaje_retro('success', 'Bien hecho', datos['exito']);
            $("#resultados_msg").html('');
            load(pagina);
  
          }
          $('#resultados_msg').html(msg);
        }
      });
    }
  }

  //__________________________editar datos
$("#editar_articulo").submit(function (event) {
    $('#actualizar_datos').attr("disabled", true);
    var id = $("#id_articulo").val();
  var nombreArticulo_mod = $("#nombreArticulo_mod").val();
  var codigoIsp_mod = $("#codigoIsp_mod").val();
  var codigoBarra_mod = $("#codigoBarra_mod").val();
  var concentracion_mod = $("#concentracion_mod").val();
  var formaFarmaceutica_mod = $("#formaFarmaceutica_mod").val();
  var viaAdministracion_mod = $("#viaAdministracion_mod").val();
  var unidadMedida_mod = $("#unidadMedida_mod").val();
  var laboratorio_mod = $("#laboratorio_mod").val();
  var tipoArticulo_mod = $("#tipoArticulo_mod").val();
  var stockMinimo_mod = $("#stockMinimo_mod").val();
    var action = 'ajax';
    var pagina_actual = $('#pagina_actual').val();
  
    $.ajax(
      {
        type: "POST",
        url: "ajax/002001editar_articulo.php",
        data: {
          action: action,
          id: id,
           nombreArticulo_mod: nombreArticulo_mod,
        codigoIsp_mod: codigoIsp_mod,
        codigoBarra_mod: codigoBarra_mod,
        concentracion_mod: concentracion_mod,
        formaFarmaceutica_mod: formaFarmaceutica_mod,
        viaAdministracion_mod: viaAdministracion_mod,
        unidadMedida_mod: unidadMedida_mod,
        laboratorio_mod: laboratorio_mod,
        tipoArticulo_mod: tipoArticulo_mod,
        stockMinimo_mod: stockMinimo_mod
        },
        dataType: "json",
        beforeSend: function (objeto) {
          $("#resultados_ajax_articulo").html("Mensaje: Cargando...");
        },
         success: function (datos) {
        console.log(datos);
        var errores = '';
        var contenedor = '';
        var msg = '';
        var list_error = '';
        var class_contenedor_error = 'has-error has-feedback';
        var class_span_error = 'glyphicon glyphicon-remove form-control-feedback';
        var valores = ['nombreArticulo_mod',
                       'codigoIsp_mod',
                       'codigoBarra_mod',
                       'concentracion_mod',
                       'formaFarmaceutica_mod',
                       'viaAdministracion_mod',
                       'unidadMedida_mod',
                       'laboratorio_mod',
                       'tipoArticulo_mod',
                       'stockMinimo_mod',
                      'update'];
  
          if (datos.hasOwnProperty('errores')) {
            errores = datos['errores'];
          }
          else {
            msg = mensaje_retro('success', 'Bien hecho', datos['exito']);
            $("#resultados_ajax_articulo").html('');
            load(pagina_actual);
          }
  
          for (var i = 0; i < valores.length; i++) {
            contenedor = $('#' + valores[i]).closest(".form-group ");
                          if(valores[i] != 'formaFarmaceutica_mod'&& valores[i] != 'viaAdministracion_mod'&& valores[i] != 'unidadMedida_mod'&& valores[i] != 'tipoArticulo_mod')

              span = $('#' + valores[i]).siblings();
  
            if (errores.hasOwnProperty(valores[i])) {
              list_error += '<li>' + errores[valores[i]] + '</li>';
              contenedor.addClass(class_contenedor_error);
                                       if(valores[i] != 'formaFarmaceutica_mod'&& valores[i] != 'viaAdministracion_mod'&& valores[i] != 'unidadMedida_mod'&& valores[i] != 'tipoArticulo_mod')

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
          $("#resultados_ajax_articulo").html(msg);
          $('#actualizar_datos').attr("disabled", false);
        }
      }
    );
    event.preventDefault();
  }
  )

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

