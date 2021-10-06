<?php 

	header('Content-Type: application/json');

	// $conexion = mysqli_connect("localhost","root" ,"","promo"); 
	 // $conexion = mysql_pconnect('localhost','bywsicom_promo','!_WOXa9ZxWfP');
	// mysql_select_db('bywsicom_promo'); 
	/* include 'conex.php'; */
	$conexion = mysqli_connect("localhost","bywsicom_promo" ,"!_WOXa9ZxWfP","bywsicom_promo");
	
	// $conexion = mysqli_connect("localhost","root" ,"","promo");
	$pdo = new PDO("mysql:dbname=bywsicom_promo; host=localhost","bywsicom_promo","!_WOXa9ZxWfP");
	$sql = $pdo->prepare("select id,
							 (select nombre from medico where ID = id_medico) as nombre,
							(select paterno from medico where ID = id_medico) as paterno,
							(select materno from medico where ID = id_medico) as materno,
							paciente as title,
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
	echo json_encode($resultado);


 ?>