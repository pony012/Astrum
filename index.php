<?php
	//Recibiendo
	//Get query args
	switch($_GET['ctrl']){
		case 'ajusteEntrada':
			//Crear el controlador y ejecutarlo
			require('controllers/ajusteEntradaCtrl.php');
			$ctrl = new AjusteEntradaCtrl();
			break;
		case 'ajusteSalida':
			//Crear el controlador y ejecutarlo
			require('controllers/ajusteSalidaCtrl.php');
			$ctrl = new AjusteSalidaCtrl();
			break;
		case 'consulta':
			//Crear el controlador y ejecutarlo
			require('controllers/consultaCtrl.php');
			$ctrl = new ConsultaCtrl();
			break;
		case 'empleado':
			//Crear el controlador y ejecutarlo
			require('controllers/empleadoCtrl.php');
			$ctrl = new EmpleadoCtrl();
			break;
		case 'producto':
			//Crear el controlador y ejecutarlo
			require('controllers/productoCtrl.php');
			$ctrl = new ProductoCtrl();
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
		case 'remision':
			//Crear el controlador y ejecutarlo
			require('controllers/remisionCtrl.php');
			$ctrl = new RemisionCtrl();
			break;
		case 'servicio':
			//Crear el controlador y ejecutarlo
			require('controllers/servicioCtrl.php');
			$ctrl = new ServicioCtrl();
			break;
		case 'historialMedico':
			//Crear el controlador y ejecutarlo
			require('controllers/historialMedicoCtrl.php');
			$ctrl = new HistorialMedicoCtrl();
			break;
		default:
			# code...
			break;
	}
	$ctrl->run();
?>