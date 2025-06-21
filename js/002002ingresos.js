$(document).ready(function () {
    load(1);
    $('#fechaVencimiento').datetimepicker({
        date: null,
        viewMode: 'days',
        format: 'DD/MM/YYYY',
        locale: 'es',
        minDate: 'now',
    });

    $('#fechaVencimiento_mod').datetimepicker({
        date: null,
        viewMode: 'days',
        format: 'DD/MM/YYYY',
        locale: 'es',
        minDate: 'now',
    });

    $('#fil_fecha').datetimepicker({
        date: null,
        viewMode: 'days',
        format: 'MM/YYYY',
        locale: 'es'
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
                var valores = ['id_articulo',
                    'cantidad',
                    'lote',
                    'fecha_vencimiento',
                    'tipo_ingreso',
                    'proveedor',
                    'archivo',
                    'sql'];

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

                    if (valores[i] != 'id_articulo'||valores[i] != 'tipo_ingreso')
                        span = $('#' + valores[i]).siblings();

                    if (errores.hasOwnProperty(valores[i])) {
                        list_error += '<li>' + errores[valores[i]] + '</li>';
                        contenedor.addClass(class_contenedor_error);

                        if (valores[i] != 'id_articulo'||valores[i] != 'tipo_ingreso')
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
    event.preventDefault();
});

function load(page) {
    var q = $("#q").val();
    var fil_fecha = $("#fil_fecha").val();
    /* var fil_estado = $("#fil_estado").val();
     var fil_tipo = $("#fil_tipo").val(); */
    var action = 'ajax';

    $("#loader").fadeIn('slow');
    $.ajax(
        {
            data: {
                q: q,
                fil_fecha: fil_fecha,
                /*      fil_estado: fil_estado,
                    fil_tipo: fil_tipo, */
                action: action,
                page: page
            },
            type: "GET",
            url: './ajax/002002buscar_ingreso.php',
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
    window.location.href = 'ajax/002002descargar.php?id=' + id;
}

$('#editarIngreso').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal 
    var id_ingreso = button.data('id_ingreso')
    var id_articulo = button.data('id_articulo')
    var cantidad = button.data('cantidad')
    var lote = button.data('lote')
    var fecha_vencimiento = button.data('fecha_vencimiento')
    var tipo_ingreso = button.data('tipo_ingreso')
    var proveedor = button.data('proveedor')
    var observacion = button.data('observacion')

    $("#id_ingreso").val(id_ingreso);
    $("#desArticulo_mod").selectpicker("val", id_articulo);
    $("#cantidad_mod").val(cantidad);
    $("#lote_mod").val(lote);
    $("#fechaVencimiento_mod").val(fecha_vencimiento);
    $("#tipoIngreso_mod").selectpicker("val", tipo_ingreso);
    $("#proveedor_mod").val(proveedor);
    $("#observacion_mod").val(observacion);

    $.ajax({
        type: "POST",
        url: "ajax/002002buscar_articulos.php",
        data: { id_articulo: id_articulo },
        dataType: "json",
        success: function (data) {
            if (data) {
                $('#viaAdmin_mod').val(data.forma_farmaceutica + ' ' + data.via_administracion || '');
                $('#lab_mod').val(data.laboratorio || '');
                $('#codIsp_mod').val(data.codigo_isp || '');
                $('#codBarra_mod').val(data.codigo_barra || '');
            }
        }
    });

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


//__________________________editar datos con onclick
$("#actualizar_datos").on("click", function () {
    $('#actualizar_datos').attr("disabled", true);

    var id = $("#id_ingreso").val();
    var cantidad_mod = $("#cantidad_mod").val();
    var fechaVencimiento_mod = $("#fechaVencimiento_mod").val();
    var tipoIngreso_mod = $("#tipoIngreso_mod").val();
    var proveedor_mod = $("#proveedor_mod").val();
    var observacion_mod = $("#observacion_mod").val();
    var action = 'ajax';
    var pagina_actual = $('#pagina_actual').val();

    $.ajax({
        type: "POST",
        url: "ajax/002002editar_ingreso.php",
        data: {
            action: action,
            id: id,
            cantidad_mod: cantidad_mod,
            fechaVencimiento_mod: fechaVencimiento_mod,
            tipoIngreso_mod: tipoIngreso_mod,
            proveedor_mod: proveedor_mod,
            observacion_mod: observacion_mod
        },
        dataType: "json",
        beforeSend: function () {
            $("#resultados_ajax_ingreso").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            var errores = '';
            var contenedor = '';
            var msg = '';
            var list_error = '';
            var class_contenedor_error = 'has-error has-feedback';
            var class_span_error = 'glyphicon glyphicon-remove form-control-feedback';
            var valores = ['cantidad_mod',
                'fechaVencimiento_mod',
                'tipoIngreso_mod',
                'proveedor_mod',
                'update'];

            if (datos.hasOwnProperty('errores')) {
                errores = datos['errores'];
            } else {
                msg = mensaje_retro('success', 'Bien hecho', datos['exito']);
                $("#resultados_ajax_ingreso").html('');
                load(pagina_actual);
            }

            for (var i = 0; i < valores.length; i++) {
                contenedor = $('#' + valores[i]).closest(".form-group ");
                if (valores[i] != 'tipoIngreso_mod')

                    span = $('#' + valores[i]).siblings();

                if (errores.hasOwnProperty(valores[i])) {
                    list_error += '<li>' + errores[valores[i]] + '</li>';
                    contenedor.addClass(class_contenedor_error);
                    if (valores[i] != 'tipoIngreso_mod')

                        span.addClass(class_span_error);
                }
                else {
                    span.removeClass(class_span_error);
                    span.removeClass(class_span_error);
                    contenedor.removeClass(class_contenedor_error);
                }
            }
            if (list_error !== '') {
                msg += '<p> El formulario cuenta con los siguientes errores: </p>';
                msg += '<ul>' + list_error + '</ul>';
                msg = mensaje_retro('danger', 'Error', msg);
            }

            $("#resultados_ajax_ingreso").html(msg);
            $('#actualizar_datos').attr("disabled", false);
        }
    });
});



//_____________________________Guardar datos
$("#motivo_anula").submit(function (event) {
    $('#guardar_motivo').attr("disabled", true);
    var descMotivo = $("#descMotivo").val();
    var id = $("#id_ingreso_motivo").val();
    var page = $("#page_motivo").val();
    var action = 'ajax';

    $.ajax(
        {
            type: "POST",
            url: "ajax/002002registro_motivo.php",
            data: {
                action: action,
                descMotivo: descMotivo,
                id:id
              
            },
            dataType: "json",
            beforeSend: function (objeto) {
                $("#resultados_ajax_motivo").html('<img src="./img/ajax-loader.gif"> Cargando...');
            },
            success: function (datos) {
                var errores = '';
                var contenedor = '';
                var msg = '';
                var list_error = '';
                var class_contenedor_error = 'has-error has-feedback';
                var class_span_error = 'glyphicon glyphicon-remove form-control-feedback';
                var valores = ['descMotivo',
                    'sql'];

                if (datos.hasOwnProperty('errores')) {
                    errores = datos['errores'];
                }
                else {
                    msg = mensaje_retro('success', 'Bien hecho', datos['exito']);
                    $("#resultados_ajax_motivo").html('');
                    load(page);

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
                $("#resultados_ajax_motivo").html(msg);
                $('#guardar_motivo').attr("disabled", false);
            }
        });
    event.preventDefault();
});

$('#motivo').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal 
    var id_ingreso = button.data('id_ingreso')
    var page = button.data('page')

    $("#id_ingreso_motivo").val(id_ingreso);
    $("#page_motivo").val(page);

})

$('#logIngreso').on('show.bs.modal', function (event) {
     var button = $(event.relatedTarget) // Button that triggered the modal 
    var id_ingreso = button.data('id_ingreso')

    $("#id_historial").val(id_ingreso);
  load_ingreso(1);
load_detalle(1, 0);
})


function load_ingreso(page) {

  var action = 'ingreso';
  var id = $("#id_historial").val();

  $.ajax({
    type: "GET",
    url: './ajax/002002log_ingreso.php',
    data: {
      action: action,
      id: id,
      page: page
    },
    beforeSend: function (objeto) {
      $('#loader_historial').html('<img src="./img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {

      $("#resultados_ajax_historial").html(data).fadeIn('slow');
      $('#loader_historial').html('');

    }
  });

}


function load_detalle(page, valor) {

  var action = 'motivo';
  var id = $("#id_historial").val();

  $.ajax({
    type: "GET",
    url: './ajax/002002log_ingreso.php',
    data: {
      action: action,
      id: id,
      page: page
    },
    beforeSend: function (objeto) {
      $('#loader_historial_motivo').html('<img src="./img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {

      $("#resultados_ajax_historial_motivo").html(data).fadeIn('slow');
      $('#loader_historial_motivo').html('');

    }
  });

}

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
