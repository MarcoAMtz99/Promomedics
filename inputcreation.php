<?php
include 'core/conex.php';

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

$ID = $_POST['inputID'];
$nombre = $_POST['inputName'];
$apellidos = $_POST['inputLast'];
$paterno = $_POST['inputLast'];
$email = $_POST['inputEmail'];
$cedula = $_POST['inputCedula'];
$tel = $_POST['inputTel'];
$created = date('Y-m-d H:i:s');
$pass = randomString(8);

print_r($_POST);

if(isset($_POST['create'])){
    $disc = "<br><br><br>-------------------------------------<br>";
    $disc .="<small>Este correo fue enviado desde una cuenta no monitoreada. Por favor no respondas este correo.</small>";
    $to = $email;
    $subject = "Bienvenido a Promomedics";
    $body = "Hola ".$nombre."Bienvenido a Promomedics, por favor llena toda tu información correspondiente ingresando a ".URL_ROOT." con tu correo  <br>$email<br>Tu contraseña provisional es <strong>$pass</strong> <br><br>--<br>".PAGE_TITLE;
    $body = $body.$disc;
    $header  = 'MIME-Version: 1.0' . "\r\n";
    $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $header .= "From: ".PAGE_TITLE." <notifica@promomedics.com.mx>\r\n";
    $resultMail = mail($to, $subject, $body, $header);
}


if(isset($_POST['create'])){

    $result = mysql_query("SELECT * FROM medico WHERE num_cedula = '$cedula'", $conn);
    if(!mysql_num_rows($result))
    {
	$result = mysql_query("SELECT * FROM seg_user WHERE email = '$email'", $conn);
	if(!mysql_num_rows($result))
	{
		if(mysql_query("INSERT INTO medico (tipoMedico, nombre, paterno, num_cedula, status) VALUES('AF', '$nombre', '$apellidos', '$cedula', '1')",$conn))
		{
	            $consulta_ultimo_id_medico = mysql_query("SELECT id FROM medico ORDER by id DESC",$conn);
        	    $medico = $consulta_ultimo_id_medico[0]['id'];
	            if(mysql_query("INSERT INTO seg_user (nombre, apellidos, username, password, email, created, status, fk_medico) VALUES('$nombre', '$apellidos', '$email', '$pass', '$email', '$created', '3', '$medico')",$conn))
   		    header("Location: medicos.php");
	            else
			echo "Error en la insercion en tabla de seguridad";
	 	}
	        else
                echo "Error en la insercion en tabla: medico.";
     	}
	else{
        echo "Informaci�n duplicada, favor de confirmar.";
  	}
    }
    else{
        echo "Informaci�n duplicada, favor de confirmar.";
    }
}

if(isset($_POST['activate'])){
    $ID = $_POST['inputID'];
    if(mysql_query($conn, 
    "UPDATE seg_user
    SET status = '1'
    WHERE id_user = '$ID'"))
    header("Location: medicos.php");
    else
    echo "update failed for id: $ID";
}

if(isset($_POST['deny'])){
    if(mysql_query($conn, 
    "UPDATE seg_user
    SET status  = '4'
    WHERE id_user = '$ID'"))
    header("Location: medicos.php");
    else
    echo "update failed for id: $ID";
}

if(isset($_POST['reactivate'])){
    if(mysql_query($conn, 
    "UPDATE seg_user
    SET status  = '3'
    WHERE id_user = '$ID'"))
    header("Location: medicos.php");
    else
    echo "update failed for id: $ID";
}

if(isset($_POST['modify'])){
    echo $ID;
    $ID = $_POST['inputID'];
    $SQLC = "SELECT * FROM seg_user WHERE id_user = '$ID'";
    $resC = mysql_query($SQLC);
    $con = mysql_fetch_assoc($resC);
    /*$pass = $con['password'];
    $disc = "<br><br><br>-------------------------------------<br>";
    $disc .="<small>Este correo fue enviado desde una cuenta no monitoreada. Por favor no respondas este correo.</small>";
    $to = $email;
    $subject = "Bienvenido a Promomedics";
    $body = "Hola ".$nombre."Bienvenido a Promomedics, por favor llena toda tu información correspondiente ingresando a ".URL_ROOT." con tu correo  <br>$email<br>Tu contraseña provisional es <strong>$pass</strong> <br><br>--<br>".PAGE_TITLE;
    $body = $body.$disc;
    $header  = 'MIME-Version: 1.0' . "\r\n";
    $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $header .= "From: ".PAGE_TITLE." <notifica@promomedics.com.mx>\r\n";
    $resultMail = mail($to, $subject, $body, $header);*/

    //header("Location: medico.php?id=$ID");
}

?>