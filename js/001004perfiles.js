$(document).ready(function(){
  load(1);
});

function load(page){

  var q= $("#q").val();
  $("#loader").fadeIn('slow');
  $.ajax({
    url:'./ajax/001004buscar_perfiles.php?action=ajax&page='+page+'&q='+q,
      beforeSend: function(objeto){
      $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
    },
    success:function(data){
      $(".outer_div").html(data).fadeIn('slow');
      $('#loader').html('');      
    }
  })
}

function eliminar (id){

  var q= $("#q").val();
  if (confirm("Realmente deseas eliminar el perfil")){  
    $.ajax({
        type: "GET",
        url: "./ajax/001004buscar_perfiles.php",
        data: "id="+id,"q":q,
      beforeSend: function(objeto){
        $("#resultados").html('<img src="./img/ajax-loader.gif"> Cargando...');
      },
      success: function(datos){
        $("#resultados").html(datos);
        load(1);
      }
    });
  }
}

$( "#guardar_perfil" ).submit(function( event ) {

  var parametros = $(this).serialize(); 
  $('#guardar_datos').attr("disabled", true);
  $.ajax({
    type: "POST",
    url: "ajax/001004nuevo_perfiles.php",
    data: parametros,
     beforeSend: function(objeto){
      $("#resultados_ajax").html('<img src="./img/ajax-loader.gif"> Cargando...');
      },
    success: function(datos){
    $("#resultados_ajax").html(datos);
    $('#guardar_datos').attr("disabled", false);
    load(1);
    }
  });
  event.preventDefault();
})

$( "#editar_perfiles" ).submit(function( event ) {
  $('#actualizar_datos2').attr("disabled", true);
  
 var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "ajax/001004editar_perfiles.php",
      data: parametros,
       beforeSend: function(objeto){
        $("#resultados_ajax2").html('<img src="./img/ajax-loader.gif"> Cargando...');
        },
      success: function(datos){
      $("#resultados_ajax2").html(datos);
      $('#actualizar_datos2').attr("disabled", false);
      load(1);
      }
  });
  event.preventDefault();
}) 

$('#ver_usuarios').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget)
  var id = button.data('id'); 

  $.ajax({
    type: "POST",
    data:{
      action: 'ajax',
      id: id
    },
    url: "ajax/001004ver_usuarios.php",
     beforeSend: function(objeto){
      $("#resultados_usuarios").html('<img src="./img/ajax-loader.gif"> Cargando...');
      },
    success: function(datos){
      $("#resultados_usuarios").html(datos);
    }
  });

});

$('#ver_accesos').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget)
  var id = button.data('id'); 

  $.ajax({
    type: "POST",
    data:{
      action: 'ajax',
      id: id
    },
    url: "ajax/001004ver_accesos.php",
     beforeSend: function(objeto){
      $("#resultados_accesos").html('<img src="./img/ajax-loader.gif"> Cargando...');
      },
    success: function(datos){
      $("#resultados_accesos").html(datos);
    }
  });

});

function get_user_id(id){
  $("#user_mod").val(id);
}

function obtener_datos(id){
  var perfil = $("#perfil"+id).val();
  $("#mod_id").val(id);
  $("#perfil2").val(perfil);
}
    

$('#myModal4').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget)
  var id = button.data('id');
  var descripcion = button.data('descripcion');

  $("#perfil_descripcion_duplicar").val(descripcion);
  $("#duplicar_id").val(id);


});


$( "#duplicar_perfil" ).submit(function( event ) {

  $('#duplicar_datos').attr("disabled", true);

  var id = $("#duplicar_id").val();
  var perfil_descripcion = $("#perfil_descripcion_duplicar").val();

  
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "ajax/001004duplicar_perfiles.php",
    data:{
      action: 'ajax',
      id: id,
      perfil_descripcion: perfil_descripcion
    },
    beforeSend: function(objeto){
      $("#resultados_ajax4").html('<img src="./img/ajax-loader.gif"> Cargando...');
      },
    success: function(datos){
    $("#resultados_ajax4").html(datos);
    $('#duplicar_datos').attr("disabled", false);
    load(1);
    }
  });
  event.preventDefault();
}) 
    
    
    

