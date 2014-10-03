<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Cliente
	*/
	class ClienteCtrl extends BaseCtrl
	{
		/**
		 * Ejecuta acciones basado en la accion seleccionada por los agrumentos
		 */
		public function run()
		{
			switch ($_GET['act']) {
				case 'create':
					//Crear un Cliente
					$this->create();
					break;
				case 'lists':
					//Listar
					$this->lists();
					break;
				default:
					# code...
					break;
			}
		}
		/**
		* Crea un Cliente
		*/
		private function create(){
			
			$errors = array();

			$nombre 			= $this->validateName(isset($_POST['nombre'])?$_POST['nombre']:NULL);
			$apellidoPaterno 	= $this->validateName(isset($_POST['apellidoPaterno'])?$_POST['apellidoPaterno']:NULL);
			$apellidoMaterno	= $this->validateName(isset($_POST['apellidoMaterno'])?$_POST['apellidoMaterno']:NULL);
			$calle				= $this->validateText(isset($_POST['calle'])?$_POST['calle']:NULL);
			$numExterior		= $this->validateText(isset($_POST['numExterior'])?$_POST['numExterior']:NULL);
			$numInterior		= $this->validateText(isset($_POST['numInterior'])?$_POST['numInterior']:NULL);
			$colonia			= $this->validateText(isset($_POST['colonia'])?$_POST['colonia']:NULL);
			$codigoPostal		= $this->validateNumber(isset($_POST['codigoPostal'])?$_POST['codigoPostal']:NULL);
			$email				= $this->validateEmail(isset($_POST['email'])?$_POST['email']:NULL);
			$telefono			= $this->validatePhone(isset($_POST['telefono'])?$_POST['telefono']:NULL);
			$celular			= $this->validatePhone(isset($_POST['celular'])?$_POST['celular']:NULL);

			if(strlen($nombre)==0)
				$errors['nombre'] = 1;
			if(strlen($apellidoPaterno)==0)
				$errors['apellidoPaterno'] = 1;
			if(strlen($apellidoMaterno)==0)
				$errors['apellidoMaterno'] = 1;
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
											$calle,
											$numExterior,
											$numInterior,
											$colonia,
											$codigoPostal,
											$email,
											$telefono,
											$celular);

				//Si pudo ser creado
				if ($result) {
					$data = array(	$nombre, 
									$apellidoPaterno, 
									$apellidoMaterno,
									$calle,
									$numExterior,
									$numInterior,
									$colonia,
									$codigoPostal,
									$email,
									$telefono,
									$celular);
					//Cargar la vista
					require_once 'views/clienteInserted.php';
				}else{
					require_once 'views/clienteInsertedError.html';
				}	
			}else{
				//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
				require_once 'views/clienteInsertedError.html';
			}
		}

		private function read(){

		}

		private function delete(){

		}

		private function update(){

		}

		/**
		*Listamos todos los Clientes
		**/
		private function lists(){
			if($result = $this->model->lists()){

				$data = array($result);

				require_once 'views/clienteSelected.php';
				
			}else
				require_once 'views/clienteSelectedError.html';
		}

		function __construct(){
			require_once 'models/clienteMdl.php';
			$this->model = new ClienteMdl();
		}
	}
?>
