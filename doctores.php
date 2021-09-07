<?php 

	header('Content-Type: application/json');
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
	echo json_encode($resultado);

 ?>