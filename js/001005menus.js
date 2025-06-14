// Autor: Frank Taibo

$(document).ready(function () {
  load(1);
});

function load(page) {
  var q = $("#q").val();
  $("#loader").fadeIn("slow");
  $.ajax({
    url: "./ajax/001005buscar_menus.php?action=ajax&page=" + page + "&q=" + q,
    beforeSend: function (objeto) {
      $("#loader").html('<img src="./img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {
      $(".outer_div").html(data).fadeIn("slow");
      $("#loader").html("");
    },
  });
}

function eliminar(id, nombre) {
  var q = $("#q").val();
  if (confirm("Realmente deseas eliminar menú '" + nombre + "'")) {
    $.ajax({
      type: "GET",
      url: "./ajax/001005buscar_menus.php",
      data: "id=" + id,
      q: q,
      beforeSend: function (objeto) {
        $("#resultados").html("Mensaje: Cargando...");
      },
      success: function (datos) {
        $("#resultados").html(datos);
        load(1);
      },
    });
  }
}

$("#guardar_menu").submit(function (event) {
  $("#guardar_datos").attr("disabled", true);

  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "ajax/001005nuevo_menu.php",
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

$("#editar_menu").submit(function (event) {
  $("#actualizar_datos").attr("disabled", true);

  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "ajax/001005editar_menu.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#resultados_ajax2").html("Mensaje: Cargando...");
    },
    success: function (datos) {
      $("#resultados_ajax2").html(datos);
      $("#actualizar_datos").attr("disabled", false);
      load(1);
    },
  });
  event.preventDefault();
});

$("#myModal2").on("show.bs.modal", function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  var id = button.data("id");
  var nombre = button.data("nombre");
  var codigo = button.data("codigo");
  var estado = button.data("estado");
  var orden = button.data("orden");
  var modal = $(this);
  modal.find(".modal-body #mod_id").val(id);
  modal.find(".modal-body #mod_nombre").val(nombre);
  modal.find(".modal-body #mod_orden").val(orden);
  modal.find(".modal-body #mod_codigo").val(codigo);

  if (estado == 0) modal.find(".modal-body #mod_estado")[0].checked = false;
  else modal.find(".modal-body #mod_estado")[0].checked = true;
});
