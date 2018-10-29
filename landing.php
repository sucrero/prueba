<?php
  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 
  if( !isset($_SESSION['login']) ){
    header ('Location:index.php');
  }
  include('bdd/config.php');
 
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    

    <title>Index</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">



    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">
  </head>

  <body>

    <?php include('header.php'); ?>

    <main role="main" class="container">

      <!-- <div class="starter-template"> -->
        
      <div class="row">
        
        <div class="col align-self-start"></div>
        <div class="col align-self-center">
        <!-- <h1>Bootstrap starter template</h1>
        <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p> -->
          <div class="card" style="width: 50rem;">
            <h5 class="card-header">registro de Usuarios</h5>
            <div class="card-body">
              <form id="formUsu" name="formUsu">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputAddress">Nombre(s)</label>
                    <input type="text" class="form-control" id="txtnombre" name="txtnombre" placeholder="Ej. Luis José" required autofocus="true">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputAddress2">Apellido(s)</label>
                    <input type="text" class="form-control" id="txtape" name="txtape" placeholder="Ej. Perez Peña" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail4">Login</label>
                    <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="Ej. correo@dominio.com" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputPassword4">Contraseña</label>
                    <input type="password" class="form-control" id="txtpass" name="txtpass" placeholder="Ej. secret" required>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6" id="selectstatus" style="display:none">
                    <label for="country">Status</label>
                    <select class="custom-select d-block w-100" id="statususu" name="statususu" required>
                      <option value="-1">Seleccione...</option>
                      <option value="1">Activado</option>
                      <option value="0">Desactivado</option>
                    </select>
                  </div>
                </div>         
                <input type="hidden" name="idusumod" id="idusumod" value="0">
                <button type="submit" id="regUsu" class="btn btn-primary">Registrar</button>
                <button class="btn btn-primary" id="modUsu" type="button"  style="display:none">Editar</button>
                <button type="button" class="btn btn-warning" id="limpiarUsu">Limpiar</button>

              </form>

            </div>
          </div>

        </div>
        <div class="col align-self-end"></div>

      </div>

      <br>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <h5 class="card-header">Usuario Registrados</h5>
            <div class="card-body">
              <table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover" id="dataTables-usuario">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Nombre</th>
                          <th>Usuario</th>
                          <th>Status</th>
                          <th>Fecha</th>
                          <th>accion</th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
     

    </main><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php include_once('scripts.php'); ?>
    <script>
      $(document).ready(function() {
          
          $.extend( true, $.fn.dataTable.defaults, {
              "responsive": true,
              "serverSide": true,
              "language": {
                  "url": "Spanish.json"
              },
              "columnDefs": [
                { "orderable": false, "targets": 5 },
                { className: "dt-head-center", "targets": -1 }

              ]
          } );
          $('#dataTables-usuario').DataTable({           
              ajax: {
                  /*url: 'avisos-ajax.php',*/
                  url: 'Modelo.php',
                  data: {
                     op: 'usuariosreg'
                  },
                  type: 'POST'
              }
          });
      });
    </script>
  </body>
</html>
