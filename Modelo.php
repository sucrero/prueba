<?php

	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	include_once('bdd/config.php');
	include_once('clases/JSON.php');
	
	if(isset($_REQUEST['op'])){
		include_once('clases/Usuario.Class.php');
		include_once('clases/Proceso.Class.php');
	
		$objUsu = new Usuario();
		$objProc = new Proceso();
			  
		switch ($_REQUEST['op']) {
			case 'valsesion':
				
				$resp = $objUsu->valLogin($_REQUEST['loginusu'],$con,$_REQUEST['claveusu']);

				break;
			case 'registrousu'://funciona
				$resp = $objUsu->buscarUsu($_REQUEST['txtemail'],$con);
				if($resp == 1){
					$resp = $objUsu->ingresar($_REQUEST,$con);
				}
				
				break;

			case 'usuariosreg'://funciona
				$requestData= $_REQUEST;


				$columns = array( 
					0 => 'idusuario',
					1 => 'nombreusu',
					2 => 'apeusu',
					3 => 'loginusu', 
					4 => 'status',
					5 => 'fechaalta',
				);

				$sql = "SELECT *, DATE_FORMAT(fechaalta, '%d-%m-%Y') as fa ";
				$sql.=" FROM usuario";
				$query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get InventoryItems");
				$totalData = mysqli_num_rows($query);
				$totalFiltered = $totalData;  //


				if( !empty($requestData['search']['value']) ) {
					$sql = "SELECT *, DATE_FORMAT(fechaalta, '%d-%m-%Y') as fa ";
					$sql.=" FROM usuario";
					$sql.=" WHERE nombreusu LIKE '".$requestData['search']['value']."%' ";    
					$sql.=" OR apeusu LIKE '".$requestData['search']['value']."%' ";
					$sql.=" OR loginusu LIKE '".$requestData['search']['value']."%' ";
					
					$query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get PO");
					$totalFiltered = mysqli_num_rows($query);

					$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
					$query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get PO");
					
				} else {	

					$sql = "SELECT *, DATE_FORMAT(fechaalta, '%d-%m-%Y') as fa ";
					$sql.=" FROM usuario";
					$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
					$query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get PO");
					
				}
				$json = new Services_JSON();
				$data = array();
				while( $row=mysqli_fetch_array($query) ) {  // preparing an array
					$nestedData=array(); 
					$datos = $json->encode($row);
					if($row["status"] == 1){
						$status = "Activo";
					}else{
						$status = "Inactivo";
					}

					$nestedData[] = $row["idusuario"];
					$nestedData[] = ucfirst($row["nombreusu"]).' '.ucfirst($row["apeusu"]);
					$nestedData[] = $row["loginusu"];
					$nestedData[] = $status;
				    $nestedData[] = $row['fa'];
				    $nestedData[] = "<td><center>
				                     	<a onclick='editar(".$datos.");' data-toggle='tooltip' title='Editar' class='btn btn-sm'> <i class='fas fa-pencil-alt'></i></a> | 
											<a onclick='eliminarusu(".$row["idusuario"].")' data-toggle='tooltip' title='Eliminar'> <i class='fas fa-trash-alt'></i> </a>
								     </center></td>";
					$data[] = $nestedData;
				    
				}
				$resp = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   // total data array
				);

				break;
			case 'editusu'://funciona
					if($_REQUEST['idusumod'] != '' && $_REQUEST['idusumod'] != 0){
						$resp = $objUsu->editar($_REQUEST,$con);
					}else{
						$resp = 3;
					}
				break;
			case 'deleteusu'://funciona

				$resp = $objUsu->desactivar($_REQUEST,$con);

				break;

			case 'resetpass':

				$resp = $objUsu->solResetPass($_REQUEST,$con);

				break;

			case 'cambiarpass':

				$resp = $objUsu->cambiarclave($_REQUEST,$con);
				
				break;

			case 'guardarproceso':

				$resp = $objProc->guardarProceso($_REQUEST,$con);

				break;

			case 'procesosreg'://funciona
				$requestData= $_REQUEST;


				$columns = array( 
					0 => 'idproces',
					1 => 'numproces',
					2 => 'descrip',
					3 => 'fecalta', 
					4 => 'sede',
					5 => 'presupuesto',
				);

				$sql = "SELECT *, DATE_FORMAT(fecalta, '%d-%m-%Y') as fa ";
				$sql.=" FROM proceso";
				$query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get InventoryItems");
				$totalData = mysqli_num_rows($query);
				$totalFiltered = $totalData;  //


				if( !empty($requestData['search']['value']) ) {
					$sql = "SELECT *, DATE_FORMAT(fecalta, '%d-%m-%Y') as fa ";
					$sql.=" FROM proceso";
					$sql.=" WHERE numproces LIKE '".$requestData['search']['value']."%' ";    
					$sql.=" OR descrip LIKE '".$requestData['search']['value']."%' ";
					$sql.=" OR sede LIKE '".$requestData['search']['value']."%' ";
					
					$query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get PO");
					$totalFiltered = mysqli_num_rows($query);

					$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
					$query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get PO");
					
				} else {	

					$sql = "SELECT *, DATE_FORMAT(fecalta, '%d-%m-%Y') as fa ";
					$sql.=" FROM proceso";
					$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
					$query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get PO");
					
				}
				$json = new Services_JSON();
				$data = array();
				while( $row=mysqli_fetch_array($query) ) {  // preparing an array
					$nestedData=array(); 
					$datos = $json->encode($row);

					$prePeso = number_format($row["presupuesto"], 2, ',', '.');
					$preDol = number_format(($row["presupuesto"]*3000), 2, ',', '.');

					$obj = (object) array('id' => $row["idproces"], 'num' => $row["numproces"], 'fec' => $row["fa"], 'prep' => $prePeso, 'pred' => $preDol, 'sed' => $row["sede"], 'des' => $row["descrip"]);

					$nestedData[] = $row["idproces"];
					$nestedData[] = $row["numproces"];
					$nestedData[] = $row["fa"];
					$nestedData[] = $prePeso;
				    $nestedData[] = $preDol;
				    $nestedData[] = $row["sede"];
				    $nestedData[] = $row["descrip"];
				     $nestedData[] = "<td><center>
				                      	<a onclick='verProceso(".$json->encode($obj).");' data-toggle='tooltip' title='Ver' class='btn btn-sm'><i class='far fa-eye'></i></a></td>";
					$data[] = $nestedData;
				    
				}
				$resp = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   // total data array
				);

				break;

			case 'viewproc':

				$_SESSION['idproceso'] = $_REQUEST['datos'];
				$resp = 1;

				break;

			case 'editproceso':

				$resp = $objProc->editarProceso($_REQUEST,$con);

				break;
