<?php 

	header('Content-Type: application/json');
	$conexion = mysqli_connect('localhost','bywsicom_promo','!_WOXa9ZxWfP','bywsicom_promo');
	if (mysqli_connect_errno()) {
		//VALIDAR CONEXION A DB
    printf(mysqli_connect_error());
    exit();
	}
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

	//create connection and select DB
    $db = new mysqli("localhost", "bywsicom_promo", "!_WOXa9ZxWfP", "bywsicom_promo");
    if($db->connect_error){
        die("Unable to connect database: " . $db->connect_error);
    }
    
    //get user data from the database
    $query = $db->query("select id,
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
    
    if($query->num_rows > 0){
        $userData = $query->fetch_assoc();
        $data['status'] = 'ok';
        $data['result'] = $userData;
    }else{
        $data['status'] = 'err';
        $data['result'] = '';
    }

	$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
		echo "RESULTADO";
	 echo json_encode($data);
	// echo "403.pHP AQUI SE VE SI SSALE EL ECHOO PRIMERO";
	// echo "<br>";
	// echo "<br>";
	// echo "<br>";
	// echo "JSON SE IMPRIME:";
	// echo "<br>";
	// echo $resultado2;
	// 		echo "<br>";
	// echo json_encode($resultado);
	// print_r($resultado);
	// echo json_encode($resultado);
	// header("Location: calendario.php");

 ?>