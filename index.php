<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/estilos.css">


  <title>CRUD con PHP, PDO, Ajax y Datatables.js</title>
</head>

<body>
  <div class="container fondo">
    <h1 class="text-center">CRUD con PHP, PDO, Ajax y Datatables.js</h1>

    <div class="row">
      <div class="col-2 offset-10">
        <div class="text-center">
          <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalUsuario" id="botonCrear">
            <i class="bi bi-plus-circle-fill"> </i> Crear
          </button>
        </div>
      </div>
    </div>
    <br />
    <br />

    <div class="table-responsive">
      <table id="datos_usuario" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Telefono</th>
            <th>Email</th>
            <th>imagen</th>
            <th>Fecha Creación</th>
            <th>Editar</th>
            <th>Borrar</th>
          </tr>
        </thead>
      </table>

    </div>
  </div>

  <!--Modal-->
  <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ingresar Registro</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form method="POST" id="formulario" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-body">
              <label for="nombre">Ingrese el nombre</label>
              <input type="text" name="nombre" id="nombre" class="form-control">
              <br />

              <label for="apellidos">Ingrese los apellidos</label>
              <input type="text" name="apellidos" id="apellidos" class="form-control">
              <br />

              <label for="telefono">Ingrese el telefono</label>
              <input type="text" name="telefono" id="telefono" class="form-control">
              <br />

              <label for="email">Ingrese el email</label>
              <input type="email" name="email" id="email" class="form-control">
              <br />

              <label for="imagen">seleccione una imagen</label>
              <input type="file" name="imagen_usuario" id="imagen_usuario" class="form-control">
              <span id="imagen_subida"></span>
              <br />

            </div>

            <div class="modal-footer">
              <input type="hidden" name="id_usuario" id="id_usuario">
              <input type="hidden" name="operacion" id="operacion">
              <input type="submit" value="Crear" name="action" id="action" class="btn btn-success">
            </div>
          </div>
        </form>
      </div>


    </div>
  </div>

  <!-- Optional JavaScript; choose one of the two! -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

  <script type="text/javascript">
    $(document).ready(function() {
          $("#botonCrear").click(function() {
            $("#formulario")[0].reset();
            $(".modal-title").text("crear usuario");
            $("#action").val("Crear");
            $("#operacion").val("Crear");
            $("#imagen_subida").html("");

          });


          var dataTable = $("#datos_usuario").DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              "ajax": {
                url: "obtener_registros.php",
                type: "POST"
              },
              "columnsDefts": [{
                "targets": [0, 3, 4],
                "orderable": false,
              },
            ],
              "language": {
                "decimal": "",
                "emptyTable": "No hay registros",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                  "first": "Primero",
                  "last": "Ultimo",
                  "next": "Siguiente",
                  "previous": "Anterior"
                }
              }


              });

            $(document).on('submit', '#formulario', function(event) {
              event.preventDefault();

              var nombres = $("#nombre").val();
              var apellidos = $("#apellidos").val();
              var telefono = $("#telefono").val();
              var email = $("#email").val();
              var extension = $("#imagen_usuario").val().split('.').pop().toLowerCase();

              if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == 1) {
                  alert("formato de imagen invalido");
                  $("#imagen_usuario").val('');
                  return false;
                }
              }


              if (nombres != '' && apellidos != '' && email != '') {
                $.ajax({
                  url: "crear.php",
                  method: "POST",
                  data: new FormData(this),
                  contentType: false,
                  processData: false,
                  success: function(data) {
                    alert(data);
                    $('#formulario')[0].reset();
                    $('#modalUsuario').modal('hide');
                    dataTable.ajax.reload();
                  }

                });
              } else {
                alert("Algunos campos son obligatorios");
              }


            });

            //Funcionalida de editar
            $(document).on('click', '.editar', function() {
              var id_usuario = $(this).attr("id");
              $.ajax({
                url: "obtener_registro.php",
                method: "POST",
                data: {
                  id_usuario: id_usuario
                },
                dataType: "json",
                success: function(data) {
                  //console.log(data);				
                  $('#modalUsuario').modal('show');
                  $('#nombre').val(data.nombre);
                  $('#apellidos').val(data.apellidos);
                  $('#telefono').val(data.telefono);
                  $('#email').val(data.email);
                  $('.modal-title').text("Editar Usuario");
                  $('#id_usuario').val(id_usuario);
                  $('#imagen_subida').html(data.imagen_usuario);
                  $('#action').val("Editar");
                  $('#operacion').val("Editar");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  console.log(textStatus, errorThrown);
                }
              })
            });

            $(document).on('click', '.borrar', function() {
              var id_usuario = $(this).attr("id");
              if (confirm("esta seguro de borrar este registro:" + id_usuario)) {
                $.ajax({
                  url: "borrar.php",
                  method: "POST",
                  data: {
                    id_usuario: id_usuario
                  },
                  success: function(data) {
                    alert(data),
                      dataTable.ajax.reload();
                  }

                });
              } else {
                return false;
              }


            });



          });
  </script>
</body>

</html>