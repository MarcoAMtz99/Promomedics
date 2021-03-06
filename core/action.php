<?php

include 'conex.php';

$action = $_POST['action'];
$data = json_decode($_POST['data']);

include 'Session.class.php';
include 'Log.class.php';
//$dataString = $_POST['data'];
//$log = new LogClass($user,$idSesion);

switch ($action) {
	case 'login':
		$user = $data->user;
		$pass1 = $data->pass;
		
		$pass = strrev(md5(sha1(trim($pass1))));

		$SQL = "SELECT id_user, fk_perfil, nombre/*CONCAT(nombre,' ',apellidos),*/ AS username, fk_medico, 
						IFNULL((SELECT CONCAT(nombre,' ',paterno,' ',materno) FROM medico WHERE ID = fk_medico),'') AS medico, status, 
						(SELECT fk_grupo FROM medico WHERE ID = fk_medico) AS grupo
					FROM seg_user 
						WHERE (username = '$user' OR email = '$user') AND password = '$pass' AND status != 2; ";
		$res = mysql_query($SQL);

		if (mysql_num_rows($res) == 0) {
			$arrRes = array('error' => true, 'sql' => $SQL);
		}else{
			$info = mysql_fetch_assoc($res);
			$idUser = $info['id_user'];
            $userName = $info['username'];
            $perfil = intval($info['fk_perfil']);
            
            //$sucursal = intval($info['fk_sucursal']);
            $_SESSION['medico'] = $info['fk_medico'];
            $_SESSION['mediconom'] = $info['medico'];

            $_SESSION['user'] = $idUser;
            $_SESSION['perfil'] = $perfil;
            $_SESSION['nomuser'] = $userName;
            $_SESSION['status'] = $info['status'];
            $_SESSION['grupo'] = $info['grupo'];


            $ses = new Session($idUser);
            $idSesion = $ses->getSesion();
            $_SESSION['logID'] = $idSesion;

            $perm = $ses->getPermission($perfil);
            $_SESSION['perm'] = $perm;

            $ses->updateUser();

            $log = new Log($idUser,$idSesion);
            $detalle = $ses->getDetail();
            $log->setDatos('Login: '.$detalle,$detalle,$idUser,USUARIOS);
            $log->saveLog();

			$_SESSION['last'] = time();

			$arrRes = array('error' => false);
		}
		echo json_encode($arrRes);
		break;

	case 'recovery':
		$mail = $_POST['mail'];
		$newPass = randomString(8);
		$newPassBD = strrev(md5(sha1(trim($newPass))));

		$SQL = "SELECT id_user, email, nombre FROM seg_user WHERE email = '$mail' AND status != 2; ";
		$res = mysql_query($SQL);

		if (mysql_num_rows($res) > 0) {
			$infoUser = mysql_fetch_assoc( $res );

			$SQL = "UPDATE seg_user SET password = '$newPassBD' WHERE id_user = '".$infoUser['id_user']."';";
			$res = mysql_query($SQL);

			$disc = "<br><br><br>-------------------------------------<br>";
			$disc .="<small>Este correo fue enviado desde una cuenta no monitoreada. Por favor no respondas este correo.</small>";
			$to = $infoUser['email'];
			$subject = "Recuperaci??n de Contrase??a";
			$body = "Hola ".$infoUser['nombre']."<br><br>Tu contrase??a provisional es <strong>$newPass</strong> <br>Puedes cambiarla en cuanto inicies sesi??n en ".URL_ROOT."<br><br>--<br>".PAGE_TITLE;
			$body = $body.$disc;
            $header  = 'MIME-Version: 1.0' . "\r\n";
            $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: ".PAGE_TITLE." <notifica@promomedics.com.mx>\r\n";
			$resultMail = mail($to, $subject, $body, $header);
			$arrRes = array('error' => false, 'msg' => 'Te enviamos una nueva contrase??a a tu correo. Si no encuentras el mensaje, verifica tu bandeja de correo no deseado o spam.');
		}else{
			$arrRes = array('error' => true, 'msg' => 'No encontramos al usuario con el email ingresado');
		}
		echo json_encode($arrRes);
		break;
	
	case 'getCPInfo':
        $cp = $_POST['cp'];
        $SQL = "SELECT CONCAT(d_tipo_asenta,' ',d_asenta) AS colonia, D_mnpio, d_estado FROM cat_cp WHERE d_codigo = '$cp'; ";
        $res = mysql_query($SQL);

        $colonias = array();    $muni = '';     $edo = '';
        while ($info = mysql_fetch_assoc($res)) {
            $colonias[] = array('colonia' => utf8_encode($info['colonia']));
            if($muni == ''){
                $muni = utf8_encode($info['D_mnpio']);
                $edo = utf8_encode($info['d_estado']);
            }
        }
        echo json_encode(array('colonias' => $colonias, 'municipio' => $muni, 'estado' => $edo));
        break;

    case 'editPass':
        $idUser = $_SESSION['user'];
        $actual = $_POST['act'];
        $nueva = $_POST['pass'];

        $actual = strrev(md5(sha1(trim($actual))));
        $SQL = "SELECT * FROM seg_user WHERE id_user = $idUser AND password = '$actual'; ";
        $res = mysql_query($SQL);

        if(mysql_num_rows($res) == 1){
            $nueva = strrev(md5(sha1(trim($nueva))));

            $SQL = "UPDATE seg_user SET password = '$nueva' WHERE id_user = $idUser ";
            mysql_query($SQL);

            $log = new Log($idUser,$_SESSION['logID']);
            $detalle = 'Modifica Contrase??a';
            $log->setDatos($detalle,$detalle,$idUser,USUARIOS);
            $log->saveLog();
            $arrRes = array('error' => false);
        }else{
            $arrRes = array('error' => true, 'elem' => 'pass-act', 'msg' => 'La contrase??a actual no coincide');
        }
        echo json_encode($arrRes);
        break;


    default:
		# code...
		break;
}

function randomString($tam=8){
	$source = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	if($tam>0){
		$rstr = "";
		$source = str_split($source,1);
		for($i=1; $i<=$tam; $i++){
			mt_srand((double)microtime() * 1000000);
			$num = mt_rand(1,count($source));
			$rstr .= $source[$num-1];
		}
 
	}
	return $rstr;
}


?>