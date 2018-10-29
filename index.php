
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" id="formlogin">
      
      <h1 class="h3 mb-3 font-weight-normal">Por favor Inicie Sesión</h1>
      <label for="inputEmail" class="sr-only">Correo electrónico</label>
      <input type="email" id="loginusu" name="loginusu" class="form-control" placeholder="Email" required autofocus>
      <label for="inputPassword" class="sr-only">Contraseña</label>
      <input type="password" id="claveusu" name="claveusu" class="form-control" placeholder="Contraseña" required>
      <div class="checkbox mb-3">
        <label>
          <a href="resetpass.php">¿Olvidaste tu contraseña?</a>
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      
    </form>
    <?php include_once('scripts.php'); ?>
  </body>
</html>
