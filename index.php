<?php
	//Recibiendo
	//Get query args
	switch($_GET['ctrl']){
		case 'empleado':
			//Crear el controlador y ejecutarlo
			require('controllers/empleadoCtrl.php');
			$ctrl = new EmpleadoCtrl();
			break;
		case 'proveedor':
			//Crear el controlador y ejecutarlo
			require('controllers/proveedorCtrl.php');
			$ctrl = new ProveedorCtrl();
			break;
		case 'recepcion':
			//Crear el controlador y ejecutarlo
			require('controllers/recepcionCtrl.php');
			$ctrl = new RecepcionCtrl();
			break;
		default:
			# code...
			break;
	}
	$ctrl->run();
?>