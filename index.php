<?php
	require_once 'controllers/baseCtrl.php';
	session_start();		
		
	//Recibiendo
	//Get query args
	if (isset($_GET['ctrl'])) {
		switch($_GET['ctrl']){
			case 'loginB':
				BaseCtrl::loadLogin();
				break;
			case 'login':
				BaseCtrl::startSession(isset($_POST['u'])?$_POST['u']:NULL,isset($_POST['p'])?$_POST['p']:NULL);
				break;
			case 'logout':
				BaseCtrl::killSession();
				break;
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
			case 'cliente':
				//Crear el controlador y ejecutarlo
				require('controllers/clienteCtrl.php');
				$ctrl = new ClienteCtrl();
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
			case 'cargo':
				//Crear el controlador y ejecutarlo
				require('controllers/cargoCtrl.php');
				$ctrl = new CargoCtrl();
				break;
			case 'consultaStatus':
				//Crear el controlador y ejecutarlo
				require('controllers/consultaStatusCtrl.php');
				$ctrl = new ConsultaStatusCtrl();
				break;
			case 'existencia':
				//Crear el controlador y ejecutarlo
				require('controllers/existenciaCtrl.php');
				$ctrl = new ExistenciaCtrl();
				break;
			case 'ajusteEntradaTipo':
				//Crear el controlador y ejecutarlo
				require('controllers/ajusteEntradaTipoCtrl.php');
				$ctrl = new AjusteEntradaTipoCtrl();
				break;
			case 'ajusteSalidaTipo':
				//Crear el controlador y ejecutarlo
				require('controllers/ajusteSalidaTipoCtrl.php');
				$ctrl = new AjusteSalidaTipoCtrl();
				break;
			case 'empleadoSueldo':
				//Crear el controlador y ejecutarlo
				require('controllers/empleadoSueldoCtrl.php');
				$ctrl = new EmpleadoSueldoCtrl();
				break;
			case 'movimientoAlmacenTipo':
				//Crear el controlador y ejecutarlo
				require('controllers/movimientoAlmacenTipoCtrl.php');
				$ctrl = new MovimientoAlmacenTipoCtrl();
				break;
			case 'productoServicioTipo':
				//Crear el controlador y ejecutarlo
				require('controllers/productoServicioTipoCtrl.php');
				$ctrl = new ProductoServicioTipoCtrl();
				break;
			default:
				BaseCtrl::loadIndex();
				break;
		}
	}else{
		BaseCtrl::loadIndex();
		//require_once 'views/home.html';
	}
	if (isset($ctrl)) {
		$ctrl->run();
	}
?>