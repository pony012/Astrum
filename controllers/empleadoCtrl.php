<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Empleado
	*/
	class EmpleadoCtrl extends BaseCtrl
	{
		/**
		 * Ejecuta acciones basado en la accion seleccionada por los agrumentos
		 */
		public function run()
		{
			switch ($_GET['act']) {
				case 'create':
					//Crear un Empleado
					$this->create();
					break;
				
				case 'lists':
					$this->lists();
					break;

				default:
					# code...
					break;
			}
		}
		/**
		* Crea un Empleado
		*/
		private function create(){
			
			$errors = array();

			$nombre 			= $this->validateName(isset($_POST['nombre'])?$_POST['nombre']:NULL);
			$apellidoPaterno 	= $this->validateName(isset($_POST['apellidoPaterno'])?$_POST['apellidoPaterno']:NULL);
			$apellidoMaterno	= $this->validateName(isset($_POST['apellidoMaterno'])?$_POST['apellidoMaterno']:NULL);
			$usuario			= $this->validateText(isset($_POST['usuario'])?$_POST['usuario']:NULL);
			$contrasena			= $this->validateText(isset($_POST['contrasena'])?$_POST['contrasena']:NULL);
			$idCargo			= $this->validateNumber(isset($_POST['idCargo'])?$_POST['idCargo']:NULL);
			$calle				= $this->validateText(isset($_POST['calle'])?$_POST['calle']:NULL);
			$numExterior		= $this->validateText(isset($_POST['numExterior'])?$_POST['numExterior']:NULL);
			$numInterior		= $this->validateText(isset($_POST['numInterior'])?$_POST['numInterior']:NULL);
			$colonia			= $this->validateText(isset($_POST['colonia'])?$_POST['colonia']:NULL);
			$codigoPostal		= $this->validateNumber(isset($_POST['codigoPostal'])?$_POST['codigoPostal']:NULL);
			$foto				= $this->validateText(isset($_POST['foto'])?$_POST['foto']:NULL);
			$email				= $this->validateEmail(isset($_POST['email'])?$_POST['email']:NULL);
			$telefono			= $this->validatePhone(isset($_POST['telefono'])?$_POST['telefono']:NULL);
			$celular			= $this->validatePhone(isset($_POST['celular'])?$_POST['celular']:NULL);

			if(strlen($nombre)==0)
				$errors['nombre'] = 1;
			if(strlen($apellidoPaterno)==0)
				$errors['apellidoPaterno'] = 1;
			if(strlen($apellidoMaterno)==0)
				$errors['apellidoMaterno'] = 1;
			if(strlen($usuario)==0)
				$errors['usuario'] = 1;
			if(strlen($contrasena)==0)
				$errors['contrasena'] = 1;
			if(strlen($idCargo)==0)
				$errors['idCargo'] = 1;
			if(strlen($calle)==0)
				$errors['calle'] = 1;
			if(strlen($numExterior)==0)
				$errors['numExterior'] = 1;
			if(strlen($colonia)==0)
				$errors['colonia'] = 1;
			if(strlen($codigoPostal)==0)
				$errors['codigoPostal'] = 1;

			
			if (count($errors) == 0) {
				$result = $this->model->create(	$nombre, 
											$apellidoPaterno, 
											$apellidoMaterno,
											$usuario,
											$contrasena,
											$idCargo,
											$calle,
											$numExterior,
											$numInterior,
											$colonia,
											$codigoPostal,
											$foto,
											$email,
											$telefono,
											$celular);

				//Si pudo ser creado
				if ($result) {
					$data = array(	$nombre, 
									$apellidoPaterno, 
									$apellidoMaterno,
									$usuario,
									$contrasena,
									$idCargo,
									$calle,
									$numExterior,
									$numInterior,
									$colonia,
									$codigoPostal,
									$foto,
									$email,
									$telefono,
									$celular);
					//Cargar la vista
					require_once 'views/empleadoInserted.php';
				}else{
					require_once 'views/empleadoInsertedError.html';
				}	
			}else{
				//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
				require_once 'views/empleadoInsertedError.html';
			}
		}

		private function read(){

		}

		private function delete(){

		}

		private function update(){

		}

		/**
		*listamos todos de los empleados
		**/
		private function lists(){
			if($result = $this->model->lists()){

				$data = array($result);

				require_once 'views/empleadoSelected.php';
				
			}else
				require_once 'views/empleadoSelectedError.php';
		}

		function __construct(){
			require_once 'models/empleadoMdl.php';
			$this->model = new EmpleadoMdl();
		}
	}
?>
