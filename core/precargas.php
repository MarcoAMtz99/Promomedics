<?php

include 'conex.php';

$user = $_SESSION['user'];
$idSesion = $_SESSION['logID'];
$aperm = $_SESSION['perm'];

if(!$user || !array_key_exists(MOD_PRECARGAS, $aperm)){
	echo "Acceso restringido. You shall not pass..";
	exit(0);
}else{
	$perm = $aperm[MOD_PRECARGAS];
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
	/** DEPARTAMENTOS **/
	case 'getDeptos':
		if(!array_key_exists(MOD_DEPARTAMENTOS, $perm['children'])){
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}else{		
			$SQL = "SELECT id_departamento, nombre, descripcion 
						FROM cat_departamento WHERE status = 1 ORDER BY nombre; ";
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

	case 'addDepto':
		$permp = $perm['children'][MOD_DEPARTAMENTOS];
		if($edita && $permp['action'] == 'EDIT'){
			$SQL = "INSERT INTO cat_departamento VALUES (NULL, '$data->nom', '$data->desc', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);
			if($id > 0){
				$detalle = $id.' '.$data->nom;
				$log->setDatos('Alta Departamento '.$detalle,$dataString,$id,DEPARTAMENTOS);
            	$log->saveLog();

				$item = array('id_departamento' => $id, 'nombre' => $data->nom, 'descripcion' => $data->desc);
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

	case 'editDepto':
		$permp = $perm['children'][MOD_DEPARTAMENTOS];
		if($edita && $permp['action'] == 'EDIT'){
			$SQL = "UPDATE cat_departamento SET nombre = '$data->nom', descripcion = '$data->desc' WHERE id_departamento = $data->id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $data->id.' '.$data->nom;
				$log->setDatos('Edita Departamento '.$detalle,$dataString,$data->id,DEPARTAMENTOS);
            	$log->saveLog();

				$item = array('id_departamento' => $data->id, 'nombre' => $data->nom, 'descripcion' => $data->desc);
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

	case 'delDepto':
		$permp = $perm['children'][MOD_DEPARTAMENTOS];
		if($edita && $permp['action'] == 'EDIT'){
			$id = $_POST['id'];

			$SQL = "UPDATE cat_departamento SET status = 2 WHERE id_departamento = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Departamento '.$detalle,$detalle,$id,DEPARTAMENTOS);
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

	
	/** PUESTOS **/
	case 'getPuestos':
		if(!array_key_exists(MOD_PUESTOS, $perm['children'])){
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}else{		
			$SQL = "SELECT id_puesto, nombre, descripcion 
						FROM cat_puesto WHERE status = 1 ORDER BY nombre; ";
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

	case 'addPuesto':
		$permp = $perm['children'][MOD_PUESTOS];
		if($edita && $permp['action'] == 'EDIT'){
			$SQL = "INSERT INTO cat_puesto VALUES (NULL, '$data->nom', '$data->desc', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);
			if($id > 0){
				$detalle = $id.' '.$data->nom;
				$log->setDatos('Alta Puesto '.$detalle,$dataString,$id,PUESTOS);
            	$log->saveLog();

				$item = array('id_puesto' => $id, 'nombre' => $data->nom, 'descripcion' => $data->desc);
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

	case 'editPuesto':
		$permp = $perm['children'][MOD_PUESTOS];
		if($edita && $permp['action'] == 'EDIT'){
			$SQL = "UPDATE cat_puesto SET nombre = '$data->nom', descripcion = '$data->desc' WHERE id_puesto = $data->id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $data->id.' '.$data->nom;
				$log->setDatos('Edita Puesto '.$detalle,$dataString,$data->id,PUESTOS);
            	$log->saveLog();

				$item = array('id_puesto' => $data->id, 'nombre' => $data->nom, 'descripcion' => $data->desc);
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

	case 'delPuesto':
		$permp = $perm['children'][MOD_PUESTOS];
		if($edita && $permp['action'] == 'EDIT'){
			$id = $_POST['id'];

			$SQL = "UPDATE cat_puesto SET status = 2 WHERE id_puesto = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Puesto '.$detalle,$detalle,$id,PUESTOS);
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


	/** ESCOLARIDAD **/
	case 'getEscolaridades':
		if(!array_key_exists(MOD_ESCOLARIDAD, $perm['children'])){
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}else{		
			$SQL = "SELECT id_escolaridad, nombre, descripcion 
						FROM cat_escolaridad WHERE status = 1 ORDER BY nombre; ";
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

	case 'addEscolaridad':
		$permp = $perm['children'][MOD_ESCOLARIDAD];
		if($edita && $permp['action'] == 'EDIT'){
			$SQL = "INSERT INTO cat_escolaridad VALUES (NULL, '$data->nom', '$data->desc', 1); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);
			if($id > 0){
				$detalle = $id.' '.$data->nom;
				$log->setDatos('Alta Escolaridad '.$detalle,$dataString,$id,ESCOLARIDAD);
            	$log->saveLog();

				$item = array('id_escolaridad' => $id, 'nombre' => $data->nom, 'descripcion' => $data->desc);
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

	case 'editEscolaridad':
		$permp = $perm['children'][MOD_ESCOLARIDAD];
		if($edita && $permp['action'] == 'EDIT'){
			$SQL = "UPDATE cat_escolaridad SET nombre = '$data->nom', descripcion = '$data->desc' WHERE id_escolaridad = $data->id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $data->id.' '.$data->nom;
				$log->setDatos('Edita Escolaridad '.$detalle,$dataString,$data->id,ESCOLARIDAD);
            	$log->saveLog();

				$item = array('id_escolaridad' => $data->id, 'nombre' => $data->nom, 'descripcion' => $data->desc);
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

	case 'delEscolaridad':
		$permp = $perm['children'][MOD_ESCOLARIDAD];
		if($edita && $permp['action'] == 'EDIT'){
			$id = $_POST['id'];

			$SQL = "UPDATE cat_escolaridad SET status = 2 WHERE id_escolaridad = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Escolaridad '.$detalle,$detalle,$id,ESCOLARIDAD);
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

	
	/** ESPECIALIDAD **/
	case 'getEspecialidades':
		if(!array_key_exists(MOD_ESPECIALIDAD, $perm['children'])){
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}else{		
			$SQL = "SELECT ID, descripcion 
						FROM pre_especialidad WHERE status = 1 ORDER BY descripcion; ";
			$res = mysqli_query($conn, $SQL);

			$arrItems = array();
			while ($item = mysqli_fetch_assoc($res)) {
				$item['descripcion'] = utf8_encode($item['descripcion']);
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

	case 'addEspecialidad':
		$permp = $perm['children'][MOD_ESPECIALIDAD];
		if($edita && $permp['action'] == 'EDIT'){
			$SQL = "INSERT INTO pre_especialidad VALUES (NULL, '$data->nom', 1, NOW(), NOW(), $user, $user); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);
			if($id > 0){
				$detalle = $id.' '.$data->nom;
				$log->setDatos('Alta Especialidad '.$detalle,$dataString,$id,ESPECIALIDAD);
            	$log->saveLog();

				$item = array('ID' => $id, /*'nombre' => $data->nom,*/ 'descripcion' => $data->nom);
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

	case 'editEspecialidad':
		$permp = $perm['children'][MOD_ESPECIALIDAD];
		if($edita && $permp['action'] == 'EDIT'){
			$SQL = "UPDATE pre_especialidad SET descripcion = '$data->nom', fechaActualizacion = NOW(), usuarioActualizacionId = $user WHERE ID = $data->id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $data->id.' '.$data->nom;
				$log->setDatos('Edita Especialidad '.$detalle,$dataString,$data->id,ESPECIALIDAD);
            	$log->saveLog();

				$item = array('ID' => $data->id, /*'nombre' => $data->nom,*/ 'descripcion' => $data->nom);
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

	case 'delEspecialidad':
		$permp = $perm['children'][MOD_ESPECIALIDAD];
		if($edita && $permp['action'] == 'EDIT'){
			$id = $_POST['id'];

			$SQL = "UPDATE pre_especialidad SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Especialidad '.$detalle,$detalle,$id,ESPECIALIDAD);
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

	case 'findEspecialidad':
		$q = $_POST['query'];
		$SQL = "SELECT ID, descripcion FROM pre_especialidad WHERE status = 1 AND descripcion LIKE '%$q%' ORDER BY descripcion; ";
		$res = mysqli_query($conn, $SQL);

		$arr = array();
		while ($item = mysqli_fetch_assoc($res)) {
			$arr[] = array('data' => $item['ID'], 'value' => utf8_encode($item['descripcion']));
		}

		echo json_encode(array('query' => $q, 'suggestions' => $arr));
		break;


	/** SUBESPECIALIDAD **/
	case 'getSubesp':
		if(!array_key_exists(MOD_SUBESPECIALIDAD, $perm['children'])){
			$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'Acceso Restringido.');
		}else{		
			$SQL = "SELECT ID, id_especialidad, nombre, 
							(SELECT descripcion FROM pre_especialidad e WHERE e.ID = id_especialidad) AS esp 
						FROM subespecialidades WHERE status = 1 AND (SELECT status FROM pre_especialidad e WHERE e.ID = id_especialidad) = 1 ORDER BY esp, nombre; ";
			$res = mysqli_query($conn, $SQL);

			$arrItems = array();
			while ($item = mysqli_fetch_assoc($res)) {
				$item['nombre'] = utf8_encode($item['nombre']);
				$item['esp'] = utf8_encode($item['esp']);
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

	case 'addSubesp':
		$permp = $perm['children'][MOD_SUBESPECIALIDAD];
		if($edita && $permp['action'] == 'EDIT'){
			$SQL = "INSERT INTO subespecialidades VALUES (NULL, $data->esp, '$data->nom', 1, NOW(), NOW(), $user, $user); ";
			$res = mysqli_query($conn, $SQL);

			$id = mysqli_insert_id($conn);
			if($id > 0){
				$detalle = $id.' '.$data->nom;
				$log->setDatos('Alta Subespecialidad '.$detalle,$dataString,$id,SUBESPECIALIDAD);
            	$log->saveLog();

				$item = array('ID' => $id, 'nombre' => $data->nom, 'id_especialidad' => $data->esp, 'esp' => $data->esps);
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

	case 'editSubesp':
		$permp = $perm['children'][MOD_SUBESPECIALIDAD];
		if($edita && $permp['action'] == 'EDIT'){
			$SQL = "UPDATE subespecialidades SET id_especialidad = $data->esp, nombre = '$data->nom', fechaActualizacion = NOW(), usuarioActualizacionId = $user WHERE ID = $data->id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $data->id.' '.$data->nom;
				$log->setDatos('Edita Subespecialidad '.$detalle,$dataString,$data->id,SUBESPECIALIDAD);
            	$log->saveLog();

				$item = array('ID' => $data->id, 'nombre' => $data->nom, 'id_especialidad' => $data->esp, 'esp' => $data->esps);
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

	case 'delSubesp':
		$permp = $perm['children'][MOD_SUBESPECIALIDAD];
		if($edita && $permp['action'] == 'EDIT'){
			$id = $_POST['id'];

			$SQL = "UPDATE subespecialidades SET status = 2 WHERE ID = $id; ";
			$res = mysqli_query($conn, $SQL);

			if(mysqli_affected_rows($conn) > 0){
				$detalle = $id.' '.$nom;
				$log->setDatos('Baja Subespecialidad '.$detalle,$detalle,$id,SUBESPECIALIDAD);
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

function getItems($tipo, $edita){
	$SQL = "SELECT *  FROM cat_$tipo WHERE status = 1 ORDER BY nombre; ";
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
	return $arrRes;
}

function addItem($tipo, $tbl){
	global $data, $log;
	$SQL = "INSERT INTO cat_$tipo VALUES (NULL, '$data->nom', '$data->desc', 1); ";
	$res = mysqli_query($conn, $SQL);

	$id = mysqli_insert_id($conn);
	if($id > 0){
		$detalle = $id.' '.$data->nom;
		$log->setDatos("Alta $tipo ".$detalle,$dataString,$id,$tbl);
    	$log->saveLog();

		$item = array("id_$tipo" => $id, 'nombre' => $data->nom, 'descripcion' => $data->desc);
		$acciones = '<button class="btn btn-primary btn-xs btn-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil fa-fw"></i></button> ';
		$acciones .= '<button class="btn btn-danger btn-xs btn-del" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash fa-fw"></i></button>';
		
		$arrRes = array('id' => $id, 'item' => $item, 'actions' => $acciones);
	}else{
		$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'No se pudo guardar');
	}
	return $arrRes;
}

function editItem($tipo, $tbl){
	global $data, $log;
	$SQL = "UPDATE cat_$tipo SET nombre = '$data->nom', descripcion = '$data->desc' WHERE id_$tipo = $data->id; ";
	$res = mysqli_query($conn, $SQL);

	if(mysqli_affected_rows($conn) > 0){
		$detalle = $data->id.' '.$data->nom;
		$log->setDatos("Edita $tipo ".$detalle,$dataString,$data->id,$tbl);
    	$log->saveLog();

		$item = array("id_$tipo" => $data->id, 'nombre' => $data->nom, 'descripcion' => $data->desc);
		$acciones = '<button class="btn btn-primary btn-xs btn-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil fa-fw"></i></button> ';
		$acciones .= '<button class="btn btn-danger btn-xs btn-del" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash fa-fw"></i></button>';
		
		$arrRes = array('id' => $data->id, 'item' => $item, 'actions' => $acciones);
	}else{
		$arrRes = array('error' => true, 'elem' => 'gral', 'msg' => 'No se pudo guardar');
	}
	return $arrRes;
}

function delItem($tipo, $id, $tbl){
	global $log;
	$SQL = "UPDATE cat_$tipo SET status = 2 WHERE id_$tipo = $id; ";
	$res = mysqli_query($conn, $SQL);

	if(mysqli_affected_rows($conn) > 0){
		$detalle = $id.' '.$nom;
		$log->setDatos("Baja $tipo ".$detalle,$detalle,$id,$tbl);
    	$log->saveLog();

		$arrRes = array('res' => true);	
	}else{
		$arrRes = array('error' => true);
	}

	return $arrRes;
}

?>