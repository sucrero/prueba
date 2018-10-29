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

    <title>Recuperar contraseña</title>

    <!-- Bootstrap core CSS -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" id="cambiarpass">
      <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Modificar Contraseña</h1>

      <div class="form-group">
        <div class="input-group input-group-lg">
          <span class="input-group-addon"><i class="fa fa-fw fa-key"></i></span>
          <input type="password" class="form-control" placeholder="Nueva contraseña" id="cla1" name="cla1" required autofocus>
        </div>
      </div>
      <div class="form-group">
        <div class="input-group input-group-lg">
          <span class="input-group-addon"><i class="fa fa-fw fa-key"></i></span>
          <input type="password" class="form-control" placeholder="Confirmar contraseña" id="cla2" name="cla2" required>
        </div>
      </div>
      <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
      <input type="hidden" name="usuario" value="<?php echo $_GET['idusuario']; ?>">
     

      <button class="btn btn-lg btn-primary btn-block" type="submit">Cambiar</button>
    </form>
    <?php include('scripts.php'); ?>
  </body>
</html>
