<?php

	class Proceso{
		private $_numproceso;
		private $_descrip;
		private $_fecalta;
		private $_sede;
		private $_presupuesto;

		public function __construct(){
            $this->_numproceso = "";
            $this->_descrip = "";
            $this->_fecalta = date("Y-m-d H:i:s"); 
            $this->_sede = "";
            $this->_presupuesto = "";  
        }

        public function setPropiedades($numproceso,$descrip,$fecalta,$sede,$presupuesto){
            $this->_numproceso = $numproceso;
            $this->_descrip = strtolower($descrip);
            $this->_fecalta = $fecalta;
            $this->_sede = $sede;
            $this->_presupuesto = $presupuesto;
        }

        public function guardarProceso($datos,$con){

        	$resp = $this->buscarCodProceso($datos['txtnum'],$con);
        	if($resp == 2){
        		$presu = str_replace('.','',$datos['txtpresupuesto']);
	        	$presu = str_replace(',','.',$presu);
	        	$date = new DateTime($datos['txtfecha']);
				$hoy = $date->format('Y-m-d');
	        	$this->setPropiedades($datos['txtnum'],$datos['txtdescrip'],$hoy,$datos['selsede'],$presu);
	        	$sql = "INSERT INTO proceso (numproces, descrip, fecalta, sede, presupuesto) VALUES ('$this->_numproceso','$this->_descrip','$this->_fecalta','$this->_sede',$this->_presupuesto)";
	            if($resp = $con->query($sql)){
	                return 1;
	            }else{
	                return 2;
	            }
        	}
        	
        }

        public function editarProceso($datos,$con){
        	$resp = 2;
        	if($datos['numproc'] != $datos['txtnum']){
        		$resp = $this->buscarCodProceso($datos['txtnum'],$con);
        	}


        	if($resp == 2){

        		$sql = "UPDATE proceso SET numproces='".$_REQUEST['txtnum']."', descrip='".strtolower($_REQUEST['txtdescrip'])."', fecalta='".$_REQUEST['txtfecha']."', sede='".$_REQUEST['selsede']."', presupuesto='".$_REQUEST['txtpresupuesto']."'   WHERE idproces = '".$_REQUEST['idproceso']."'";
                print_r($sql);die();
        		if($con->query($sql)){
	                return 1;
	            }else{
	                return 0;
	            }

        	}else{
        		return 3;
        	}
        }

        public function buscarCodProceso($dato,$con){
        	$sql = "SELECT * FROM proceso WHERE numproces = ".$dato;

        	if($resp = $con->query($sql)){
                if($resp->num_rows > 0){
                     return 5;  
                }else{
                    return 2;
                }
            }else{
                return 0;
            }
        }
	}