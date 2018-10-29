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
					
			default:
				# code...
				break;
		}
		
	}else{
		$resp = "Opcion desconocida";
	}
	$json = new Services_JSON();
    $res = $json->encode($resp);
    
    echo html_entity_decode($res,ENT_QUOTES,'UTF-8');