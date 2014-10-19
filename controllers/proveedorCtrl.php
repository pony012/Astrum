<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Proveedor
	*/
	class ProveedorCtrl extends BaseCtrl
	{
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
				case 'lists':
					//Listar Proveedores
					$this->lists();
					break;
				case 'delete':
					//Baja
					if(BaseCtrl::isAdmin())
						$this->delete();
					else
						require_once 'views/permisosError.html';
					break;
				case 'update':
					//Baja
					if(BaseCtrl::isAdmin())
						$this->update();
					else
						require_once 'views/permisosError.html';
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
					//Guardamos los campos en un arreglo
					$data = array(	$nombre, 
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

		/**
		*Da de baja a un determinado proveedor
		**/
		private function delete(){
			$idProveedor	= $this->validateNumber(isset($_POST['idProveedor'])?$_POST['idProveedor']:NULL);
			if(strlen($idProveedor)==0)
				require_once 'views/proveedorDeleteError.html';
			else{
				if($result = $this->model->delete($idProveedor))
					require_once 'views/proveedorDelete.html';
				else
					require_once 'views/proveedorDeleteError.html';
			}
		}

		/**
		*Activa a un determinado proveedor
		**/
		private function active(){
			$idProveedor	= $this->validateNumber(isset($_POST['idProveedor'])?$_POST['idProveedor']:NULL);
			if(strlen($idProveedor)==0)
				require_once 'views/proveedorActiveError.html';
			else{
				if($result = $this->model->active($idProveedor))
					require_once 'views/proveedorActive.html';
				else
					require_once 'views/proveedorActiveError.html';
			}
		}

		private function update(){
			$errors = array();

			$idProveedor		= $this->validateNumber(isset($_POST['idProveedor'])?$_POST['idProveedor']:NULL);
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

			if(strlen($idProveedor)==0)
				$errors['idProveedor'] = 1;
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
				$result = $this->model->update(	$idProveedor,$nombre, 
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
				//Si pudo ser actualizado
				if ($result) {
					//Guardamos los campos en un arreglo
					$data = array(	$nombre, 
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
					//Cargar la vista
					require_once 'views/proveedorUpdated.php';
				}else{
					require_once 'views/proveedorUpdatedError.html';
				}
			}else{
				require_once 'views/proveedorUpdatedError.html';
			}
		}

		/**
		*Listamos todos los Proveedores registrados
		**/
		private function lists(){
			if($result = $this->model->lists()){

				$data = array($result);

				require_once 'views/proveedorSelected.php';
				
			}else
				require_once 'views/proveedorSelectedError.html';
		}

		function __construct(){
			require_once 'models/proveedorMdl.php';
			$this->model = new ProveedorMdl();
		}
	}
?>
