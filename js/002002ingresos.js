$(document).ready(function () {
   $('#fechaVencimiento').datetimepicker({
    date: null,
    viewMode: 'days',
    format: 'DD/MM/YYYY',
    locale: 'es',
    minDate: 'now',

  });

  $('#desArticulo').on('change', function() {
    var idArticulo = $(this).val();

    if (idArticulo !== '') {
      $.ajax({
        type: "POST",
        url: "ajax/002002buscar_articulos.php",
        data: { id_articulo: idArticulo },
        dataType: "json",
        success: function(data) {
          if (data) {
            $('#viaAdmin').val(data.forma_farmaceutica+' '+data.via_administracion || '');
            $('#lab').val(data.laboratorio || '');
            $('#codIsp').val(data.codigo_isp || '');
            $('#codBarra').val(data.codigo_barra || '');
          }
        },
        error: function() {
          alert("Hubo un error al obtener los datos del artículo.");
        }
      });
    }
  });

  load(1);
 
});



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