////////////////////////////////////////////			
			case 'borrarProy':
				$directorio = "C:/xampp/htdocs/proyecto/proyectos/".$_REQUEST['nomproy'];

				function deleteDirectory($dir) {
				    if(!$dh = @opendir($dir)) return;
				    while (false !== ($current = readdir($dh))) {
				        if($current != '.' && $current != '..') {
				            if (!@unlink($dir.'/'.$current)) 
				                deleteDirectory($dir.'/'.$current);
				        }       
				    }
				    closedir($dh);
				    @rmdir($dir);
				}
				deleteDirectory($directorio);

				$dirVideo = "C:/xampp/htdocs/proyecto/videos/".$_REQUEST['nomproy'].".mp4";
				unlink($dirVideo);

				$sql = "DELETE FROM proyecto WHERE nombre = '".strtolower($_REQUEST['nomproy'])."'";
				$objProy->editar($sql,$con);
				
				$resp = 1;
				break;
			case 'grabar':
				
				$sql = "UPDATE proyecto set convertido= 1 WHERE idproyecto = ".$_REQUEST['codproy'];	
				$objProy->editar($sql,$con);		
				/*if($retorno = system('C:\xampp\htdocs\proyecto\grabar.bat 2>&1',$devuelto)){
					$resp = 1;
				}else{
					$resp = 0;
				}*/
				$resp = 1;
				break;
			
			case 'registronivel'://funciona
				
				$objNiv->setPropiedades($_REQUEST['nombreniv']);
				if($objNiv->ingresar($con)){
					$resp = 1;//registro exitoso
				}else{
					$resp = 0;//registro no exitoso
				}
			
				
				break;
			
			case 'editusu'://funciona
				if($_REQUEST['idusumod'] != '' && $_REQUEST['idusumod'] != 0){
					$sql = "UPDATE usuario SET nombreusu='".strtolower($_REQUEST['firstName'])."', apeusu='".strtolower($_REQUEST['lastName'])."', status='".$_REQUEST['statususu']."', nivel='".$_REQUEST['nivel']."', emailusu='".$_REQUEST['useremail']."' WHERE idusuario = '".$_REQUEST['idusumod']."'";
					if($objUsu->editar($sql,$con)){
						$resp = 1;//registro exitoso
					}else{
						$resp = 2;//registro no exitoso
					}
				}else{
					$resp = 3;
				}
				break;

			case 'editniv'://funciona
				if($_REQUEST['idnivel'] != '' && $_REQUEST['idnivel'] != 0){
					$sql = "UPDATE nivel SET nombre='".strtolower($_REQUEST['nombreniv'])."' WHERE idnivel = '".$_REQUEST['idnivel']."'";
					if($objNiv->editar($sql,$con)){
						$resp = 1;//registro exitoso
					}else{
						$resp = 2;//registro no exitoso
					}
				}else{
					$resp = 3;
				}
				break;


			
			
			

			
			case 'guardarpublica':
					$servicios = array();
					$i=0;
					foreach($_REQUEST as $nombre_campo => $valor){
						if(substr($nombre_campo, 0,4) == "serv"){
							$cod = explode("-", $nombre_campo);
							$servicios[$i]["cod"] = $cod[1];
							$servicios[$i++]["val"] = $valor;
						}
					} 

					$sql = "SELECT valor FROM avisos WHERE idavisos='".$_REQUEST['tipoaviso']."'";
					$resp = $objAvi->buscar($sql,$con);
					$row = $resp->fetch_array(MYSQLI_ASSOC);
					$total = floatval($_REQUEST['cantdias'])*floatval($row['valor']);
					
					$sql = "SELECT * FROM saldo WHERE usuario_idusuario= '". $_SESSION['idusu']."'";
					$resp = $objAvi->buscar($sql,$con);
					$rowSal = $resp->fetch_array(MYSQLI_ASSOC);
					if(floatval($rowSal['valorsaldo']) > $total){//tiene saldo para publicar
						$resto = floatval($rowSal['valorsaldo']) - $total;
						$sql = "UPDATE persona SET 
								nombreper = '". strtolower($_REQUEST['f1-nomb-fan']) ."',
								edadper = '".$_REQUEST['f1-edad']."',
								nrocelularper = '".$_REQUEST['f1-nro-cel']."',
								valorhora = '".$_REQUEST['f1-valor-una']."',
								valormediahora = '".$_REQUEST['f1-valor-media']."' WHERE idpersona = '".$_SESSION['idper']."'";
						if($objPer->actualizar($sql,$con)){//actualizó los datos del usuario con exito
							
							for ($i=0;$i < count($servicios);$i++){
								if(strtolower($servicios[$i]["val"]) == "no"){
									$sql = "DELETE FROM usuario_has_servicio WHERE usuario_idusuario = '".$_SESSION['idusu']."' AND servicio_idservicio = '".$servicios[$i]["cod"]."' ";	
									$objServ->eliminarSer($sql,$con);
								}else{
									$sql = "SELECT * FROM usuario_has_servicio WHERE servicio_idservicio = '".$servicios[$i]["cod"]."' AND usuario_idusuario = '".$_SESSION['idusu']."'";
									if($objServ->buscar($sql,$con) <= 0){
										$sql = "INSERT INTO usuario_has_servicio (usuario_idusuario,servicio_idservicio,mostrar) VALUES 
										('".$_SESSION['idusu']."','".$servicios[$i]["cod"]."','1')";
										$objServ->eliminarSer($sql,$con);
									}
								}
								
							}
							$objAviUsu->setPropiedades($_REQUEST['tipoaviso'],$_REQUEST['descripcorta'],$_REQUEST['obser1'],$_REQUEST['cantdias'],
							$_REQUEST['categaviso'],$_REQUEST['colcabello'],$_REQUEST['colpiel'],$_SESSION['idusu'],$_SESSION['idper'],$total);
							if($objAviUsu->ingresar($con)){//aviso-usuario guardado
								$sql = "UPDATE saldo SET valorsaldo = '".$resto."' WHERE usuario_idusuario='".$_SESSION['idusu']."'";
								if($objServ->eliminarSer($sql,$con)){
									$resp = 4;
								}else{//no se pudo descontar el saldo
									$resp = 3;	
								}
								
							}else{//error al guardar aviso-usuario
								$resp = 1;
							}
						}else{//erroa l actualizar los datos del usuari
							$resp = 2;
						}
					}else{//no tiene suficiente saldo
						$resp = 0;
					}			
					break;
				
			case 'nivelesreg'://funciona
					$requestData= $_REQUEST;
					$columns = array( 
					// datatable column index  => database column name
						0 => 'idnivel',
					    1 => 'nombre'
					);

					$sql = "SELECT * ";
					$sql.=" FROM nivel";
					$query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get InventoryItems");
					$totalData = mysqli_num_rows($query);
					$totalFiltered = $totalData;  //


					if( !empty($requestData['search']['value']) ) {
						// if there is a search parameter
						$sql = "SELECT * ";
						$sql.=" FROM nivel";
						$sql.=" WHERE nombre LIKE '".$requestData['search']['value']."%'";    
						$query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get PO");
						$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

						$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
						$query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get PO"); // again run query with limit
						
					} else {	

						$sql = "SELECT * ";
						$sql.=" FROM nivel";
						$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
						$query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get PO");
						
					}
					$json = new Services_JSON();
					$data = array();
					while( $row=mysqli_fetch_array($query) ) {  // preparing an array
						$nestedData=array(); 
						$datos = $json->encode($row);
						

						$nestedData[] = $row["idnivel"];
						$nestedData[] = ucfirst($row["nombre"]);
					    $nestedData[] = "<td><center>
					                     	<a onclick='editarNiv(".$datos.");' data-toggle='tooltip' title='Editar'> <i class='fas fa-pencil-alt'></i></a>
									     </center></td>";
						$data[] = $nestedData;
					    
					}
					$resp = array(
								"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
								"recordsTotal"    => intval( $totalData ),  // total number of records
								"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
								"data"            => $data   // total data array
								);


				break;
			case 'usuariosreg'://funciona
					$requestData= $_REQUEST;
					$columns = array( 
					// datatable column index  => database column name
						0 => 'idusuario',
					    1 => 'loginusu', 
						2 => 'nombreusu',
						3 => 'apeusu',
						4 => 'nivel',
						5 => 'fechaalta',
						6 => 'emailusu'
					);

					$sql = "SELECT *, DATE_FORMAT(fechaalta, '%d-%m-%Y') as fa ";
					$sql.=" FROM usuario WHERE status = '1'";
					$query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get InventoryItems");
					$totalData = mysqli_num_rows($query);
					$totalFiltered = $totalData;  //


					if( !empty($requestData['search']['value']) ) {
						// if there is a search parameter
						$sql = "SELECT *, DATE_FORMAT(fechaalta, '%d-%m-%Y') as fa ";
						$sql.=" FROM usuario";
						$sql.=" WHERE nombreusu LIKE '".$requestData['search']['value']."%' ";    
						$sql.=" OR apeusu LIKE '".$requestData['search']['value']."%' ";
						$sql.=" OR loginusu LIKE '".$requestData['search']['value']."%' ";
						$sql.=" OR emailusu LIKE '".$requestData['search']['value']."%' ";
						$sql.= "AND status = '1'";
						$query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get PO");
						$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

						$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
						$query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get PO"); // again run query with limit
						
					} else {	

						$sql = "SELECT *, DATE_FORMAT(fechaalta, '%d-%m-%Y') as fa ";
						$sql.=" FROM usuario WHERE status = '1'";
						$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
						$query=mysqli_query($con, $sql) or die("ajax-grid-data.php: get PO");
						
					}
					$json = new Services_JSON();
					$data = array();
					while( $row=mysqli_fetch_array($query) ) {  // preparing an array
						$nestedData=array(); 
						$datos = $json->encode($row);
						if($row["nivel"] == 1){
							$nivel = "Administrador";
						}else{
							$nivel = "Usuario";
						}

						$nestedData[] = $row["idusuario"];
						$nestedData[] = $row["loginusu"];
						$nestedData[] = ucfirst($row["nombreusu"]);
						$nestedData[] = ucfirst($row["apeusu"]);
						$nestedData[] = strtolower($row["emailusu"]);
						$nestedData[] = $nivel;

					    $nestedData[] = $row['fa'];
					    $nestedData[] = "<td><center>
					                     	<a onclick='editar(".$datos.");' data-toggle='tooltip' title='Editar'> <i class='fas fa-pencil-alt'></i></a> | 
 											<a onclick='eliminarusu(".$row["idusuario"].")' data-toggle='tooltip' title='Eliminar'> <i class='fas fa-trash-alt'></i> </a>
									     </center></td>";
						$data[] = $nestedData;
					    
					}
					$resp = array(
								"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
								"recordsTotal"    => intval( $totalData ),  // total number of records
								"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
								"data"            => $data   // total data array
								);


				break;
			
			
			default:
				# code...
				break;
			case 'cambpass':
				if (isset($_REQUEST['clavenue']) && $_REQUEST['clavenue']) {
					if (isset($_REQUEST['claveconf']) && $_REQUEST['claveconf']){
						if (strcmp($_REQUEST['clavenue'],$_REQUEST['claveconf']) == 0) {
							$sql = "SELECT * FROM usuario WHERE idusuario='".$_SESSION['idusu']."'";
							if($res = $objReg->buscarRow($sql,$con)){
								$row = $res->fetch_array();
								if($objReg->descla($_REQUEST['claveact'],$row['clavusuario'])){
									$clanueva = $objReg->comclav($_REQUEST['clavenue'],8);
									$sql = "UPDATE usuario SET clavusuario = '".$clanueva."' WHERE idusuario='".$_SESSION['idusu']."'";
									if($objReg->actualizarclave($sql,$con)){
										$resp = 6;
									}else{
										$resp = 5;
									}
								}else{
									$resp = 4;//clave errada
								}
							}else{
								$resp = 3;
							}
						}else{	
							$resp = 2;//las claves no coinciden
						}
					}else{
						$resp = 1;
					}
				}else{
					$resp = 0;
				}
				break;
		}
		
	}else{
		$resp = "Opcion desconocida";
	}
	$json = new Services_JSON();
    $res = $json->encode($resp);
    
    echo html_entity_decode($res,ENT_QUOTES,'UTF-8');