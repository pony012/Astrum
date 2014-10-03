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

		private function delete(){

		}

		private function update(){

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
