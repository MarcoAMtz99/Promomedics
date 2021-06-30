<?php

include 'conex.php';

$user = $_SESSION['user'];
$idSesion = $_SESSION['logID'];
//$aperm = $_SESSION['perm'];

if(!$user){
	echo "Acceso restringido. You shall not pass..";
	exit(0);
}else{
	$tipo = $_POST['tipo'];
	$q = $_POST['query'];
}

$utf8 = false;
switch ($tipo) {
	case 'especialidad':
		$SQL = "SELECT ID AS data, descripcion AS value FROM pre_especialidad WHERE status = 1 AND descripcion LIKE '%$q%' ORDER BY descripcion; ";
		$utf8 = true;
		//$res = mysql_query($SQL);

		//sendResponse($res, true);
		break;

	case 'subespecialidad':
		$esp = $_POST['esp'];
		$SQL = "SELECT ID AS data, nombre AS value FROM subespecialidades WHERE status = 1 AND id_especialidad = $esp AND nombre LIKE '%$q%' ORDER BY nombre; ";
		//$res = mysql_query($SQL);
		$utf8 = true;
		//sendResponse($res, true);
		break;

	case 'servicio_med':
		$med = $_POST['med'];
		$tbl = $_POST['tbl'];
		$tabla = $tbl.'_servicio';
		$SQL = "SELECT ID AS data, nombre AS value FROM $tabla WHERE id_$tbl = $med AND status = 1 AND nombre LIKE '%$q%'; ";
		break;


	default:
		$SQL = "SELECT id_$tipo AS ID, nombre AS value FROM cat_$tipo WHERE status = 1 AND nombre LIKE '%$q%' ORDER BY nombre; ";
		break;
}

//function sendResponse($result, $utf8 = false){
$res = mysql_query($SQL);
	$arr = array();
	while ($item = mysql_fetch_assoc($res)) {
		$val = $item['value'];
		if($utf8) $val = utf8_encode($item['value']);
		$arr[] = array('data' => $item['data'], 'value' => $val);
	}

	echo json_encode(array('query' => $q, 'suggestions' => $arr));
//}

?>