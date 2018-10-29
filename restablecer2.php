<?php 
  include_once("clases/Usuario.Class.php");
  include_once("bdd/config.php");

  if($_GET){
    if((isset($_GET['idusuario']) && isset($_GET['token'])) && ($_GET['idusuario'] != '' && isset($_GET['token']) != '')){
      $objUsu= new Usuario();

      $resp = $objUsu->verificardatos($_GET,$con);
      
      if($resp == 0 || $resp == 1 || $resp ==3){
        header('Location: index.php');
      }
    }else{
      /*JSON(false,"Operacion Desconocida");*/
      header('Location: index.php');
    }
  }else{
    header('Location: index.php');
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Iniciar Sesión</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    
  </head>

  <body>
    <div class="container">
          
      <div class="row align-items-center">
        <div class="col-3"></div>
        <div class="col-6">
          <div class="card">
            <h5 class="card-header">Cambio de contraseña</h5>
            <div class="card-body">
              <!--  -->
              
              <div class="col-sm-6">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">
                        Restablecer su contraseña
                      </h3>
                  </div>
                  <div class="panel-body">
                      <form role="form" id="cambiarpass">
                        <fieldset>
                          
                          <div class="form-group">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-fw fa-key"></i></span>
                              <input type="password" class="form-control" placeholder="Nueva contraseña" id="cla1" name="cla1">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-fw fa-key"></i></span>
                              <input type="password" class="form-control" placeholder="Confirmar contraseña" id="cla2" name="cla2">
                            </div>
                          </div>
                          <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                          <input type="hidden" name="usuario" value="<?php echo $_GET['idusuario']; ?>">
                          <input class="btn btn-primary" type="submit" value="Recuperar contraseña">
                        </fieldset>
                      </form>
                    </div>
                  </div>
                </div> 

            </div>
          </div>
        </div>
        <div class="col-3"></div>
      </div>
    </div>
    
    <?php include_once('scripts.php'); ?>
  </body>
</html>