<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Servicio
	*/
	class ServicioCtrl extends BaseCtrl
	{
		/**
		 * Ejecuta acciones basado en la accion seleccionada por los agrumentos
		 */
		public function run()
		{
			switch ($_GET['act']) {
				case 'create':
					//Crear 
					if(BaseCtrl::isAdmin())
						$this->create();
					else
						require_once 'views/permisosError.html';
					break;
				case 'lists':
					//Listar 
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
		* Crea un Servicio
		*/
		private function create(){
			
			$errors = array();

			$idServicioTipo = $this->validateNumber(isset($_POST['idServicioTipo'])?$_POST['idServicioTipo']:NULL);
			$servicio 		= $this->validateText(isset($_POST['servicio'])?$_POST['servicio']:NULL);
			$precioUnitario	= $this->validateNumber(isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
			$foto 			= $this->validateText(isset($_POST['foto'])?$_POST['foto']:NULL);
			$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

			if(strlen($idServicioTipo)==0)
				$errors['idServicioTipo'] = 1;
			if(strlen($servicio)==0)
				$errors['servicio'] = 1;
			if(strlen($precioUnitario)==0)
				$errors['precioUnitario'] = 1;
			if(strlen($foto)==0)
				$errors['foto'] = 1;
			if(strlen($descripcion)==0)
				$errors['descripcion'] = 1;

			if (count($errors) == 0) {

				$result = $this->model->create($idServicioTipo, $servicio, $precioUnitario, $foto, $descripcion);

				//Si pudo ser creado
				if ($result) {
					$data = array($idServicioTipo, $servicio, $precioUnitario, $foto, $descripcion);
					//Cargar la vista
					require_once 'views/servicioInserted.php';
				}else{
					require_once 'views/servicioInsertedError.html';
				}
			}else{
				require_once 'views/servicioInsertedError.html';
			}
		}

		private function read(){

		}

		/**
		*Da de baja a un determinado servicio
		**/
		private function delete(){
			$idServicio	= $this->validateNumber(isset($_POST['idServicio'])?$_POST['idServicio']:NULL);
			if(strlen($idServicio)==0)
				require_once 'views/servicioDeleteError.html';
			else{
				if($result = $this->model->delete($idServicio))
					require_once 'views/servicioDelete.html';
				else
					require_once 'views/servicioDeleteError.html';
			}
		}

		/**
		*Activa a un determinado servicio
		**/
		private function active(){
			$idServicio	= $this->validateNumber(isset($_POST['idServicio'])?$_POST['idServicio']:NULL);
			if(strlen($idServicio)==0)
				require_once 'views/servicioActiveError.html';
			else{
				if($result = $this->model->active($idServicio))
					require_once 'views/servicioActive.html';
				else
					require_once 'views/servicioActiveError.html';
			}
		}

		private function update(){
			$errors = array();

			$idServicio 	= $this->validateNumber(isset($_POST['idServicio'])?$_POST['idServicio']:NULL);
			$idServicioTipo = $this->validateNumber(isset($_POST['idServicioTipo'])?$_POST['idServicioTipo']:NULL);
			$servicio 		= $this->validateText(isset($_POST['servicio'])?$_POST['servicio']:NULL);
			$precioUnitario	= $this->validateNumber(isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
			$foto 			= $this->validateText(isset($_POST['foto'])?$_POST['foto']:NULL);
			$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

			if(strlen($idServicio)==0)
				$errors['idServicio'] = 1;
			if(strlen($idServicioTipo)==0)
				$errors['idServicioTipo'] = 1;
			if(strlen($servicio)==0)
				$errors['servicio'] = 1;
			if(strlen($precioUnitario)==0)
				$errors['precioUnitario'] = 1;
			if(strlen($foto)==0)
				$errors['foto'] = 1;
			if(strlen($descripcion)==0)
				$errors['descripcion'] = 1;

			if (count($errors) == 0) {

				$result = $this->model->update($idServicio,$idServicioTipo, $servicio, $precioUnitario, $foto, $descripcion);

				//Si pudo ser creado
				if ($result) {
					$data = array($idServicioTipo, $servicio, $precioUnitario, $foto, $descripcion);
					//Cargar la vista
					require_once 'views/servicioUpdated.php';
				}else{
					require_once 'views/servicioUpdatedError.html';
				}
			}else{
				require_once 'views/servicioUpdatedError.html';
			}
		}

		/**
		*Listamos todos los servicios registrados
		**/
		private function lists(){
			if($result = $this->model->lists()){

				$data = array($result);

				require_once 'views/servicioSelected.php';
				
			}else
				require_once 'views/servicioSelectedError.html';
		}

		function __construct(){
			require_once 'models/servicioMdl.php';
			$this->model = new ServicioMdl();
		}
	}
?>
