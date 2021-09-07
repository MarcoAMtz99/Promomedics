<?php 

/* 	header('Content-Type: application/json'); */
/* 	$conexion = mysqli_connect("localhost","root" ,"!_WOXa9ZxWfP","bywsicom_promo"); */
	/* $conn = mysql_pconnect('localhost','bywsicom_promo','!_WOXa9ZxWfP');
	mysql_select_db('bywsicom_promo'); */
	/* include 'conex.php'; */

	$enlace =  mysql_connect('localhost', 'bywsicom_promo', '!_WOXa9ZxWfP');
			if (!$enlace) {
				die('No pudo conectarse: ' . mysql_error());
			}
			echo 'Conectado satisfactoriamente';
			mysql_select_db('bywsicom_promo');

	$sql = "select id,
							(select nombre from medico where ID = id_medico) as nombre,
							(select paterno from medico where ID = id_medico) as paterno,
							(select materno from medico where ID = id_medico) as materno,
							paciente,
							fecha_consulta as start,
							hora_consulta,
							aseguradora,
							telefono1,
							telefono2,
							telefono3,
							costoConsulta,
							recado,
							edad,
							comoSeEntero
							 from agenda;";
	$SQL2 ='select * from agenda';

	$res = mysql_query($sql);

	$arrItems = array();
	while ($fila = mysql_fetch_assoc($res)) {
	
		/* echo $fila['paciente'] ; */
	
		$array = array(
			'id' => $fila['id'],
			'nombre' => $fila['nombre'],
			'paterno' => $fila['paterno'],
			'materno' => $fila['materno'],
			'paciente' => $fila['paciente'],
			'start' => $fila['start'],
			'hora_consulta' => $fila['hora_consulta'],
			'telefono1' => $fila['telefono1'],
			'telefono2' => $fila['telefono2'],
			'telefono3' => $fila['telefono3'],
			'costoConsulta' => $fila['costoConsulta'],
			'aseguradora' => $fila['aseguradora'],
			'recado' => $fila['recado'],
			'edad' => $fila['edad'],
			'comoSeEntero' => $fila['comoSeEntero']
			);
			array_push($arrItems,$array);
	}
	$array2 = array('AGENDA' => $arrItems);
		return json_encode($array2);



	/* VERSIION 7.3 */
/* 	header('Content-Type: application/json');
	$conexion = mysqli_connect("localhost","root" ,"","promo");
	$pdo = new PDO("mysql:dbname=promo; host=localhost","root","");
	$sql = $pdo->prepare("select id,
							 (select nombre from medico where ID = id_medico) as nombre,
							(select paterno from medico where ID = id_medico) as paterno,
							(select materno from medico where ID = id_medico) as materno,
							paciente,
							fecha_consulta as start,
							hora_consulta,
							aseguradora,
							telefono1,
							telefono2,
							telefono3,
							costoConsulta,
							recado,
							edad,
							comoSeEntero
							 from agenda;");
	$sql->execute();

	$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($resultado); */

 ?>