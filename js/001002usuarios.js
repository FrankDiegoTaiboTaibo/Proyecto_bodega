$(document).ready(function () {
  load(1);
});

function load(page) {
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

function eliminar(id) {
  var q = $("#q").val();
  if (confirm("Realmente deseas eliminar el usuario")) {
    $.ajax({
      type: "GET",
      url: "./ajax/001002buscar_usuarios.php",
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

function obtener_datos_copia(id) {
  var nombres = $("#nombres" + id).val();
  var apellidos = $("#apellidos" + id).val();
  var usuario = $("#usuario" + id).val();
  var email = $("#email" + id).val();
  var consulta = $("#userconsulta" + id).val();
  var idperfil = $("#userperfilid" + id).val();

  $("#copia_id").val(id);
  $("#copia_firstname").val(nombres + " COPIA");
  $("#copia_lastname").val(apellidos + " COPIA");
  $("#copia_user_name").val(usuario + "copia");
  $("#copia_user_email").val(email + "");
  $("#copia_user_consulta").val(consulta);
  $("#copia_id_perfil").val(idperfil);
}

$("#guardar_usuario").submit(function (event) {
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

$("#editar_usuario").submit(function (event) {
  $("#actualizar_datos2").attr("disabled", true);

  var parametros = $(this).serialize();

  $.ajax({
    type: "POST",
    url: "ajax/001002editar_usuario.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#resultados_ajax2").html("Mensaje: Cargando...");
    },
    success: function (datos) {
      $("#resultados_ajax2").html(datos);
      $("#actualizar_datos2").attr("disabled", false);
      load(1);
    },
  });
  event.preventDefault();
});

$("#editar_password").submit(function (event) {
  $("#actualizar_datos3").attr("disabled", true);

  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "ajax/001002editar_password.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#resultados_ajax3").html("Mensaje: Cargando...");
    },
    success: function (datos) {
      $("#resultados_ajax3").html(datos);
      $("#actualizar_datos3").attr("disabled", false);
      load(1);
    },
  });
  event.preventDefault();
});
function get_user_id(id) {
  $("#user_id_mod").val(id);
}

function obtener_datos(id) {
  var nombres = $("#nombres" + id).val();
  var apellidos = $("#apellidos" + id).val();
  var usuario = $("#usuario" + id).val();
  var email = $("#email" + id).val();
  var consulta = $("#userconsulta" + id).val();
  var user_password_set = $("#user_password_set" + id).val();
  var idperfil = $("#userperfilid" + id).val();
  var userrut = $("#userrut" + id).val();

  if (consulta == 1) $("#user_consulta2").prop("checked", true);
  else $("#user_consulta2").prop("checked", false);

  if (user_password_set == 1) $("#user_password_set2").prop("checked", true);
  else $("#user_password_set2").prop("checked", false);

  $("#mod_id").val(id);
  $("#firstname2").val(nombres);
  $("#lastname2").val(apellidos);
  $("#user_name2").val(usuario);
  $("#user_rut2").val(userrut);
  $("#user_email2").val(email);
  $("#user_idperfil2").val(idperfil);
}

$("#myModal4").on("show.bs.modal", function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  var id = button.data("id");
  var perfil = button.data("perfil");
  var name = button.data("name");
  var des_perfil = button.data("des_perfil");

  $.ajax({
    type: "GET",
    url: "ajax/001002ver_usuario.php",
    data: { id: id, perfil: perfil, name: name, des_perfil: des_perfil },
    success: function (data) {
      $("#ver_ajax_usuario").html(data);
      $("#name").html(name);
    },
  });
});
