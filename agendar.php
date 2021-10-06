<?php 

	header('Content-Type: application/json');
	//desarrollo 
	// $conexion = mysqli_connect("localhost","root" ,"","promo");
	// $pdo = new PDO("mysql:dbname=promo; host=localhost","root","");
	//PRODUCCION
	$conexion = mysqli_connect("localhost","bywsicom_promo" ,"!_WOXa9ZxWfP","bywsicom_promo");
		// $conn = mysqli_connect('localhost','bywsicom_promo','!_WOXa9ZxWfP','bywsicom_promo');
	$pdo = new PDO("mysql:dbname=bywsicom_promo; host=localhost","bywsicom_promo","!_WOXa9ZxWfP");

	$paciente = $_POST["paciente"];
	$fecha_consulta = $_POST["fecha"];
	$costoConsulta = $_POST["costoConsulta"];



	$sql = $pdo->prepare("INSERT INTO `agenda`(`id_medico`, `status`, `fechaCreacion`, `fechaActualizacion`, `usuarioCreacionId`, `usuarioActualizacionId`, `id_consultorio`, `paciente`, `fecha_consulta`, `hora_consulta`, `aseguradora`, `mail`, `telefono1`, `telefono2`, `telefono3`, `consultaPrimeraVez`, `consultaSubsecuente`, `consultaPreferencial1`, `consultaPreferencial2`, `consultaRevision`, `consultaEstudios`, `consultaUrgencia`, `costoConsulta`, `recado`, `comoSeEntero`, `edad`, `tutor`) VALUES (10,1,'2021-10-06','2021-10-06',1,1,14,'$paciente','$fecha_consulta','12:00:00','GNP','prueba@gmail.com','1234567890','1234567890','1234567890',0,0,0,0,0,0,0,'$costoConsulta','prueba','internet',25,null)");

	$sql->execute();

	// $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
	header("Location: calendario.php");
	// echo json_encode($sql->execute());

 ?>