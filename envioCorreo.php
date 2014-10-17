<?php	

	//$remplazos=array($@Nombre_Variable@$ => $variable)
	//$body = ruta del archivo
	function enviarCorreo($correo,$asunto,$body,$remplazos){
		require_once 'PHPMailer/PHPMailerAutoload.php';

		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		
		$mail->Host = "mail.astrum.x10.mx";
		$mail->Port = 25;
		$mail->SMTPAuth = true;
		$mail->Username = "contacto@astrum.x10.mx";
		$mail->Password = "astrum1234";
		
		$mail->setFrom('contacto@astrum.x10.mx', 'SpaDamaris');	
		$mail->addAddress($correo);

		$mail->Subject = 'SpaDamaris: '.$asunto;
		$lineas = file($body);
		$mensaje = '';
		foreach ($lineas as $value) {
			$mensaje.=strtr($value,$remplazos);
		}
		$mail->msgHTML($mensaje);
		
		
		if (!$mail->send()) {
		    return false;
		} else {
		    return true;
		}
	}
?>