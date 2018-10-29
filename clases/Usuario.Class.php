<?php
    require_once ("PHPMailer/src/PHPMailer.php");
    require_once ("PHPMailer/src/SMTP.php");
    class Usuario
    {
        private $_nombreusu;
        private $_apeusu;
        private $_loginusu;
        private $_claveusu;
        private $_status;
        private $_fechaalta;


        public function __construct(){
            $this->_nombreusu = "";
            $this->_apeusu = "";
            $this->_loginusu = "";
            $this->_claveusu = "";
            $this->_status = "";
            $this->_fechaalta = date("Y-m-d H:i:s");    
        }

        public function setPropiedades($nombreusu, $apeusu, $loginusu, $claveusu){
            $this->_nombreusu = mb_strtolower($nombreusu);
            $this->_apeusu = mb_strtolower($apeusu);
            $this->_loginusu = mb_strtolower($loginusu);
            $this->_claveusu = $claveusu;
        }

        public function valLogin($login,$con,$clave){
            $sql = "SELECT * FROM usuario WHERE loginusu='".strtolower($login)."'";
            if($resp = $con->query($sql)){
                if($resp->num_rows > 0){
                    $row = $resp->fetch_array(MYSQLI_ASSOC);
                    if($row['status'] == 1){
                        if($this->descla($clave,$row['claveusu'])){
                            $_SESSION['cuenta'] = ucwords(strtolower($row['nombreusu']." ".$row['apeusu']));
                            $_SESSION['login'] = $row['loginusu'];
                            $_SESSION['idusu'] = $row['idusuario'];
                            return 4;
                        }else{
                            return 3;
                        }
                    }else{
                        return 2;
                    }
                }else{
                    return 1;
                }
            }else{
                return 0;
            }
        }

        public function comclav($pas,$num){
            $patron = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            $selt = sprintf('$2a$%02d$', $num);
            for($i = 0; $i < 22; $i++){
                $selt .= $patron[ rand(0, strlen($patron)-1) ];
            }
            return crypt($pas, $selt);
        }
        
        public function descla($clavenormal,$clavecifrada){
            if(crypt($clavenormal, $clavecifrada) == $clavecifrada){
                return TRUE;
            }else{
                return FALSE;
            }
        }

        public function buscarUsu($login,$con,$tip = 1){
            $sql = "SELECT * FROM usuario WHERE loginusu='".strtolower($login)."'";
            if($resp = $con->query($sql)){
                if($resp->num_rows > 0){
                    if($tip == 1){
                        return 2;    
                    }else{
                        return $resp;
                    }
                }else{
                    return 1;
                }
            }else{
                return 0;
            }
        }

        public function ingresar($datos,$con){
            //print_r($datos);die();
            $cla = $this->comclav($_REQUEST['txtpass'],8);
            $this->setPropiedades($_REQUEST['txtnombre'], $_REQUEST['txtape'], $_REQUEST['txtemail'], $cla);
            $sql = "INSERT INTO usuario (nombreusu, apeusu, loginusu, claveusu, status, fechaalta) VALUES 
                ('$this->_nombreusu','$this->_apeusu','$this->_loginusu','$this->_claveusu',1,'$this->_fechaalta')";
            if($resp = $con->query($sql)){
                return 1;
            }else{
                return 3;
            }

        }

        public function editar($datos,$con){ 
            
            $sql = "UPDATE usuario SET nombreusu='".mb_strtolower($_REQUEST['txtnombre'])."', apeusu='".mb_strtolower($_REQUEST['txtape'])."', status='".$_REQUEST['statususu']."' WHERE idusuario = '".$_REQUEST['idusumod']."'";
            if($con->query($sql)){
                return 1;
            }else{
                return 0;
            }
        }

        public function desactivar($datos,$con){

            $sql = "UPDATE usuario SET status = 0 WHERE idusuario = '".$datos['idusu']."'";
            if($con->query($sql)){
                return 1;
            }else{
                return 0;
            }
        }

        public function insertresetpas($con,$idusu,$nomusu,$toke){
            $sql = "INSERT INTO resetpass (idusuario,nomusuario,tokein,fechain) VALUES ('".$idusu."','".$nomusu."','".$toke."','".date("Y-m-d H:i:s")."')";
            if($con->query($sql)){
                return 1;
            }else{
                return 0;
            }
        }

        public function solResetPass($datos,$con){
            $resp = $this->buscarUsu($datos['emailusu'],$con,2);
            if(is_object($resp)){
                //print_r($resp);die();
                $row = $resp->fetch_array(MYSQLI_ASSOC);
                $hasreset = md5($row['idusuario'].$row['loginusu'].time());
                $nombre = $row['nombreusu']." ".$row['apeusu'];
                $email = $row['loginusu'];
                $idusu = $row['idusuario'];

                if($this->insertresetpas($con,$idusu,$nombre,$hasreset)){
                    if($this->sendmailreset($hasreset,$nombre,$email,$idusu)){
                        $resp = 2;
                    }else{
                        $resp = 4;
                    }
                }else{
                    $resp = 3;
                }
            }
            return $resp;


        }

        public function sendmailreset($hash,$nombre,$email,$idusu){        

            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                //Server settings
                $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                $mail->IsSMTP();                                      // Set mailer to use SMTP
                
                $mail->Host = 'smtp.mailgun.org';                     // Specify main 
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                               // SMTP username
                $mail->Username = 'postmaster@sandboxe9d11e0ec1dd40f0a26dca8819b49ac2.mailgun.org';                 // SMTP 
                                          // SMTP password
                $mail->Password = '6c22a52764046ef68e39d3325bb8da35';                           // SMTP password
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('ofo04@hotmail.com', 'Oswaldo');
                $mail->addAddress($email, $nombre);     // Add a recipient


                //Content
                if(isset($_SERVER['HTTPS'])){
                    $serv = "https://";
                }else{
                    $serv = "http://";
                }
                $link = $serv.$_SERVER["SERVER_NAME"].':8080/prueba/restablecer.php?idusuario='.sha1($idusu).'&token='.$hash;
                /*remoto*/
                /*fin remoto*/
                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = 'Recuperar contraseña';

                $mensaje = '<html>
                             <head>
                                <title>Restablece tu contraseña</title>
                             </head>
                             <body>
                               <p>Hola, <b>'.ucfirst(strtolower($nombre)).', hemos recibido una petición para restablecer la contraseña de tu cuenta!.</p>
                               <p>Si hiciste esta petición, haz clic en el siguiente enlace, si no hiciste esta petición puedes ignorar este correo.</p>
                               <p>
                                 <strong>Enlace para restablecer tu contraseña</strong><br>
                                 <a href="'.$link.'"> Restablecer contraseña </a>
                               </p>
                               <p>Si necesitas ayuda, ponte en contacto con nosotros</p>
                               <p>Atentamente,</p>
                             </body>
                            </html>';

                $mail->Body    = $mensaje;
                $mail->send();
                return 1;

            } catch (Exception $e) {
                // echo 'Message could not be sent.';
                // echo 'Mailer Error: ' . $mail->ErrorInfo;
                return 0;
            }
        }

        public function verificardatos($datos, $con){
            $sql = "SELECT * FROM resetpass WHERE tokein = '".$datos['token']."'";
            if($res = $con->query($sql)){
                if($res->num_rows > 0){
                    $row = $res->fetch_array(MYSQLI_ASSOC);
                    if(sha1($row['idusuario']) == $datos['idusuario']){
                        return 2;
                    }else{
                        return 3;
                    }
                }else{
                    return 1;
                }
            }else{
                return 0;
            }
        }

        public function cambiarclave($datos,$con){
            
            if($datos['cla1'] == $datos['cla2']){
                $sql = "SELECT * FROM resetpass WHERE tokein = '".$datos['token']."'";
                if($res = $con->query($sql)){
                    if($res->num_rows > 0){
                        $row = $res->fetch_array(MYSQLI_ASSOC);
                        if(sha1($row['idusuario']) == $datos['usuario']){
                            $cla = $this->comclav($datos['cla1'],8);
                            $sql = "UPDATE usuario SET claveusu = '".$cla."' WHERE idusuario = '".$row['idusuario']."'";
                            if($con->query($sql)){
                                $sql = "DELETE FROM resetpass WHERE tokein = '".$datos['token']."'";
                                $con->query($sql);
                                return 5;
                            }else{
                                return 4;
                            }
                        }else{
                            return 3;
                        }
                    }else{
                        return 1;
                    }
                }else{
                    return 0;
                }
            }else{
                return 6;
            }
        }

////////////////////////////////////
        public function ingresarUsu($con){
            $sql = "INSERT INTO usuario (nombreusu, apeusu, loginusu, claveusu, status, nivel, fechaalta, emailusu) VALUES 
                ('$this->_nombreusu','$this->_apeusu','$this->_loginusu','$this->_claveusu',1,'$this->_nivel','$this->_fechaalta','$this->_emailusu')";
//            print_r($sql);            exit();
            if($resp = $con->query($sql)){
                return $con->insert_id;
            }else{
                return 0;
            }
        }

        public function buscar($sql, $con){
            /*print_r($sql); die();*/
            if($resp = $con->query($sql)){
                return $resp->num_rows;
            }
        }

        public function buscarRow($sql, $con){
            /*print_r($sql); die();*/
            return $con->query($sql);
        }

       

        // public function editar($sql,$con){
        //     return $con->query($sql);
        // }

        

        

       

        
    }