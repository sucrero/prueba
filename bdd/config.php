<?php
	$server = 'db4free.net';
	$username = 'user_pryueba_bdd';
	$password = '1.2.3.4.5.6';
	$database = 'prueba_bdd';
	$port = "3306";

	$con = new mysqli($server, $username, $password, $database, $port);
	if ($con->connect_errno) {
	    echo "Lo sentimos, este sitio web está experimentando problemas.";
	    echo "Error: Fallo al conectarse a MySQL debido a: \n";
	    echo "Errno: " . $mysqli->connect_errno . "\n";
	    echo "Error: " . $mysqli->connect_error . "\n";
	    exit;
	}
	mysqli_set_charset($con,"utf8");