
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
    <form class="form-signin" id="formresetpass">
      <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Recuperar Contraseña</h1>
      <div class="form-group">
        <div class="input-group input-group-lg">
          <span class="input-group-addon"><i class="fa fa-fw fa-envelope-o"></i></span>
          <input type="email" class="form-control" placeholder="Ingrese su usuario" id="emailusu" name="emailusu" autofocus required>
        </div>
      </div>

      <button class="btn btn-lg btn-primary btn-block" type="submit">Recuperar</button>
    </form>
    <?php include('scripts.php'); ?>
  </body>
</html>
