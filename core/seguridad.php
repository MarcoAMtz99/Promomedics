<?php

include 'conex.php';

$user = $_SESSION['user'];
$idSesion = $_SESSION['logID'];
$aperm = $_SESSION['perm'];

if(!$user || !array_key_exists(MOD_SEGURIDAD, $aperm)){
	echo "Acceso restringido. You shall not pass..";
	exit(0);
}else{
	$perm = $aperm[MOD_SEGURIDAD];
	$edita = false;
	if($perm['action'] == 'EDIT') $edita = true;
	
	$action = $_POST['action'];
	if(!isset($_GET['action'])) $action = $_POST['action'];
	if (isset($_POST['data'])) {
			$dataString = $_POST['data'];
			$data = json_decode($dataString);
	}


	include 'Log.class.php';
	$log = new Log($user,$idSesion);
}

switch ($action) {
	case 'getModulos':
		if(!array_key_exists(MOD_MODULOS, $perm['children'])){
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}else{		
			$SQL = "SELECT id_modulo, nombre, descripcion, url,  
							(SELECT CASE url WHEN '#' THEN 1 ELSE 0 END) AS submodulos 
						FROM seg_modulo WHERE status = 1 AND fk_parent = 0 ORDER BY nombre; ";
			$res = mysqli_query($conn, $SQL);

			$arrItems = array();
			while ($item = mysqli_fetch_assoc($res)) {
				$arrItems[] = $item;
			}

			$acciones = '';
			if($edita){
				$acciones = '<button class="btn btn-primary btn-xs btn-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil fa-fw"></i></button> ';
				$acciones .= '<button class="btn btn-danger btn-xs btn-del" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash fa-fw"></i></button>';
			}
			
			$arrRes = array('error' => false, 'items' => $arrItems, 'actions' => $acciones);		
		}
		echo json_encode($arrRes);
		break;

	case 'getModulo':
		if(!array_key_exists(MOD_MODULOS, $perm['children'])){
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}else{
			$id = $_POST['id'];

			$SQL = "SELECT *, (SELECT CASE url WHEN '#' THEN 1 ELSE 0 END) AS submodulos 
						FROM seg_modulo WHERE id_modulo = ".$id;
			$res = mysqli_query($conn, $SQL);

			$item = mysqli_fetch_assoc($res);
			
			$arrRes = array('error' => false, 'item' => $item);		
		}
		echo json_encode($arrRes);
		break;

	case 'getSubmodulos':
		if(!array_key_exists(MOD_MODULOS, $perm['children'])){
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}else{
			$id = $_POST['id'];

			$SQL = "SELECT id_modulo, nombre, descripcion, url 
						FROM seg_modulo WHERE status = 1 AND fk_parent = $id ORDER BY nombre; ";
			$res = mysqli_query($conn, $SQL);

			$arrItems = array();
			while ($item = mysqli_fetch_assoc($res)) {
				$arrItems[] = $item;
			}

			$acciones = '';
			if($edita){
				$acciones = '<button class="btn btn-primary btn-xs btn-edits" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil fa-fw"></i></button> ';
				$acciones .= '<button class="btn btn-danger btn-xs btn-del" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash fa-fw"></i></button>';
			}
			
			$arrRes = array('error' => false, 'items' => $arrItems, 'actions' => $acciones);		
		}
		echo json_encode($arrRes);
		break;

	case 'addModulo':
		$permm = $perm['children'][MOD_MODULOS];
		if($edita && $permm['action'] == 'EDIT'){
			$SQL = "INSERT INTO seg_modulo VALUES (NULL, '$data->parent', '$data->abrev', '$data->nom', '$data->desc', '$data->url', '$data->ico', NOW(), NOW(), '', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);
			if($id > 0){
				$detalle = $id.' '.$data->nom;
				$log->setDatos('Alta Módulo'.$detalle,$dataString,$id,MODULOS);
            	$log->saveLog();

				$item = array('id_modulo' => $id, 'nombre' => $data->nom, 'descripcion' => $data->desc, 'submodulos' => $data->url == '#' ? 1 : 0, 'url' => $data->url);
				$acciones = '<button class="btn btn-primary btn-xs btn-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil fa-fw"></i></button> ';
				$acciones .= '<button class="btn btn-danger btn-xs btn-del" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash fa-fw"></i></button>';
				
				$arrRes = array('id' => $id, 'item' => $item, 'actions' => $acciones);
			}else{
				$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'No se pudo guardar');
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editModulo':
		$permm = $perm['children'][MOD_MODULOS];
		if($edita && $permm['action'] == 'EDIT'){
			$SQL = "UPDATE seg_modulo SET fk_parent = '$data->parent', abrev = '$data->abrev', nombre = '$data->nom', descripcion = '$data->desc', url = '$data->url', icono = '$data->ico', modificado = NOW() WHERE id_modulo = $data->id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $data->id.' '.$data->nom;
				$log->setDatos('Edita Módulo'.$detalle,$dataString,$data->id,MODULOS);
            	$log->saveLog();

				$item = array('id_modulo' => $data->id, 'nombre' => $data->nom, 'descripcion' => $data->desc, 'submodulos' => $data->url == '#' ? 1 : 0, 'url' => $data->url);
				$acciones = '<button class="btn btn-primary btn-xs btn-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil fa-fw"></i></button> ';
				$acciones .= '<button class="btn btn-danger btn-xs btn-del" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash fa-fw"></i></button>';
				
				$arrRes = array('id' => $data->id, 'item' => $item, 'actions' => $acciones);
			}else{
				$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'No se pudo guardar', 'sql' => $SQL);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delModulo':
		$permm = $perm['children'][MOD_MODULOS];
		if($edita && $permm['action'] == 'EDIT'){
			$id = $_POST['id'];

			$SQL = "UPDATE seg_modulo SET status = 2, eliminado = NOW() WHERE id_modulo = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Módulo'.$detalle,$detalle,$id,MODULOS);
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

	
	/** PERFILES **/
	case 'getPerfiles':
		if(!array_key_exists(MOD_PERFILES, $perm['children'])){
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}else{		
			$SQL = "SELECT id_perfil, nombre, descripcion 
						FROM seg_perfil WHERE status = 1 /*ORDER BY nombre*/; ";
			$res = mysqli_query($conn, $SQL);

			$arrItems = array();
			while ($item = mysqli_fetch_assoc($conn, $res)) {
				$arrItems[] = $item;
			}

			$acciones = '';
			if($edita){
				$acciones = '<button class="btn btn-primary btn-xs btn-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil fa-fw"></i></button> ';
				$acciones .= '<button class="btn btn-danger btn-xs btn-del" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash fa-fw"></i></button>';
			}
			
			$arrRes = array('error' => false, 'items' => $arrItems, 'actions' => $acciones);		
		}
		echo json_encode($arrRes);
		break;

	case 'addPerfil':
		$permp = $perm['children'][MOD_PERFILES];
		if($edita && $permp['action'] == 'EDIT'){
			$SQL = "INSERT INTO seg_perfil VALUES (null,'$data->nom', '$data->desc', NOW(), NOW(), null, 1) ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);
			if($id > 0){
				$detalle = $id.' '.$data->nom;
				$log->setDatos('Alta Perfil '.$detalle,$dataString,$id,PERFILES);
            	$log->saveLog();

				$item = array('id_perfil' => $id, 'nombre' => $data->nom, 'descripcion' => $data->desc);
				$acciones = '<button class="btn btn-primary btn-xs btn-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil fa-fw"></i></button> ';
				$acciones .= '<button class="btn btn-danger btn-xs btn-del" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash fa-fw"></i></button>';
				
				$arrRes = array('id' => $id, 'item' => $item, 'actions' => $acciones);
			}else{
				$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'No se pudo guardar','id_query'=>$SQL,'data'=>$data,'res'=>$res);
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editPerfil':
		$permp = $perm['children'][MOD_PERFILES];
		if($edita && $permp['action'] == 'EDIT'){
			$SQL = "UPDATE seg_perfil SET nombre = '$data->nom', descripcion = '$data->desc', modificado = NOW() WHERE id_perfil = $data->id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $data->id.' '.$data->nom;
				$log->setDatos('Edita Perfil '.$detalle,$dataString,$data->id,PERFILES);
            	$log->saveLog();

				$item = array('id_perfil' => $data->id, 'nombre' => $data->nom, 'descripcion' => $data->desc);
				$acciones = '<button class="btn btn-primary btn-xs btn-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil fa-fw"></i></button> ';
				$acciones .= '<button class="btn btn-danger btn-xs btn-del" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash fa-fw"></i></button>';
				
				$arrRes = array('id' => $data->id, 'item' => $item, 'actions' => $acciones);
			}else{
				$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'No se pudo guardar');
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'delPerfil':
		$permp = $perm['children'][MOD_PERFILES];
		if($edita && $permp['action'] == 'EDIT'){
			$id = $_POST['id'];

			$SQL = "UPDATE seg_perfil SET status = 2, eliminado = NOW() WHERE id_perfil = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Perfil '.$detalle,$detalle,$id,PERFILES);
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


	/** PERMISOS **/
	case 'getPermisos':
		if(!array_key_exists(MOD_PERFILES, $perm['children'])){
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}else{
			$perf = $_POST['perf'];
			$SQL = "SELECT fk_modulo, action 
						FROM seg_permiso WHERE fk_perfil = $perf ORDER BY fk_modulo; ";
			$res = mysqli_query($conn, $SQL);

			$arrItems = array();
			while ($item = mysqli_fetch_assoc($res)) {
				$arrItems[] = $item;
			}
			
			$permp = $perm['children'][MOD_PERFILES];
			$arrRes = array('error' => false, 'items' => $arrItems, 'action' => $permp['action']);		
		}
		echo json_encode($arrRes);
		break;

	case 'savePerm':
		$permp = $perm['children'][MOD_PERFILES];
		if($edita && $permp['action'] == 'EDIT'){
			$act = $data->act;

			$det = $data->perf.':'.$data->mod;
			if($act == 'NONE'){
				$SQLd = "DELETE FROM seg_permiso WHERE fk_perfil = $data->perf AND fk_modulo = $data->mod; ";
				$resd = mysqli_query($conn, $SQLd);

				if(mysqli_affected_rows($conn) > 0){
					$log->setDatos('Elimina Permiso '.$det,$dataString,$data->mod,PERMISOS);
	            	$log->saveLog();

	            	$SQLp = "SELECT * FROM seg_permiso WHERE (SELECT fk_parent FROM seg_modulo WHERE id_modulo = fk_modulo) = $data->par; ";
	            	$resp = mysqli_query($conn, $SQLp);
	            	if(mysqli_num_rows($resp) == 0){
	            		$SQLp = "DELETE FROM seg_permiso WHERE fk_perfil = $data->perf AND fk_modulo = $data->par; ";
	            		mysqli_query($conn, $SQLp);
	            	}

					$arrRes = array('res' => true);	
				}else{
					$arrRes = array('error' => true);
				}
			}else{
				$SQL = "SELECT id_permiso FROM seg_permiso WHERE fk_perfil = $data->perf AND fk_modulo = $data->mod; ";
				$res = mysqli_query($conn, $SQL);

				if(mysqli_num_rows($res) > 0){
					$info = mysqli_fetch_assoc($res);
					$id = $info['id_permiso'];

					$SQLm = "UPDATE seg_permiso SET action = '$data->act' WHERE id_permiso = $id; ";
				}else{
					$SQLm = "INSERT INTO seg_permiso VALUES (NULL, $data->perf, $data->mod, '$data->act'); ";
				}

				$resm = mysqli_query($conn, $SQLm);

				if(mysqli_affected_rows($conn) > 0){
					$log->setDatos('Edita Permiso '.$det,$dataString,$data->mod,PERMISOS);
	            	$log->saveLog();


	            	$SQLp = "SELECT * FROM seg_permiso WHERE fk_perfil = $data->perf AND fk_modulo = $data->par; ";
	            	$resp = mysqli_query($conn, $SQLp);
	            	if(mysqli_num_rows($resp) == 0){
	            		$SQLp = "INSERT INTO seg_permiso VALUES (NULL, $data->perf, $data->par, '$data->act'); ";
	            		mysqli_query($conn, $SQLp);
	            	}

					$arrRes = array('res' => true);	
				}else{
					$arrRes = array('error' => true);
				}
			}
		}else{
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;


	/** USUARIOS **/
	case 'getUsuarios':
		if(!array_key_exists(MOD_USUARIOS, $perm['children'])){
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}else{		
			$medq = "";
			$med = $_SESSION['medico'];
			//if($med != '0') 
			$medq = " AND fk_medico = $med ";
			$SQL = "SELECT id_user, CONCAT(nombre, ' ', apellidos) AS nombre, username, email, 
							DATE_FORMAT(last_access,'%d/%m/%Y %H:%i:%s') AS acceso, fk_perfil, 
							(SELECT nombre FROM seg_perfil WHERE id_perfil = fk_perfil) AS perfil 
						FROM seg_user WHERE status = 1 $medq ORDER BY nombre, apellidos; ";
			$res = mysqli_query($conn, $SQL);

			$arrItems = array();
			while ($item = mysqli_fetch_assoc($res)) {
				$arrItems[] = $item;
			}

			$acciones = '';
			if($edita){
				$acciones = '<button class="btn btn-primary btn-xs btn-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil fa-fw"></i></button> ';
				$acciones .= '<button class="btn btn-danger btn-xs btn-del" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash fa-fw"></i></button>';
			}
			
			$arrRes = array('error' => false, 'items' => $arrItems, 'actions' => $acciones);		
		}
		echo json_encode($arrRes);
		break;

	case 'getUsuario':
		if(!array_key_exists(MOD_USUARIOS, $perm['children'])){
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}else{
			$id = $_POST['id'];

			$SQL = "SELECT * FROM seg_user WHERE id_user = ".$id;
			$res = mysqli_query($conn, $SQL);

			$item = mysqli_fetch_assoc($res);
			
			$arrRes = array('error' => false, 'item' => $item);		
		}
		echo json_encode($arrRes);
		break;

	case 'addUsuario':
		$permp = $perm['children'][MOD_USUARIOS];
		if($edita && $permp['action'] == 'EDIT'){

			/*$SQL = "SELECT * FROM seg_user WHERE username = '$data->user' AND status = 1; ";
			$res = mysql_query($SQL);

			if(mysql_num_rows($res) > 0){
				$arrRes = array('error' => true, 'elem' => 'item-user', 'msg' => 'Username ya registrado');
			}else{*/
				$SQL = "SELECT * FROM seg_user WHERE email = '$data->mail' AND status = 1; ";
				$res = mysql_query($SQL);

				if(mysql_num_rows($res) > 0){
					$arrRes = array('error' => true, 'elem' => 'item-mail', 'msg' => 'Email ya registrado');
				}else{
					$med = $_SESSION['medico'];
					$pass = strrev(md5(sha1(trim($data->pass))));
					$SQL = "INSERT INTO seg_user VALUES (NULL, $data->perf, $med, '$data->nom', '$data->ape', '$data->mail', '$pass', '$data->mail', '', NOW(), NOW(), '', 1); ";
					$res = mysqli_query($conn, $SQL);

					$id = mysqli_insert_id($conn);
					if($id > 0){
						$detalle = $id.' '.$data->user;
						$log->setDatos('Alta Usuario '.$detalle,$dataString,$id,USUARIOS);
		            	$log->saveLog();

						$item = array('id_user' => $id, 'nombre' => $data->nom.' '.$data->ape, 'username' => $data->user, 'email' => $data->mail, 'acceso' => '--', 'fk_perfil' => $data->perf);
						$acciones = '<button class="btn btn-primary btn-xs btn-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil fa-fw"></i></button> ';
						$acciones .= '<button class="btn btn-danger btn-xs btn-del" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash fa-fw"></i></button>';
						
						$arrRes = array('id' => $id, 'item' => $item, 'actions' => $acciones);
					}else{
						$arrRes = array('error' => true, 'elem' => 'btnSave', 'msg' => 'No se pudo guardar');
					}
				}
			//}
		}else{
			$arrRes = array('error' => true, 'elem' => 'btnSave', 'msg' => 'Acceso Restringido.');
		}
		echo json_encode($arrRes);
		break;

	case 'editUsuario':
		$permp = $perm['children'][MOD_USUARIOS];
		if($edita && $permp['action'] == 'EDIT'){

			$SQL = "SELECT * FROM seg_user WHERE username = '$data->user' AND status = 1 AND id_user != $data->id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_num_rows($res) > 0){
				$arrRes = array('error' => true, 'elem' => 'item-user', 'msg' => 'Username ya registrado');
			}else{
				$SQL = "SELECT * FROM seg_user WHERE email = '$data->mail' AND status = 1 AND id_user != $data->id; ";
				$res = mysqli_query($conn, $SQL);

				if(mysqli_num_rows($res) > 0){
					$arrRes = array('error' => true, 'elem' => 'item-mail', 'msg' => 'Email ya registrado');
				}else{
					$pass = '';
					if($data->pass != '')
						$pass = ", password = '".strrev(md5(sha1(trim($data->pass))))."' ";

					$SQL = "UPDATE seg_user SET nombre = '$data->nom', apellidos = '$data->ape', updated = NOW(), 
										fk_perfil = $data->perf, username = '$data->user', email = '$data->mail' $pass 
									WHERE id_user = $data->id; ";
					$res = mysqli_query($conn, $SQL);

					if(mysqli_affected_rows($conn) > 0){
						$detalle = $data->id.' '.$data->user;
						$log->setDatos('Edita Usuario '.$detalle,$dataString,$data->id,USUARIOS);
		            	$log->saveLog();

						$item = array('id_user' => $data->id, 'nombre' => $data->nom.' '.$data->ape, 'username' => $data->user, 'email' => $data->mail, 'acceso' => '--', 'fk_perfil' => $data->perf);
						$acciones = '<button class="btn btn-primary btn-xs btn-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil fa-fw"></i></button> ';
						$acciones .= '<button class="btn btn-danger btn-xs btn-del" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash fa-fw"></i></button>';
						
						$arrRes = array('id' => $data->id, 'item' => $item, 'actions' => $acciones);
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

	case 'delUsuario':
		$permp = $perm['children'][MOD_USUARIOS];
		if($edita && $permp['action'] == 'EDIT'){
			$id = $_POST['id'];

			$SQL = "UPDATE seg_user SET status = 2, deleted = NOW() WHERE id_user = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Usuario '.$detalle,$detalle,$id,USUARIOS);
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

	default:
		# code...
		break;
}


?>