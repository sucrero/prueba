<?php 
  if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
  //session_start();
  $ex = explode('/', $_SERVER['PHP_SELF']);
  
?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php if($ex[2] == 'landing.php'){ echo "active";} ?>">
        <a class="nav-link" href="landing.php">Usuario <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item <?php if($ex[2] == 'crearproceso.php'){ echo "active";} ?>">
        <a class="nav-link" href="crearproceso.php">Crear Proceso</a>
      </li>
      
      <?php 
          if( isset($_SESSION['login'])){
            echo '<li class="nav-item  ">
              <a href="logout.php" class="nav-link">Logout</a>
            </li>';
          } 
        ?>
        </ul>
      <?php if(isset($_SESSION['login'])){ ?>
          <a class="navbar-brand" href="#">Hola, <?php echo $_SESSION['cuenta']; ?></a>
      <?php } ?>
    </ul>
     
  </div>
</nav>