<?php
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	if(!isset($_SESSION['login'])){
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
    <link rel="stylesheet" href="bootstrap-datepicker/css/bootstrap-datepicker.min.css">




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
            <h5 class="card-header">Datos del Proceso</h5>
            <div class="card-body">
              <form id="formproces" name="formproces">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputAddress">Número de Proceso</label>
                    <input type="text" class="form-control" id="txtnum" name="txtnum" placeholder="Ej. abc12345" required autofocus="true" maxlength="8">
                    <small id="emailHelp" class="form-text text-muted">El código debe tener 8 carcateres.</small>
                  </div>
                  <div class="form-group col-md-6 date">
                    <label for="inputEmail4">Fecha Creación</label>
                    <!-- <input type="text" class="form-control" id="txtfecha" name="txtfecha" required value="<?php //echo date("d-m-Y"); ?>" readonly> -->
                    <div class="input-group">
                    	
	                    	<input type="text" class="form-control" id="txtfecha" name="txtfecha">
	                    	<div class="input-group-prepend">
							    <span class="input-group-text" id="cal"><i class="fas fa-calendar-alt"></i></span>
							  </div>
                    	
                	</div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputPassword4">Presupuesto</label>
                    <input type="text" class="form-control" id="txtpresupuesto" name="txtpresupuesto" placeholder="Ej. 1.250,15">
                    <small id="emailHelp" class="form-text text-muted">
			          Ingrese el valor en Pesos Colombianos (COP)
			      </small>
                  </div>
                  <div class="form-group col-md-6" id="selectstatus">
                    <label for="country">Sede</label>
                    <select class="custom-select d-block w-100" id="selsede" name="selsede">
                      <option value="">Seleccione...</option>
                      <option value="bogotá">Bogotá</option>
                      <option value="méxico">México</option>
                      <option value="perú">Peru</option>
                    </select>
                  </div>
					
                </div>

                <div class="form-row">
                  
					<div class="form-group col-md-12">
	                    <label for="inputAddress2">Descripción</label>
	                    <textarea class="form-control" id="txtdescrip" name="txtdescrip" rows="3" required></textarea>
	                    <h6 id="contador">200</h6>
	                    
                  	</div>
                  
                </div>         
                
                <button type="submit" id="regUsu" class="btn btn-primary">Registrar</button>
                <button type="button" class="btn btn-warning" id="limpiarProc">Limpiar</button>

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
	            <h5 class="card-header">Procesor Registrados</h5>
	            <div class="card-body">
	              <table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover" id="dataTables-proceso">
	                  <thead>
	                      <tr>
	                          <th>ID</th>
	                          <th>Número</th>
	                          <th>Fecha</th>
	                          <th>Presupuesto $</th>
	                          <th>Presupuesto USD</th>
	                          <th>Sede</th>
	                          <th>Descripción</th>
	                          <th>Ver</th>
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
          

          $('#dataTables-proceso').DataTable({     
          		"responsive": true,
              "serverSide": true,
              "language": {
                  "url": "Spanish.json"
              },
              "columnDefs": [
               { "orderable": false, "targets": 7 },
                { className:"text-right", "targets": [2,3,4] },
                { className:"text-center", "targets": [0] },
              ],   
              ajax: {
                  url: 'Modelo.php',
                  data: {
                     op: 'procesosreg'
                  },
                  type: 'POST'
              }
          });

         	var table = $('#dataTables-proceso').DataTable();
     
		    $('#dataTables-proceso tbody').on('click', 'tr', function () {
		        var data = table.row( this ).data();
		        var datos = {
		        	id: data[0],
		        	num: data[1],
		        	fec: data[2],
		        	prep: data[3],
		        	pred: data[4],
		        	sed: data[5],
		        	des: data[6]
		        }
		        $.ajax({
	                type:'POST',
	                url:'https://prueba-conforce.herokuapp.com/Modelo.php',
	                data:'datos='+JSON.stringify(datos)+'&op=viewproc',
	                success:function(resp){
	                    ir('mostrar.php');
	                }
	            }); 
		    } );
      });
    </script>
  </body>
</html>
