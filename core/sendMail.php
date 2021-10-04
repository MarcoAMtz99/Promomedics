<?php

	require("class.phpmailer.php");
	require("class.smtp.php");

	$to = $data->mail;
    $subject = "Bienvenido a Promomedics";
    $body = "Hola Ivan<br><br>Bienvenido a Promomedics, por favor llena toda tu informaci&oacute;n correspondiente ingresando a http://promomedics.com.mx con tu correo  <br>kbksdgsa<br>Tu contrase&ntilde;a provisional es <strong>$pass</strong> <br><br>--<br>Promomedics";
    
    $res = sendMail('untalivan@isantosp.com', $subject, $body);
    echo $res."\n";


	function sendMail($to, $subject, $body){
		$disc = "<br><br><br>-------------------------------------<br>";
		$disc .="<small>Este correo fue enviado desde una cuenta no monitoreada. Por favor no respondas este correo.</small>";

		//$to = 'isantos@ddsmedia.net';
		//$subject = "Backorders Pendientes";
		$body = $body.$disc;

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		//$mail->SMTPDebug = 2; 
		$mail->Port = 465; 
		$mail->IsHTML(true); 
		$mail->CharSet = "utf-8";
		$mail->SMTPSecure = 'ssl';

		$mail->Host = "mail.promomedics.com.mx"; 
		$mail->Username = "notifica@promomedics.com.mx"; 
		$mail->Password = "jhbkhjbk";

		$mail->FromName = 'Promomedics';
		$mail->From = "notifica@promomedics.com.mx";
		$mail->AddAddress($to);

		$mail->Subject = $subject;
		$mensajeHtml = nl2br($body);
		$mail->Body = "{$mensajeHtml}";
		$mail->AltBody = "{$body}";

		
		if(!$mail->Send())
		{
		  $resultMail = "Mailer Error: " . $mail->ErrorInfo;
		}
		else
		{
		  $resultMail = "Message sent!";
		}

		return $resultMail;
	}

?>