<?php

include 'conex.php';

$user = $_SESSION['user'];
$usertype = $_SESSION['perfil'];
$idSesion = $_SESSION['logID'];
$aperm = $_SESSION['perm'];

if(!$user){
	echo "Acceso restringido. You shall not pass..";
	exit(0);
}
if($usertype > 2){
	if(!array_key_exists(MOD_MEDICO, $aperm)){
		echo "Acceso restringido. You shall not pass..";
		exit(0);
	}
	/*if(($usertype == 3 || $usertype == 4) && $med != $_SESSION['medico']){
		echo "Acceso restringido. You shall not pass..";
		exit(0);
	}else{*/
	  $perm = $aperm[MOD_MEDICO];
	  $edita = false;
	  if($perm['action'] == 'EDIT') $edita = true;
	//}
}else{
	if(!array_key_exists(MOD_MEDICOS, $aperm)){
		echo "Acceso restringido. You shall not pass..";
		exit(0);
	}else{
	  $perm = $aperm[MOD_MEDICOS];
	  $edita = false;
	  if($perm['action'] == 'EDIT') $edita = true;
	}
}

/*if(!$user || !array_key_exists(MOD_MEDICOS, $aperm)){
	echo "Acceso restringido. You shall not pass..";
	exit(0);
}else{
	$perm = $aperm[MOD_MEDICOS];
	$edita = false;
	if($perm['action'] == 'EDIT') $edita = true;
	
}*/
	$action = $_GET['action'];
	$dataString = $_POST['data'];
	$data = json_decode($dataString);

	include 'Log.class.php';
	$log = new Log($user,$idSesion);

$arrCurri = array( array('tbl' => 'medico_uni', 'btn' => 'btncu', 'log' => 'Uni'), 
				array('tbl' => 'medico_cer_con', 'btn' => 'btncc', 'log' => 'Cert'), 
				array('tbl' => 'medico_mie_aso', 'btn' => 'btncm', 'log' => 'Cons'), 
				array('tbl' => 'medico_cur_sim', 'btn' => 'btncs', 'log' => 'Curs'), 
				array('tbl' => 'medico_dat_esp', 'btn' => 'btncd', 'log' => 'Esp') 
			);

