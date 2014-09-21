<?php
	//Recibiendo
	//Get query args
	switch($_GET['ctrl']){
		case 'empleado':
			//Crear el controlador y ejecutarlo
			require('controllers/empleadoCtrl.php');
			$ctrl = new EmpleadoCtrl();
			break;
		default:
	}
	$ctrl->run();

?>