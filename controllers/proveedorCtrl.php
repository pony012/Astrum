<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Proveedor
	*/
	class ProveedorCtrl extends baseCtrl
	{
		private $model;

		/**
		 * Ejecuta acciones basado en la accion seleccionada por los agrumentos
		 */
		public function run()
		{
			switch ($_GET['act']) {
				case 'create':
					//Crear proveedor
					$this->create();
					break;
				
				default:
					# code...
					break;
			}
		}
		/**
		* Crea un proveedor
		*/
		private function create(){
			
			$errors = array();

			$nombre 			= $this->validateName(isset($_POST['nombre'])?$_POST['nombre']:NULL);
			$apellidoPaterno 	= $this->validateName(isset($_POST['apellidoPaterno'])?$_POST['apellidoPaterno']:NULL);
			$apellidoMaterno	= $this->validateName(isset($_POST['apellidoMaterno'])?$_POST['apellidoMaterno']:NULL);
			$RFC				= $this->validateText(isset($_POST['RFC'])?$_POST['RFC']:NULL);
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
			if(strlen($RFC)==0)
				$errors['RFC'] = 1;
			if(strlen($calle)==0)
				$errors['calle'] = 1;
			if(strlen($colonia)==0)
				$errors['colonia'] = 1;
			if(strlen($codigoPostal)==0)
				$errors['codigoPostal'] = 1;

			if (count($errors) == 0) {
				$result = $this->model->create(	$nombre, 
											$apellidoPaterno, 
											$apellidoMaterno,
											$RFC,
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
					//Cargar la vista
					require_once 'views/proveedorInserted.php';
				}else{
					require_once 'views/proveedorInsertedError.html';
				}
			}else{
				require_once 'views/proveedorInsertedError.html';
			}
		}

		private function read(){

		}

		private function delete(){

		}

		private function update(){

		}

		private function list(){

		}

		function __construct(){
			require_once 'models/proveedorMdl.php';
			$this->model = new ProveedorMdl();
		}
	}
?>