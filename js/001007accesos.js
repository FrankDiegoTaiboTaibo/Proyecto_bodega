    $(document).ready(function(){
      load(1);
    });

    function load(page){
      var q= $("#q").val();
      $("#loader").fadeIn('slow');
      $.ajax({
        url:'./ajax/001007buscar_accesos.php?action=ajax&page='+page+'&q='+q,
         beforeSend: function(objeto){
         $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
        },
        success:function(data){
          $(".outer_div").html(data).fadeIn('slow');
          $('#loader').html('');
          
        }
      })
    }


$( "#editar_accesos" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "ajax/001007editar_accesos.php",
      data: parametros,
       beforeSend: function(objeto){
        $("#resultados_ajax2").html("Mensaje: Cargando...");
        },
      success: function(datos){
      $("#resultados_ajax2").html(datos);
      $('#actualizar_datos').attr("disabled", false);
      load(1);
      }
  });
  event.preventDefault();
})

  
  $('#myModal2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id_perfil = button.data('id_perfil')
    var nombre_perfil = button.data('nombre_perfil')
    var items_ids = JSON.parse("[" + button.data('items_ids') + "]")
    var modal = $(this)

    modal.find('.modal-body #mod_nombre_perfil').val(nombre_perfil)
    modal.find('.modal-body #mod_id_perfil').val(id_perfil)

    //Limpieza de checkboxs
    var checkboxs = modal.find('.modal-body .checkboxs')
    for (var indice in checkboxs) {
     checkboxs[indice].checked = false;
    }

    //Marcado del checkboxs
    for (var indice in items_ids) {
      var id_item = '.modal-body #mod_item_'+items_ids[indice];
      modal.find(id_item)[0].checked = true;
    }

    //Por ser checksboxs generados dinámicamente, los nombres deben ser generados
    var nombres_checksboxs = ""

    for (var indice in checkboxs) {
      var nombre_item = checkboxs[indice].id

      if(nombre_item != undefined  && nombre_item != 'myModal2')
        nombres_checksboxs += nombre_item+";"
    }

    modal.find('.modal-body #mod_nombres_checkboxs').val(nombres_checksboxs)

  });

  $('#btn_todos').on('click', function(event){

    var checkboxs = $('#myModal2').find('.modal-body .checkboxs')
    for (var indice in checkboxs) {
     checkboxs[indice].checked = true;
    }


  });


  $('#btn_ninguno').on('click', function(event){

    var checkboxs = $('#myModal2').find('.modal-body .checkboxs')
    for (var indice in checkboxs) {
     checkboxs[indice].checked = false;
    }

  });

  $('.menu_checkboxs').on('click', function(event){

    var menu_id = $(this).data('id');
    var checks = $(this).data('checks');
    var checkboxs = $('#myModal2').find('.modal-body .menu_checkboxs_'+menu_id);

    if(checks == 0){

      $(this).data('checks', 1);

      for (var indice in checkboxs) {
        checkboxs[indice].checked = true;
      }

    }
    else{

      $(this).data('checks', 0);

      for (var indice in checkboxs) {
        checkboxs[indice].checked = false;
      }

    }

    console.log(checkboxs);

  });
    