switch ($action) {
	/** MEDICOS **/
	case 'getMedicos':
		//IFNULL((SELECT especialidad FROM medico_especialidad WHERE id_medico = m.ID),'') AS especialidad
		$SQL = "SELECT ID, CONCAT(m.nombre, ' ', m.paterno, ' ', m.materno) AS nombre, num_cedula, 
					id_user, email, DATE_FORMAT(last_access,'%d/%m/%Y %H:%i:%s') AS acceso, fk_perfil, u.status, 
					IFNULL((SELECT descripcion FROM pre_especialidad WHERE ID = (SELECT id_especialidad FROM medico_especialidad WHERE id_medico = m.ID LIMIT 1)),'') AS especialidad
					FROM medico m, seg_user u
						WHERE u.id_user = (SELECT id_user FROM seg_user WHERE fk_medico = ID ORDER BY id_user LIMIT 1) AND (SELECT COUNT(*) FROM seg_user WHERE fk_medico = ID) > 0 
						ORDER BY m.nombre, m.paterno, m.materno; ";
		$res = mysqli_query($conn, $SQL);

		$arrItems = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$item['especialidad'] = utf8_encode($item['especialidad']);
			$item['act'] = '';
			$item['rea'] = '';
			$item['neg'] = '';
			if($item['fk_perfil'] == 3 && $edita && $item['status'] == 3){
				$item['act'] = '<button class="btn btn-success btn-xs btn-act" data-toggle="tooltip" title="Activar"><i class="fa fa-check fa-fw"></i></button>';	
				$item['rea'] = '<button class="btn btn-info btn-xs btn-rea" data-toggle="tooltip" title="Reactivar"><i class="fa fa-refresh fa-fw"></i></button>';
				$item['neg'] = '<button class="btn btn-danger btn-xs btn-neg" data-toggle="tooltip" title="Negar"><i class="fa fa-ban fa-fw"></i></button>';
			}else if($item['fk_perfil'] == 4 && $edita){
				$item['neg'] = '<button class="btn btn-danger btn-xs btn-neg" data-toggle="tooltip" title="Negar"><i class="fa fa-ban fa-fw"></i></button>';
			}else if($item['status'] == 4){
				$item['rea'] = '<button class="btn btn-info btn-xs btn-rea" data-toggle="tooltip" title="Reactivar"><i class="fa fa-refresh fa-fw"></i></button>';
			}
			$arrItems[] = $item;
		}

		$acciones = '';
		if($edita){
			$acciones = '<button class="btn btn-primary btn-xs btn-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil fa-fw"></i></button> ';
			//$acciones .= '<button class="btn btn-danger btn-xs btn-neg" data-toggle="tooltip" title="Negar"><i class="fa fa-ban fa-fw"></i></button>';
			$acciones .= '<button class="btn btn-danger btn-xs btn-del" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash fa-fw"></i></button>';
		}
		
		$arrRes = array('error' => false, 'items' => $arrItems, 'actions' => $acciones);
		echo json_encode($arrRes);
		break;

	case 'getMedico':
			$id = $_POST['id'];

			$SQL = "SELECT ID, m.nombre, m.paterno, m.materno, num_cedula, 
					id_user, email, fk_medico
					FROM medico m, seg_user u
						WHERE u.id_user = $id AND m.ID = u.fk_medico; ";
			$res = mysqli_query($conn, $SQL);

			$item = mysqli_fetch_assoc($res);
			
			$arrRes = array('error' => false, 'item' => $item);	
		echo json_encode($arrRes);
		break;

	case 'addMedico':
		if($edita){

			$SQL = "SELECT * FROM medico WHERE num_cedula = '$data->ced' AND status = 1; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_num_rows($res) > 0){
				$arrRes = array('error' => true, 'elem' => 'item-ced', 'msg' => 'Cédula ya registrada');
			}else{
				$SQL = "SELECT * FROM seg_user WHERE email = '$data->mail' AND (status = 1 OR  status = 3 OR status = 4 OR status = 5); ";
				$res = mysqli_query($conn, $SQL);

				if(mysqli_num_rows($res) > 0){
					$arrRes = array('error' => true, 'elem' => 'item-mail', 'msg' => 'Email ya registrado');
				}else{

					$SQLm = "INSERT INTO medico (tipoMedico, nombre, paterno, materno, num_cedula, status) 
									VALUES('AF', '$data->nom', '$data->ape', '$data->mat', '$data->ced', '1')";
					$resm = mysqli_query($conn, $SQLm);

					$med = mysqli_insert_id($conn);
					$pass = randomString(8);

					$passBD = strrev(md5(sha1($pass)));
					$SQL = "INSERT INTO seg_user VALUES (NULL, 3, $med, '$data->nom', '$data->ape $data->mat', '$data->mail', '$passBD', '$data->mail', '', NOW(), NOW(), '', 3); ";
					$res = mysqli_query($conn, $SQL);

					$id = mysqli_insert_id($conn);

					if($id > 0){
						$detalle = $med.' '.$data->nom.' '.$data->ape;
						$log->setDatos('Alta Medico '.$detalle,$dataString,$med,MEDICOS);
		            	$log->saveLog();

						$detalle = $id.' '.$data->mail;
		            	$log->setDatos('Alta Usuario '.$detalle,$dataString,$id,USUARIOS);
		            	$log->saveLog();

						$item = array('ID' => $med, 'nombre' => $data->nom.' '.$data->ape.' '.$data->mat, 'num_cedula' => $data->ced, 
										'act' => '<button class="btn btn-success btn-xs btn-act" data-toggle="tooltip" title="Activar"><i class="fa fa-check fa-fw"></i></button>', 
										'rea' => '<button class="btn btn-info btn-xs btn-rea" data-toggle="tooltip" title="Reactivar"><i class="fa fa-refresh fa-fw"></i></button>', 
										'id_user' => $id, 'email' => $data->mail, 'acceso' => '--', 'fk_perfil' => 3, 'especialidad' => '');
						$acciones = '<button class="btn btn-primary btn-xs btn-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil fa-fw"></i></button> ';
						$acciones .= '<button class="btn btn-danger btn-xs btn-neg" data-toggle="tooltip" title="Negar"><i class="fa fa-ban fa-fw"></i></button>';
						$acciones .= '<button class="btn btn-danger btn-xs btn-del" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash fa-fw"></i></button>';
						
						$arrRes = array('id' => $id, 'item' => $item, 'actions' => $acciones);



						$disc = "<br><br><br>-------------------------------------<br>";
					    $disc .="<small>Este correo fue enviado desde una cuenta no monitoreada. Por favor no respondas este correo.</small>";
					    $to = $data->mail;
					    $subject = "Bienvenido a Promomedics";
					    $body = "Hola ".$data->nom."<br><br>Bienvenido a Promomedics, por favor llena toda tu informaci&oacute;n correspondiente ingresando a ".URL_ROOT." con tu correo  <br>$email<br>Tu contrase&ntilde;a provisional es <strong>$pass</strong> <br><br>--<br>".PAGE_TITLE;
					    $body = $body.$disc;
					    $header  = 'MIME-Version: 1.0' . "\r\n";
					    $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					    $header .= "From: ".PAGE_TITLE." <notifica@promomedics.com.mx>\r\n";
					    $resultMail = mail($to, $subject, $body, $header);
					}else{
						$arrRes = array('error' => true, 'elem' => 'btnSave', 'msg' => 'No se pudo guardar');
					}
				}
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'btnSave', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editMedico':
		if($edita){
			$SQL = "SELECT * FROM medico WHERE num_cedula = '$data->ced' AND status = 1 AND ID != $data->med; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_num_rows($res) > 0){
				$arrRes = array('error' => true, 'elem' => 'item-ced', 'msg' => 'Cédula ya registrada');
			}else{
				$SQL = "SELECT * FROM seg_user WHERE email = '$data->mail' AND (status = 1 OR  status = 3 OR status = 4 OR status = 5) AND id_user != $data->id; ";
				$res = mysqli_query($conn, $SQL);

				if(mysqli_num_rows($res) > 0){
					$arrRes = array('error' => true, 'elem' => 'item-mail', 'msg' => 'Email ya registrado');
				}else{
					$SQLm = "UPDATE medico SET nombre = '$data->nom', paterno = '$data->ape', materno = '$data->mat', num_cedula = '$data->ced' WHERE ID = $data->med; ";
					$resm = mysqli_query($conn, $SQLm);

					$SQLu = "UPDATE seg_user SET nombre = '$data->nom', apellidos = '$data->ape $data->mat', email = '$data->mail', username = '$data->mail' WHERE id_user = $data->id; ";
					$resu = mysqli_query($conn, $SQLu);

					//if(mysql_affected_rows() > 0){
					if($resm && $resu){
						$detalle = $data->med.' '.$data->nom.' '.$data->ape;
						$log->setDatos('Edita Medico '.$detalle,$dataString,$data->med,MEDICOS);
		            	$log->saveLog();

						$detalle = $data->id.' '.$data->mail;
		            	$log->setDatos('Edita Usuario '.$detalle,$dataString,$data->id,USUARIOS);
		            	$log->saveLog();

						$item = array('ID' => $data->med, 'nombre' => $data->nom.' '.$data->ape.' '.$data->mat, 'num_cedula' => $data->ced, 
										'act' => '<button class="btn btn-success btn-xs btn-act" data-toggle="tooltip" title="Activar"><i class="fa fa-check fa-fw"></i></button>', 
										'rea' => '<button class="btn btn-info btn-xs btn-rea" data-toggle="tooltip" title="Reactivar"><i class="fa fa-refresh fa-fw"></i></button>', 
										'id_user' => $data->id, 'email' => $data->mail, 'acceso' => '--', 'fk_perfil' => 3, 'especialidad' => '');
						$acciones = '<button class="btn btn-primary btn-xs btn-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil fa-fw"></i></button> ';
						$acciones .= '<button class="btn btn-danger btn-xs btn-neg" data-toggle="tooltip" title="Negar"><i class="fa fa-ban fa-fw"></i></button>';
						$acciones .= '<button class="btn btn-danger btn-xs btn-del" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash fa-fw"></i></button>';
						
						$arrRes = array('error' => false, 'id' => $data->id, 'item' => $item, 'actions' => $acciones);

						/*$disc = "<br><br><br>-------------------------------------<br>";
					    $disc .="<small>Este correo fue enviado desde una cuenta no monitoreada. Por favor no respondas este correo.</small>";
					    $to = $data->mail;
					    $subject = "Bienvenido a Promomedics";
					    $body = "Hola ".$data->nom."<br><br>Bienvenido a Promomedics, por favor llena toda tu informaci&oacute;n correspondiente ingresando a ".URL_ROOT." con tu correo  <br>$email<br>Tu contrase&ntilde;a provisional es <strong>$pass</strong> <br><br>--<br>".PAGE_TITLE;
					    $body = $body.$disc;
					    $header  = 'MIME-Version: 1.0' . "\r\n";
					    $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					    $header .= "From: ".PAGE_TITLE." <notifica@promomedics.com.mx>\r\n";
					    $resultMail = mail($to, $subject, $body, $header);*/
					}else{
						$arrRes = array('error' => true, 'elem' => 'btnSave', 'msg' => 'Ocurrio un error al guardar', 'sql' => $SQLm.$SQLu);
					}
				}
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'btnSave', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'activaMedico':
		if($edita){
			$id = $_POST['id'];

			$SQL = "SELECT * FROM seg_user WHERE id_user = $id; ";
			$info = mysqli_fetch_assoc(mysqli_query($conn, $SQL));
			$mail = $info['email'];

			$pass = randomString(8);
			$passBD = strrev(md5(sha1($pass)));

			$SQLr = "UPDATE seg_user SET status = 1, fk_perfil = 4 WHERE id_user = $id; ";
			mysqli_query($conn, $SQLr);


			$detalle = $id.' '.$mail;
        	$log->setDatos('Activa Usuario Medico '.$detalle,$dataString,$id,USUARIOS);
        	$log->saveLog();

        	$arrRes = array('error' => false);

        	/*$disc = "<br><br><br>-------------------------------------<br>";
		    $disc .="<small>Este correo fue enviado desde una cuenta no monitoreada. Por favor no respondas este correo.</small>";
		    $to = $info['email'];
		    $subject = "Bienvenido a Promomedics";
		    $body = "Hola ".$info['nombre']."<br><br>Bienvenido a Promomedics, por favor llena toda tu informaci&oacute;n correspondiente ingresando a ".URL_ROOT." con tu correo  <br>".$info['email']."<br>Tu contrase&ntilde;a provisional es <strong>$pass</strong> <br><br>--<br>".PAGE_TITLE;
		    $body = $body.$disc;
		    $header  = 'MIME-Version: 1.0' . "\r\n";
		    $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		    $header .= "From: ".PAGE_TITLE." <notifica@promomedics.com.mx>\r\n";
		    $resultMail = mail($to, $subject, $body, $header);*/
		}else{
			$arrRes = array('error' => true, 'elem' => 'btnSave', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'rechazaMedico':
		if($edita){
			$id = $_POST['id'];

			$SQL = "SELECT * FROM seg_user WHERE id_user = $id; ";
			$info = mysqli_fetch_assoc(mysqli_query($conn, $SQL));
			$mail = $info['email'];
			$med = $info['fk_medico'];

			$SQLr = "UPDATE seg_user SET status = 4, fk_perfil = 3 WHERE id_user = $id; ";
			mysqli_query($conn, $SQLr);

			$SQLm = "UPDATE medico SET status = 4 WHERE ID = $med; ";
			mysqli_query($conn, $SQLm);


			$detalle = $id.' '.$mail;
        	$log->setDatos('Medico No Autorizado '.$detalle,$dataString,$id,USUARIOS);
        	$log->saveLog();

        	$arrRes = array('error' => false, 'rea' => '<button class="btn btn-info btn-xs btn-rea" data-toggle="tooltip" title="Reactivar"><i class="fa fa-refresh fa-fw"></i></button>');
		}else{
			$arrRes = array('error' => true, 'elem' => 'btnSave', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'reactivaMedico':
		if($edita){
			$id = $_POST['id'];

			$SQL = "SELECT * FROM seg_user WHERE id_user = $id; ";
			$info = mysqli_fetch_assoc(mysqli_query($conn, $SQL));
			$mail = $info['email'];

			$pass = randomString(8);
			$passBD = strrev(md5(sha1($pass)));

			$SQLr = "UPDATE seg_user SET status = 3, password = '$passBD' WHERE id_user = $id; ";
			mysqli_query($SQLr);


			$detalle = $id.' '.$mail;
        	$log->setDatos('Reactiva Usuario Medico '.$detalle,$dataString,$id,USUARIOS);
        	$log->saveLog();

        	$disc = "<br><br><br>-------------------------------------<br>";
		    $disc .="<small>Este correo fue enviado desde una cuenta no monitoreada. Por favor no respondas este correo.</small>";
		    $to = $info['email'];
		    $subject = "Bienvenido a Promomedics";
		    $body = "Hola ".$info['nombre']."<br><br>Bienvenido a Promomedics, por favor llena toda tu informaci&oacute;n correspondiente ingresando a ".URL_ROOT." con tu correo  <br>".$info['email']."<br>Tu contrase&ntilde;a provisional es <strong>$pass</strong> <br><br>--<br>".PAGE_TITLE;
		    $body = $body.$disc;
		    $header  = 'MIME-Version: 1.0' . "\r\n";
		    $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		    $header .= "From: ".PAGE_TITLE." <notifica@promomedics.com.mx>\r\n";
		    $resultMail = mail($to, $subject, $body, $header);

		    $arrRes = array('error' => false, 'act' => '<button class="btn btn-success btn-xs btn-act" data-toggle="tooltip" title="Activar"><i class="fa fa-check fa-fw"></i></button>', 'neg' => '<button class="btn btn-danger btn-xs btn-neg" data-toggle="tooltip" title="Negar"><i class="fa fa-ban fa-fw"></i></button>');
		}else{
			$arrRes = array('error' => true, 'elem' => 'btnSave', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delMedico':
		if($edita){
			$id = $_POST['id'];

			$SQL = "UPDATE seg_user SET status = 2, deleted = NOW() WHERE id_user = $id; ";
			$res = mysqli_query($conn, $SQL);

			$SQL = "UPDATE medico SET status = 2 WHERE ID = (SELECT fk_medico FROM seg_user WHERE id_user = $id); ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Médico '.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('res' => true);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;



	case 'getSubespecialidad':
		$esp = $_POST['esp'];

		$SQL = "SELECT nombre FROM subespecialidades WHERE id_especialidad = $esp; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$item['nombre'] = utf8_encode($item['nombre']);
			$arr[] = $item;
		}

		echo json_encode($arr);
		break;

	case 'saveGral':
		if($edita){
			$med = $data->med;
			//$idesp = intval($data->idesp);

			$lugar = $data->lnac;
			if($data->nac == 'Mexicana') $lugar = $data->lnace;

			$SQLm = "UPDATE medico SET sexo = '$data->sexo', nacionalidad = '$data->nac', nacimiento_lugar = '$lugar', 
								nacimiento_fecha = '$data->fnac', num_recer = '$data->inst', fecha_recer = '$data->fegre' 
						WHERE ID = $med; ";
			$resm = mysqli_query($conn, $SQLm);

				/*if($idesp == 0){
					$SQLe = "INSERT INTO medico_especialidad VALUES (NULL, $med, $data->esp, '', '$data->nced', '$data->cert', '$data->fvenc', 1, '$data->esps', '$data->subes'); ";
					$rese = mysql_query($SQLe);

					$idesp = mysql_insert_id();
				}else{
					$SQLe = "UPDATE medico_especialidad SET id_especialidad = $data->esp, num_cedula = '$data->nced', 
										num_recer = '$data->cert', fecha_recer = '$data->fvenc', especialidad = '$data->esps', 
										subespecialidad = '$data->subes' 
								WHERE ID = $idesp; ";
					$rese = mysql_query($SQLe);
				}
			if($idesp > 0){*/

				$detalle = $med.' '.$idesp;
				$log->setDatos('Actualiza Médico General '.$detalle,$dataString,$med,MEDICOS);
            	$log->saveLog();

				$arrRes = array('success' => true, 'idesp' => $idesp);	
			/*}else{
				$arrRes = array('success' => false);
			}*/
		}else{
			$arrRes = array('success' => false, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;


	/** ESPECIALIDADES **/
	case 'getEspecialidades':
		$med = $_POST['med'];

		$SQL = "SELECT ID, num_cedula, 
						(SELECT descripcion FROM pre_especialidad e WHERE e.ID = id_especialidad) AS especialidad, 
						(SELECT nombre FROM subespecialidades s WHERE s.ID = id_subespecialidad) AS subespecialidad 
					FROM medico_especialidad WHERE status = 1 AND id_medico = $med; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$item['especialidad'] = utf8_encode($item['especialidad']);
			$item['subespecialidad'] = utf8_encode($item['subespecialidad']);
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btnespe-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btnespe-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'getEspecialidad':
		$id = $_POST['id'];

		$SQL = "SELECT *, 
						(SELECT descripcion FROM pre_especialidad e WHERE e.ID = id_especialidad) AS especialidad, 
						(SELECT nombre FROM subespecialidades s WHERE s.ID = id_subespecialidad) AS subespecialidad 
					FROM medico_especialidad WHERE ID = $id; ";
		$res = mysqli_query($conn, $SQL);

		$item = mysqli_fetch_assoc($res);
		$item['especialidad'] = utf8_encode($item['especialidad']);
		$item['subespecialidad'] = utf8_encode($item['subespecialidad']);
		
		echo json_encode($item);
		break;

	case 'addEspecialidad':
		if($edita){
			$med = $_POST['med'];
			//$nom = $_POST['nom'];
			$esp = intval($data->esp);
			$sub = intval($data->subes);
			if($esp == 0){
				$SQLe = "INSERT INTO pre_especialidad VALUES (NULL, '$data->esps', 1, NOW(), NOW(), $user, $user); ";
				$rese = mysqli_query($conn, $SQLe);

				$esp = mysqli_insert_id($conn);
			}

			if($sub == 0){
				$SQLs = "INSERT INTO subespecialidades VALUES (NULL, $esp, '$data->subess', 1, NOW(), NOW(), $user, $user); ";
				$ress = mysqli_query($conn, $SQLe);

				$sub = mysqli_insert_id($conn);
			}

			$SQL = "INSERT INTO medico_especialidad VALUES (NULL, $med, $esp, $sub, '$data->nced', '$data->cert', '$data->fvenc', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$data->esps;
				$log->setDatos('Alta Especialidad Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'especialidad' => $data->esps, 'subespecialidad' => $data->subess, 'num_cedula' => $data->nced);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btnespe-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnespe-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editEspecialidad':
		if($edita){
			$id = $_POST['id'];

			$esp = intval($data->esp);
			$sub = intval($data->subes);
			if($esp == 0){
				$SQLe = "INSERT INTO pre_especialidad VALUES (NULL, '$data->esps', 1, NOW(), NOW(), $user, $user); ";
				$rese = mysqli_query($conn, $SQLe);

				$esp = mysqli_insert_id($conn);
			}

			if($sub == 0){
				$SQLs = "INSERT INTO subespecialidades VALUES (NULL, $esp, '$data->subess', 1, NOW(), NOW(), $user, $user); ";
				$ress = mysqli_query($conn, $SQLs);

				$sub = mysqli_insert_id($conn);
			}

			$SQL = "UPDATE medico_especialidad SET id_especialidad = $esp, id_subespecialidad = $sub, num_cedula = '$data->nced', num_recer = '$data->cert', fecha_recer = '$data->fvenc' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$data->esps;
				$log->setDatos('Edita Especialidad Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'especialidad' => $data->esps, 'subespecialidad' => $data->subess, 'num_cedula' => $data->nced);
				$actions = '<button type="button" class="btn btn-xs btn-primary btnespe-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnespe-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delEspecialidad':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];

			$SQL = "UPDATE medico_especialidad SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Especialidad Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;


	/** CONSULTORIOS **/
	case 'getConsultorios':
		$med = $_POST['med'];

		$SQL = "SELECT ID, nombre, consultaPrimera, consultaSubsecuente, consultaPreferente FROM consultorio WHERE status = 1 AND id_medico = $med ORDER BY ID; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btncons-edit" title="Ver">Modificar</button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btncons-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'getConsDir':
		$cons = $_POST['cons'];

		$SQL = "SELECT * FROM consultorio WHERE ID = $cons; ";
		$info = mysqli_fetch_assoc(mysqli_query($conn, $SQL));

		$SQLc = "SELECT * FROM codigo_postal WHERE d_codigo = '".$info['codigo_postal']."' ORDER BY d_asenta; ";
		$resc = mysqli_query($conn, $SQLc);

		$arrCol = array();
		while ($col = mysqli_fetch_assoc($resc)) {
			$arrCol[] = utf8_encode($col['d_asenta']);
		}

		echo json_encode(array('info' => $info, 'col' => $arrCol));
		break;

	case 'addConsultorio':
		if($edita){
			$nom = $data->nom;
			$med = $_POST['med'];

			$SQL = "INSERT INTO consultorio VALUES (NULL, $med, '$nom', '$data->edo','$data->calle','$data->ext','$data->int','$data->cp','$data->col', 1, NOW(), NOW(),'$data->ciu','$data->mun','$data->prim','$data->sub','$data->pref', '', ''); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Alta Cons Médico'.$detalle,$dataString,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'nombre' => $nom, 'consultaPrimera' => $data->prim, 'consultaSubsecuente' => $data->sub, 'consultaPreferente' => $data->pref);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btncons-edit" title="Ver">Modificar</button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btncons-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editConsultorio':
		if($edita){
			$id = $_POST['id'];
			$nom = $data->nom;

			$SQL = "UPDATE consultorio SET nombre = '$data->nom', consultaPrimera = '$data->prim', consultaSubsecuente = '$data->sub', consultaPreferente = '$data->pref', calle = '$data->calle', exterior = '$data->ext', interior = '$data->int', codigo_postal = '$data->cp', colonia = '$data->col', ciudad = '$data->ciu', municipio = '$data->mun', estado = '$data->edo' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Edita Cons Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'nombre' => $nom, 'consultaPrimera' => $data->prim, 'consultaSubsecuente' => $data->sub, 'consultaPreferente' => $data->pref);
				$actions = '<button type="button" class="btn btn-xs btn-primary btncons-edit" title="Ver">Modificar</button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btncons-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delConsultorio':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];

			$SQL = "UPDATE consultorio SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Cons Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	/** CONVENIOS **/
	case 'getConvenios':
		$cons = $_POST['cons'];

		$SQL = "SELECT * FROM consultorio_convenios WHERE status = 1 AND id_consultorio = $cons ORDER BY empresa; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btnconv-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btnconv-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'addConvenio':
		if($edita){
			$cons = $_POST['cons'];
			$desc = $_POST['desc'];
			$costo = $_POST['costo'];

			$SQL = "INSERT INTO consultorio_convenios VALUES (NULL, $cons, '$desc', '$costo', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$desc;
				$log->setDatos('Alta Conv Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'empresa' => $desc, 'costo' => $costo);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btnconv-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnconv-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editConvenio':
		if($edita){
			$id = $_POST['id'];
			$desc = $_POST['desc'];
			$costo = $_POST['costo'];

			$SQL = "UPDATE consultorio_convenios SET empresa = '$desc', costo = '$costo' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$desc;
				$log->setDatos('Edita Conv Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'empresa' => $desc, 'costo' => $costo);
				$actions = '<button type="button" class="btn btn-xs btn-primary btnconv-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnconv-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delConvenio':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];

			$SQL = "UPDATE consultorio_convenios SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Conv Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;


	/** SEGURADORAS **/
	case 'getAseguradoras':
		$cons = $_POST['cons'];

		$SQL = "SELECT * FROM consultorio_aseguradoras WHERE status = 1 AND id_consultorio = $cons ORDER BY aseguradora; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btnase-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btnase-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'addAseguradora':
		if($edita){
			$cons = $_POST['cons'];
			$desc = $_POST['desc'];
			$costo = $_POST['costo'];

			$SQL = "INSERT INTO consultorio_aseguradoras VALUES (NULL, $cons, '$desc', '$costo', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$desc;
				$log->setDatos('Alta Ase Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'aseguradora' => $desc, 'costo' => $costo);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btnase-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnase-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editAseguradora':
		if($edita){
			$id = $_POST['id'];
			$desc = $_POST['desc'];
			$costo = $_POST['costo'];

			$SQL = "UPDATE consultorio_aseguradoras SET aseguradora = '$desc', costo = '$costo' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$desc;
				$log->setDatos('Edita Ase Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'aseguradora' => $desc, 'costo' => $costo);
				$actions = '<button type="button" class="btn btn-xs btn-primary btnase-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnase-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delAseguradora':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];

			$SQL = "UPDATE consultorio_aseguradoras SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Ase Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;


	/** HORARIOS **/
	case 'getHorarios':
		$cons = $_POST['cons'];

		/*$SQL = "SELECT * FROM consultorio_h_consulta WHERE id_consultorio = $cons; ";
		$infoc = mysql_fetch_assoc(mysql_query($SQL));

		$SQL = "SELECT * FROM consultorio_h_quirurgico WHERE id_consultorio = $cons; ";
		$infoq = mysql_fetch_assoc(mysql_query($SQL));

		echo json_encode(array('cons' => $infoc, 'quir' => $infoq));*/

		$tipo = $_POST['tipo'];
		$SQL = "SELECT * FROM consultorio_horario WHERE tipo = $tipo AND fk_consultorio = $cons ORDER BY dia, inicio; ";
		$res = mysqli_query($conn, $SQL);

		$items = array();
		while ($hora = mysqli_fetch_assoc($res)) {
			$items[] = array('id' => $hora['id_horario'], 
							'dia' => $hora['dia'], 
							'hora' => substr($hora['inicio'], 0, 5).' - '.substr($hora['fin'], 0, 5));
		}
		echo json_encode(array('items' => $items));
		break;

	case 'saveHorarios':
		if($edita){
			$consu = $_POST['cons'];

			$cons = $data->cons;
			$consid = intval($cons->id);
			$quir = $data->quir;
			$quirid = intval($quir->id);

			if($consid == 0){
				$SQLc = "INSERT INTO consultorio_h_consulta VALUES (NULL, $consu, '$data->tiem','$data->cini','$data->cfin', '$cons->lini','$cons->lfin','$cons->mini','$cons->mfin','$cons->miini','$cons->mifin','$cons->jini','$cons->jfin','$cons->vini','$cons->vfin','$cons->sini','$cons->sfin','$cons->dini','$cons->dfin'); ";
				$resc = mysqli_query($conn, $SQLc);
				$consid = mysqli_insert_id($conn);
			}else{
				$SQLc = "UPDATE consultorio_h_consulta SET tiempo = '$data->tiem', comida = '$data->cini', comida2 = '$data->cfin', 
									lunes_inicio = '$cons->lini', lunes_fin = '$cons->lfin', martes_inicio = '$cons->mini', martes_fin = '$cons->mfin', miercoles_inicio = '$cons->miini', miercoles_fin = '$cons->mifin', jueves_inicio = '$cons->jini', jueves_fin = '$cons->jfin', viernes_inicio = '$cons->vini', viernes_fin = '$cons->vfin', sabado_inicio = '$cons->sini', sabado_fin = '$cons->sfin', domingo_inicio = '$cons->dini', domingo_fin = '$cons->dfin' 
								WHERE ID = $consid; ";
				$resc = mysqli_query($conn, $SQLc);
			}

			if($quirid == 0){
				$SQLq = "INSERT INTO consultorio_h_quirurgico VALUES (NULL, $consu, '$quir->lini','$quir->lfin','$quir->mini','$quir->mfin','$quir->miini','$quir->mifin','$quir->jini','$quir->jfin','$quir->vini','$quir->vfin','$quir->sini','$quir->sfin','$quir->dini','$quir->dfin'); ";
				$resq = mysqli_query($conn, $SQLq);
				$quirid = mysqli_insert_id($conn);
			}else{
				$SQLq = "UPDATE consultorio_h_quirurgico SET 
									lunes_inicio = '$quir->lini', lunes_fin = '$quir->lfin', martes_inicio = '$quir->mini', martes_fin = '$quir->mfin', miercoles_inicio = '$quir->miini', miercoles_fin = '$quir->mifin', jueves_inicio = '$quir->jini', jueves_fin = '$quir->jfin', viernes_inicio = '$quir->vini', viernes_fin = '$quir->vfin', sabado_inicio = '$quir->sini', sabado_fin = '$quir->sfin', domingo_inicio = '$quir->dini', domingo_fin = '$quir->dfin' 
								WHERE ID = $quirid; ";
				$resq = mysqli_query($conn, $SQLq);
			}

			$log->setDatos('Edita Hora Cons Médico'.$consu,$dataString,$id,MEDICOS);
        	$log->saveLog();

			$arrRes = array('error' => false, 'consid' => $consid, 'quirid' => $quirid);
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'saveHorario':
		$cons = $_POST['consu'];
		$tipo = $_POST['tipo'];
		$ini = $_POST['ini'];
		$fin = $_POST['fin'];
		$dias = str_split($_POST['dias']);

		$items = array();
		foreach ($dias as $dia) {
			$SQLc = "SELECT * FROM consultorio_horario WHERE fk_consultorio = $cons AND tipo = $tipo AND dia = $dia AND inicio = '$ini:00' AND fin = '$fin:00' ";
			$resc = mysqli_query($conn, $SQLc);

			if(mysqli_num_rows($resc) == 0){
				$SQL = "INSERT INTO consultorio_horario VALUES (NULL,'$cons','$tipo','$dia','$ini','$fin'); ";
				$res = mysqli_query($conn, $SQL);

				$id = mysqli_insert_id($conn);

				$items[] = array('id' => $id, 'dia' => $dia, 'hora' => $ini.' - '.$fin);
			}

		}

		if(count($items) > 0){
			$arrRes = array('success' => true, 'items' => $items);
		}else{
			$arrRes = array('success' => false, 'sql' => $SQL);
		}
		echo json_encode($arrRes);
		break;

	case 'delHorario':
		$id = $_POST['id'];
		$SQL = "DELETE FROM consultorio_horario WHERE id_horario = $id; ";

		echo json_encode(array('success' => mysqli_query($conn, $SQL)));
		break;


	/** CUBICULOS **/
	case 'getCubiculos':
		$cons = $_POST['cons'];

		$SQL = "SELECT * FROM consultorio_cubiculos WHERE status = 1 AND id_consultorio = $cons; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btncub-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btncub-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions,'query'=>$SQL,'resultado'=>$res));
		break;

	case 'addCubiculo':
		if($edita){
			$cons = $_POST['cons'];
			$nom = $_POST['nom'];
			$med = $_POST['med'];
			$desc = $_POST['desc'];

			$SQL = "INSERT INTO consultorio_cubiculos VALUES (NULL, $cons, '$nom', '$med', 1, '$desc'); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Alta Cub Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'nombre' => $nom, 'medico' => $med, 'caracteristicas' => $desc);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btncub-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btncub-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editCubiculo':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];
			$med = $_POST['med'];
			$desc = $_POST['desc'];

			$SQL = "UPDATE consultorio_cubiculos SET nombre = '$nom', medico = '$med' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows() > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Edita Cub Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'nombre' => $nom, 'medico' => $med, 'caracteristicas' => $desc);
				$actions = '<button type="button" class="btn btn-xs btn-primary btncub-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btncub-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delCubiculo':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];

			$SQL = "UPDATE consultorio_cubiculos SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Cub Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;


	/** MEDIOS DIGITALES **/
	case 'saveDigitales':
		if($edita){
			$cons = $_POST['cons'];
			$giro = $_POST['giro'];
			$slo = $_POST['slo'];

			$SQL = "UPDATE consultorio SET giro = '$giro', slogan = '$slo' WHERE ID = $cons; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $cons;
				$log->setDatos('Guarda Médico Cons Med Dig'.$detalle,$detalle,$cons,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'getDigitales':
		$cons = $_POST['cons'];
		$tipo = $_POST['tipo'];

		$SQL = "SELECT ID, descripcion FROM cons_digitales WHERE status = 1 AND fk_consultorio = $cons AND tipo = $tipo; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btndig-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btndig-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'addDigital':
		if($edita){
			$desc = $_POST['desc'];
			$cons = $_POST['cons'];
			$tipo = $_POST['tipo'];

			$SQL = "INSERT INTO cons_digitales VALUES (NULL, $cons, $tipo, '$desc', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$desc;
				$log->setDatos('Alta Médico Cons Med Dig'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'descripcion' => $desc);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btndig-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btndig-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editDigital':
		if($edita){
			$id = $_POST['id'];
			$desc = $_POST['desc'];

			$SQL = "UPDATE cons_digitales SET descripcion = '$desc' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$desc;
				$log->setDatos('Edita Médico Cons Med Dig'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'descripcion' => $desc);
				$actions = '<button type="button" class="btn btn-xs btn-primary btndig-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btndig-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delDigital':
		if($edita){
			$id = $_POST['id'];
			$tipo = $_POST['tipo'];

			$SQL = "UPDATE cons_digitales SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$tipo;
				$log->setDatos('Baja Médico Cons Med Dig'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;



	/** STAFF MEDICO **/
	case 'getStaffSub':
		$esp = utf8_decode($_POST['esp']);

		$SQL = "SELECT nombre FROM subespecialidades WHERE id_especialidad = (SELECT ID FROM especialidades WHERE nombre = '$esp' LIMIT 1); ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$item['nombre'] = utf8_encode($item['nombre']);
			$arr[] = $item;
		}

		echo json_encode($arr);
		break;

	case 'getStaff':
		$cons = $_POST['cons'];
		$tipo = $_POST['tipo'];

		$tbl = 'consultorio_medicos_participantes';
		if($tipo == '1') $tbl = 'consultorio_staff_quirurgico';

		$SQL = "SELECT ID, CONCAT(nombre, ' ', apellidos) AS nombre, especialidad, email, rol FROM $tbl WHERE status = 1 AND id_consultorio = $cons; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btnstaff-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btnstaff-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'getMedStaff':
		$id = $_POST['id'];
		$tipo = $_POST['tipo'];

		$tbl = 'consultorio_medicos_participantes';
		if($tipo == 'medq') $tbl = 'consultorio_staff_quirurgico';

		$SQL = "SELECT * FROM $tbl WHERE ID = $id; ";
		$info = mysqli_fetch_assoc(mysqli_query($conn, $SQL));

		$esp = utf8_decode($info['especialidad']);
		$SQLs = "SELECT nombre FROM subespecialidades WHERE id_especialidad = (SELECT ID FROM especialidades WHERE nombre = '$esp' LIMIT 1); ";
		$res = mysqli_query($conn, $SQLs);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			/*$item['nombre'] = utf8_encode($item['nombre']);
			$arr[] = $item;*/
			$arr[] = utf8_encode($item['nombre']);
		}

		echo json_encode(array('info' => $info, 'subs' => $arr));
		break;

	case 'addStaff':
		if($edita){
			$cons = $data->cons;
			$tipo = $data->tipo;

			$tbl = 'consultorio_medicos_participantes';
			if($tipo == 'medq') $tbl = 'consultorio_staff_quirurgico';

			$SQL = "INSERT INTO $tbl VALUES (NULL, $cons, '$data->nom', '$data->ape', 1, '$data->esp', '$data->sub', '$data->tel', '$data->mail', '$data->rol'); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$data->nom.' '.$data->tipo;
				$log->setDatos('Alta Médico Cons Staff'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'nombre' => $data->nom.' '.$data->ape, 'especialidad' => $data->esp, 'email' => $data->mail);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btnstaff-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnstaff-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editStaff':
		if($edita){
			$id = $data->id;
			$tipo = $data->tipo;

			$tbl = 'consultorio_medicos_participantes';
			if($tipo == 'medq') $tbl = 'consultorio_staff_quirurgico';

			$SQL = "UPDATE $tbl SET nombre = '$data->nom', apellidos = '$data->ape', especialidad = '$data->esp', subespecialidad = '$data->sub', telefono = '$data->tel', email = '$data->mail', rol = '$data->rol' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$data->nom.' '.$data->tipo;
				$log->setDatos('Edita Médico Cons Staff'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'nombre' => $data->nom.' '.$data->ape, 'especialidad' => $data->esp, 'email' => $data->mail);
				$actions = '<button type="button" class="btn btn-xs btn-primary btnstaff-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnstaff-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delStaff':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];
			$tipo = $_POST['tipo'];

			$tbl = 'consultorio_medicos_participantes';
			if($tipo == 'medq') $tbl = 'consultorio_staff_quirurgico';

			$SQL = "UPDATE $tbl SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom.' '.$tipo;
				$log->setDatos('Baja Médico Cons staff '.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	/** INSTITUCIONES **/
	case 'getInstituciones':
		$med = $_POST['med'];

		$SQL = "SELECT ID, descripcion FROM medico_instituciones WHERE status = 1 AND id_medico = $med; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btne-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btne-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'addInstitucion':
		if($edita){
			$nom = $_POST['nom'];
			$med = $_POST['med'];

			$SQL = "INSERT INTO medico_instituciones VALUES (NULL, $med, '$nom', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Alta Inst Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'descripcion' => $nom);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btne-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btne-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editInstitucion':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];

			$SQL = "UPDATE medico_instituciones SET descripcion = '$nom' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Edita Inst Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'descripcion' => $nom);
				$actions = '<button type="button" class="btn btn-xs btn-primary btne-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btne-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delInstitucion':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];

			$SQL = "UPDATE medico_instituciones SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Inst Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	/** CONTACTOS **/
	case 'getContactos':
		$med = $_POST['med'];

		$SQL = "SELECT * FROM medico_contacto WHERE status = 1 AND id_medico = $med; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btnc-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btnc-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'addContacto':
		if($edita){
			$med = $data->med;

			$SQL = "INSERT INTO medico_contacto VALUES (NULL, $med, '$data->nom', '$data->pat', '$data->mat', '$data->area', '$data->pues', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Alta Cont Médico'.$detalle,$dataString,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'nombre' => $data->nom, 'paterno' => $data->pat, 'materno' => $data->mat, 'area' => $data->area, 'puesto' => $data->pues);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btnc-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnc-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editContacto':
		if($edita){
			$id = $data->id;

			$SQL = "UPDATE medico_contacto SET nombre = '$data->nom', paterno = '$data->pat', materno = '$data->mat', area = '$data->area', puesto = '$data->pues' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Edita Cont Médico'.$detalle,$dataString,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'nombre' => $data->nom, 'paterno' => $data->pat, 'materno' => $data->mat, 'area' => $data->area, 'puesto' => $data->pues);
				$actions = '<button type="button" class="btn btn-xs btn-primary btnc-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnc-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delContacto':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];

			$SQL = "UPDATE medico_contacto SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Cont Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;


	/** CELULAR **/
	case 'getCelulares':
		$med = $_POST['med'];

		$SQL = "SELECT ID, numero FROM medico_celular WHERE status = 1 AND id_contacto = $med; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btncel-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btncel-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'addCelular':
		if($edita){
			$num = $_POST['num'];
			$med = $_POST['med'];

			$SQL = "INSERT INTO medico_celular VALUES (NULL, $med, '$num', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$num;
				$log->setDatos('Alta Cel Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'numero' => $num);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btncel-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btncel-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editCelular':
		if($edita){
			$id = $_POST['id'];
			$num = $_POST['num'];

			$SQL = "UPDATE medico_celular SET numero = '$num' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$num;
				$log->setDatos('Edita Cel Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'numero' => $num);
				$actions = '<button type="button" class="btn btn-xs btn-primary btncel-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btncel-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delCelular':
		if($edita){
			$id = $_POST['id'];
			$num = $_POST['num'];

			$SQL = "UPDATE medico_celular SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$num;
				$log->setDatos('Baja Cel Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;


	/** TELEFONO **/
	case 'getTelefonos':
		$med = $_POST['med'];

		$SQL = "SELECT ID, numero, ext FROM medico_telefono WHERE status = 1 AND id_contacto = $med; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btnt-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btnt-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'addTelefono':
		if($edita){
			$num = $_POST['num'];
			$med = $_POST['med'];
			$ext = $_POST['ext'];

			$SQL = "INSERT INTO medico_telefono VALUES (NULL, $med, '$num', '$ext', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$num;
				$log->setDatos('Alta Tel Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'numero' => $num, 'ext' => $ext);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btnt-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnt-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editTelefono':
		if($edita){
			$id = $_POST['id'];
			$num = $_POST['num'];
			$ext = $_POST['ext'];

			$SQL = "UPDATE medico_telefono SET numero = '$num', ext = '$ext' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$num;
				$log->setDatos('Edita Tel Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'numero' => $num, 'ext' => $ext);
				$actions = '<button type="button" class="btn btn-xs btn-primary btnt-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnt-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delTelefono':
		if($edita){
			$id = $_POST['id'];
			$num = $_POST['num'];

			$SQL = "UPDATE medico_telefono SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$num;
				$log->setDatos('Baja Tel Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;


	/** CORREO **/
	case 'getCorreos':
		$med = $_POST['med'];

		$SQL = "SELECT ID, correo FROM medico_correo WHERE status = 1 AND id_contacto = $med; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btnm-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btnm-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'addCorreo':
		if($edita){
			$mail = $_POST['mail'];
			$med = $_POST['med'];

			$SQL = "INSERT INTO medico_correo VALUES (NULL, $med, '$mail', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$mail;
				$log->setDatos('Alta Mail Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'correo' => $mail);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btnm-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnm-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editCorreo':
		if($edita){
			$id = $_POST['id'];
			$mail = $_POST['mail'];

			$SQL = "UPDATE medico_correo SET correo = '$mail' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$mail;
				$log->setDatos('Edita Mail Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'correo' => $mail);
				$actions = '<button type="button" class="btn btn-xs btn-primary btnm-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnm-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delCorreo':
		if($edita){
			$id = $_POST['id'];
			$mail = $_POST['mail'];

			$SQL = "UPDATE medico_correo SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$mail;
				$log->setDatos('Baja Mail Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;


	/** PAGINA **/
	case 'getPaginas':
		$med = $_POST['med'];

		$SQL = "SELECT ID, pagina, direccion FROM medico_paginas WHERE status = 1 AND id_contacto = $med; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($conn, $res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btnp-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btnp-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'addPagina':
		if($edita){
			$med = $_POST['med'];
			$nom = $_POST['nom'];
			$dir = $_POST['dir'];

			$SQL = "INSERT INTO medico_paginas VALUES (NULL, $med, '$nom', '$dir', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Alta Pag Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'pagina' => $nom, 'direccion' => $dir);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btnp-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnp-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editPagina':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];
			$dir = $_POST['dir'];

			$SQL = "UPDATE medico_paginas SET pagina = '$nom', direccion = '$dir' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Edita Pag Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'pagina' => $nom, 'direccion' => $dir);
				$actions = '<button type="button" class="btn btn-xs btn-primary btnp-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnp-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delPagina':
		if($edita){
			$id = $_POST['id'];
			$num = $_POST['num'];

			$SQL = "UPDATE medico_paginas SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$num;
				$log->setDatos('Baja Pag Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;


	/** IDIOMAS **/
	case 'getIdiomas':
		$med = $_POST['med'];

		$SQL = "SELECT * FROM medico_idiomas WHERE status = 1 AND id_medico = $med; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btni-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btni-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'addIdioma':
		if($edita){
			$med = $_POST['med'];
			$idi = $_POST['idi'];
			$hab = $_POST['hab'];
			$esc = $_POST['esc'];

			$SQL = "INSERT INTO medico_idiomas VALUES (NULL, $med, '$idi', '$hab', '$esc', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$idi;
				$log->setDatos('Alta Idioma Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'idioma' => $idi, 'hablado' => $hab, 'escrito' => $esc);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btni-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btni-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editIdioma':
		if($edita){
			$id = $_POST['id'];
			$idi = $_POST['idi'];
			$hab = $_POST['hab'];
			$esc = $_POST['esc'];

			$SQL = "UPDATE medico_idiomas SET idioma = '$idi', hablado = '$hab', escrito = '$esc' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$idi;
				$log->setDatos('Edita Idioma Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'idioma' => $idi, 'hablado' => $hab, 'escrito' => $esc);
				$actions = '<button type="button" class="btn btn-xs btn-primary btni-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btni-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delIdioma':
		if($edita){
			$id = $_POST['id'];
			$idi = $_POST['idi'];

			$SQL = "UPDATE medico_idiomas SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$idi;
				$log->setDatos('Baja Idioma Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	/** EXPERIENCIA CLINICA **/
	case 'getExpCli':
		$med = $_POST['med'];

		$SQL = "SELECT ID, descripcion FROM medico_exp_prof WHERE status = 1 AND id_medico = $med; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btnec-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btnec-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'addExpCli':
		if($edita){
			$desc = $_POST['desc'];
			$med = $_POST['med'];

			$SQL = "INSERT INTO medico_exp_prof VALUES (NULL, $med, '$desc', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$desc;
				$log->setDatos('Alta ExpCli Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'descripcion' => $desc);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btnec-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnec-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editExpCli':
		if($edita){
			$id = $_POST['id'];
			$desc = $_POST['desc'];

			$SQL = "UPDATE medico_exp_prof SET descripcion = '$desc' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$desc;
				$log->setDatos('Edita ExpCli Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'descripcion' => $desc);
				$actions = '<button type="button" class="btn btn-xs btn-primary btnec-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnec-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delExpCli':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];

			$SQL = "UPDATE medico_exp_prof SET status = 2 WHERE ID = $id; ";
			$res = mysql_query($SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja ExpCli Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	/** EXPERIENCIA QUIRURGICA **/
	case 'getExpQui':
		$med = $_POST['med'];

		$SQL = "SELECT ID, descripcion FROM medico_exp_qui WHERE status = 1 AND id_medico = $med; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btneq-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btneq-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'addExpQui':
		if($edita){
			$desc = $_POST['desc'];
			$med = $_POST['med'];

			$SQL = "INSERT INTO medico_exp_qui VALUES (NULL, $med, '$desc', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$desc;
				$log->setDatos('Alta ExpQui Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'descripcion' => $desc);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btneq-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btneq-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editExpQui':
		if($edita){
			$id = $_POST['id'];
			$desc = $_POST['desc'];

			$SQL = "UPDATE medico_exp_qui SET descripcion = '$desc' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$desc;
				$log->setDatos('Edita ExpQui Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'descripcion' => $desc);
				$actions = '<button type="button" class="btn btn-xs btn-primary btneq-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btneq-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delExpQui':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];

			$SQL = "UPDATE medico_exp_qui SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja ExpQui Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;


	/** ESTUDIOS Y TRATAMIENTOS **/
	case 'getEstTrat':
		$med = $_POST['med'];

		$SQL = "SELECT ID, descripcion FROM medico_pad_pro WHERE status = 1 AND id_medico = $med; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btnet-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btnet-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'addEstTrat':
		if($edita){
			$desc = $_POST['desc'];
			$med = $_POST['med'];

			$SQL = "INSERT INTO medico_pad_pro VALUES (NULL, $med, '$desc', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$desc;
				$log->setDatos('Alta EstTrat Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'descripcion' => $desc);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btnet-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnet-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editEstTrat':
		if($edita){
			$id = $_POST['id'];
			$desc = $_POST['desc'];

			$SQL = "UPDATE medico_pad_pro SET descripcion = '$desc' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$desc;
				$log->setDatos('Edita EstTrat Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'descripcion' => $desc);
				$actions = '<button type="button" class="btn btn-xs btn-primary btnet-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnet-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delEstTrat':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];

			$SQL = "UPDATE medico_pad_pro SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja EstTrat Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	/** CURRICULUM **/
	
	case 'getCurriculum':
		$tipo = intval($_POST['tipo']);
		$med = $_POST['med'];

		$cur = $arrCurri[$tipo];

		$SQL = "SELECT * FROM ".$cur['tbl']." WHERE status = 1 AND id_medico = $med; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btncurr-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btncurr-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'addCurriculum':
		if($edita){
			$desc = $_POST['desc'];
			$med = $_POST['med'];
			$anio = $_POST['anio'];
			$tipo = intval($_POST['tipo']);

			$cur = $arrCurri[$tipo];

			$SQL = "INSERT INTO ".$cur['tbl']." VALUES (NULL, $med, '$desc', '$anio', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$desc;
				$log->setDatos('Alta '.$cur['log'].' Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'descripcion' => $desc, 'anio' => $anio);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btncurr-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btncurr-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editCurriculum':
		if($edita){
			$id = $_POST['id'];
			$desc = $_POST['desc'];
			$anio = $_POST['anio'];
			$tipo = intval($_POST['tipo']);

			$cur = $arrCurri[$tipo];

			$SQL = "UPDATE ".$cur['tbl']." SET descripcion = '$desc', anio = '$anio' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$desc;
				$log->setDatos('Edita '.$cur['log'].' Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'descripcion' => $desc, 'anio' => $anio);
				$actions = '<button type="button" class="btn btn-xs btn-primary btncurr-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btncurr-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delCurriculum':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];
			$tipo = intval($_POST['tipo']);

			$cur = $arrCurri[$tipo];

			$SQL = "UPDATE ".$cur['tbl']." SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja '.$cur['log'].' Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;


	/** FACTURACION **/
	case 'getCP':
		$cp = $_POST['cp'];

		$SQL = "SELECT * FROM codigo_postal WHERE d_codigo = '$cp' ORDER BY d_asenta; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($col = mysqli_fetch_assoc($res)) {
			$arr[] = utf8_encode($col['d_asenta']);
			$muni = utf8_encode($col['D_mnpio']);
			$ciu = utf8_encode($col['d_ciudad']);
			$edo = utf8_encode($col['d_estado']);
		}

		if(count($arr) > 0){
			$arrRes = array('success' => true, 'colonia' => $arr, 'muni' => $muni, 'ciudad' => $ciu, 'estado' => $edo);
		}else{
			$arrRes = array('success' => false);
		}
		echo json_encode($arrRes);
		break;

	case 'saveFact':
		if($edita){
			$med = $data->med;
			$id = intval($data->id);

			if($id == 0){
				$SQLe = "INSERT INTO medico_fiscal VALUES (NULL, $med, '$data->tipo', '$data->razon', '$data->rfc', '$data->nom', '$data->rep', '$data->calle', '$data->ext', '$data->int', '$data->cp', '$data->col', '$data->ciu', '$data->mun', '$data->edo', '$data->mail'); ";
				$rese = mysqli_query($conn, $SQLe);

				$id = mysqli_insert_id($conn);
			}else{
				$SQLe = "UPDATE medico_fiscal SET tipo = '$data->tipo', razon_social = '$data->razon', rfc = '$data->rfc', nombre_comercial = '$data->nom', representante = '$data->rep', calle = '$data->calle', exterior = '$data->ext', interior = '$data->int', codigo_postal = '$data->cp', colonia = '$data->col', ciudad = '$data->ciu', municipio = '$data->mun', estado = '$data->edo', email = '$data->mail' 
							WHERE ID = $id; ";
				$rese = mysqli_query($conn, $SQLe);
			}
			if($id > 0){

				$detalle = $med.' '.$id;
				$log->setDatos('Actualiza Médico Fiscal '.$detalle,$dataString,$med,MEDICOS);
            	$log->saveLog();

				$arrRes = array('success' => true, 'id' => $id);	
			}else{
				$arrRes = array('success' => false);
			}
		}else{
			$arrRes = array('success' => false, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;


	/** SERVICIOS **/
	case 'getServicios':
		$med = $_POST['med'];

		$SQL = "SELECT * FROM medico_servicio WHERE status = 1 AND id_medico = $med; ";
		$res = mysqil_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btnserv-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btnserv-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'getServicio':
		$id = $_POST['id'];

		$SQL = "SELECT * FROM medico_servicio WHERE ID = $id; ";
		$info = mysqli_fetch_assoc(mysqli_query($conn, $SQL));

		echo json_encode($info);
		break;

	case 'addServicio':
		if($edita){
			$med = $data->med;

			$SQL = "INSERT INTO medico_servicio VALUES (NULL, $med, '$data->nom', '$data->desc', '$data->costo', '$data->descu', '$data->motivo', '$data->costod', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Alta Serv Médico'.$detalle,$dataString,$id,MEDICOS);
            	$log->saveLog();

            	$item = array('ID' => $id, 'nombre' => $data->nom, 'descripcion' => $data->desc, 'costo' => $data->costo);
            	$actions = '<button type="button" class="btn btn-xs btn-primary btnserv-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnserv-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editServicio':
		if($edita){
			$id = $data->id;

			$SQL = "UPDATE medico_servicio SET nombre = '$data->nom', descripcion = '$data->desc', costo = '$data->costo', descuento = '$data->descu', motivo = '$data->motivo', costo_desc = '$data->costod' WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$data->nom;
				$log->setDatos('Edita Serv Médico'.$detalle,$dataString,$id,MEDICOS);
            	$log->saveLog();

				$item = array('ID' => $id, 'nombre' => $data->nom, 'descripcion' => $data->desc, 'costo' => $data->costo);
				$actions = '<button type="button" class="btn btn-xs btn-primary btnserv-edit" title="Editar"><i class="fa fa-pencil"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnserv-del" title="Eliminar"><i class="fa fa-trash"></i></button>';

				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);		
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delServicio':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];

			$SQL = "UPDATE medico_servicio SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Serv Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;


	/** ARCHIVOS **/
	case 'getFiles':
		$med = $_POST['med'];

		$SQL = "SELECT *, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha FROM medico_archivo WHERE status = 1 AND id_medico = $med ORDER BY nombre; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = $item;
		}

		$actions = '';
		if($edita){
			$actions = '<button type="button" class="btn btn-xs btn-primary btnfile-dwn" title="Descargar"><i class="fa fa-download"></i></button>';
			$actions .= '<button type="button" class="btn btn-xs btn-danger btnfile-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
		}

		echo json_encode(array('items' => $arr, 'act' => $actions));
		break;

	case 'addFile':
		if($edita){
			$med = $_POST['file-med'];
			$name = $_POST['file-name'];
			$desc = $_POST['file-desc'];
			$ext = $_POST['file-ext'];
			$peso = $_POST['file-peso'];
			$camp = $_POST['file-camp'];

			$dir = '../data/'.md5(sha1(trim($med)));
			if (!file_exists($dir))
				@mkdir($dir);
			$dir .= '/files';
			if (!file_exists($dir))
				@mkdir($dir);
			$dir .= '/';
			$filename = $dir.$name.'.'.$ext;
			move_uploaded_file($_FILES["file-file"]["tmp_name"], $filename);

			$peso = $peso / 1024;
			if($peso < 1024){
				$peso = number_format($peso,2).' KB';
			}else{
				$peso = $peso / 1024;
				$peso = number_format($peso,2).' MB';
			}

			$filename = substr($filename,8);
			$SQL = "INSERT INTO medico_archivo VALUES (NULL,$med,'$name','$desc','".strtoupper($ext)."',NOW(),0,'$filename','$peso',1, '$camp'); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);

			if($id > 0){
				$detalle = $id.' '.$name;
				$log->setDatos('Alta Archivo Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

            	$actions = '<button type="button" class="btn btn-xs btn-primary btnfile-dwn" title="Descargar"><i class="fa fa-download"></i></button>';
				$actions .= '<button type="button" class="btn btn-xs btn-danger btnfile-del" title="Eliminar"><i class="fa fa-trash"></i></button>';
				$item = array('ID' => $id, 'nombre' => $name, 'descripcion' => $desc, 'extension' => strtoupper($ext), 'fecha' => date('d/m/Y'), 'url' => $filename, 'peso' => $peso, 'campana' => $camp);
				$arrRes = array('error' => false, 'item' => $item, 'act' => $actions);	
			}else{
				$arrRes = array('error' => true, 'msg' => 'Ocurrio algo extraño');
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delFile':
		if($edita){
			$id = $_POST['id'];
			$nom = $_POST['nom'];

			$SQL = "UPDATE medico_archivo SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja File Médico'.$detalle,$detalle,$id,MEDICOS);
            	$log->saveLog();

				$arrRes = array('error' => false);	
			}else{
				$arrRes = array('error' => true);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;


	case 'changeFoto':
		$med = $_POST['med'];

		$path = '../data/';
		$dir = md5(sha1(trim($med)));
		if (!file_exists($path.$dir))
			@mkdir($path.$dir);

		$filename = stripslashes($_FILES['qqfile']['name']);
		$filename = preg_replace('/[^\w\._]+/', '_', $filename);
		$url = $dir.'/'.$filename;

		move_uploaded_file($_FILES["qqfile"]["tmp_name"], $path.$url);

		$SQL = "UPDATE medico SET fotografia = '$url' 
							WHERE ID = $med;";
		$res = mysqli_query($conn, $SQL);

		$url = URL_ROOT.'/data/'.$url;
		if($res){
			$log->setDatos('Cambia Foto Médico'.$med,$med,$med,MEDICOS);
	    	$log->saveLog();
			$arrRes = array('success' => true, 'url' => $url);
		}else{
			$arrRes = array('success' => false, 'elem' => 'gral', 'msg' => 'Ha ocurrido un error u_u Intenta nuevamente.');
		}

		/*if (resize($_FILES['qqfile']['tmp_name'], 500, $path.$url)) {
		  	if(intval($id) == 0){
				$SQL = "INSERT INTO facty_config 
							VALUES ('', $empr, 0, 2, '1.00', 'es', 1, '', '', '', '', '', '', '$url', 1, 1); ";
				$res = mysql_query($SQL);
				$id = mysql_insert_id();
			}else{
				$SQL = "UPDATE facty_config SET logotipo = '$url' 
							WHERE id_config = $id;";
				$res = mysql_query($SQL);
			}

			$url = URL_ROOT.'/data/'.$url;
			if($res){
				writeLog(6, 45, 'Logotipo', $idSesion, $user);	// Action 45 Modifica Datos
				$arrRes = array('success' => true, 'id' => $id, 'url' => $url);
			}else{
				$arrRes = array('success' => false, 'elem' => 'gral', 'msg' => 'Ha ocurrido un error u_u Intenta nuevamente.');
			}
		} else {
		  $arrRes = array('success' => false, 'msg' => 'No se pudo redimensionar el logotipo.');
		}*/
		echo json_encode($arrRes);
		break;

	case 'delFoto':
		if($edita){
			$med = $_POST['med'];

			$SQL = "SELECT fotografia  
						FROM medico 
							WHERE ID = $med LIMIT 1;";
			$info = mysqli_fetch_assoc(mysqli_query($conn, $SQL));

			@unlink('../data/'.$info['fotografia']);

			$SQLU = "UPDATE medico 
						SET fotografia = '' WHERE ID = $med LIMIT 1;";
			$res = mysqli_query($conn, $SQLU);

			$log->setDatos('Baja Foto Médico'.$med,$med,$id,MEDICOS);
	    	$log->saveLog();
		}else{
			$res = false;
		}
		echo json_encode($res);
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