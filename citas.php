<?php 

	header('Content-Type: application/json');
	/* $conexion = mysqli_connect("localhost","root" ,"","promo"); */
	$conn = mysql_pconnect('localhost','bywsicom_promo','!_WOXa9ZxWfP');
	mysql_select_db('bywsicom_promo');

/* 	$pdo = new PDO("mysql:dbname=bywsicom_promo; host=localhost","root",""); */
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
	$res = mysql_query($sql);
	$infoMed = mysql_fetch_assoc($res);

/* 	$resultado = $res->fetchAll(PDO::FETCH_ASSOC); */
	echo json_encode($infoMed);

 ?>