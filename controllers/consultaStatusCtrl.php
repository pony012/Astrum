<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Producto
	*/
	class ConsultaStatusCtrl extends BaseCtrl
	{
		/**
		 * Ejecuta acciones basado en la accion seleccionada por los agrumentos
		 */
		public function run()
		{
			if(BaseCtrl::isAdmin())
				switch ($_GET['act']) {
					case 'create':
						//Crear 
						$this->create();
						break;
					case 'update':
						//Baja
						$this->update();
						break;
					default:
						# code...
						break;
				}
			else
				require_once 'views/permisosError.html';
		}
		/**
		* Crea un Producto
		*/
		private function create(){
			
			$errors = array();

			$status		    = $this->validateText(isset($_POST['status'])?$_POST['status']:NULL);
			$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

			if(strlen($status)==0)
				$errors['status'] = 1;
			if(strlen($descripcion)==0)
				$errors['descripcion'] = 1;
			
			if (count($errors) == 0){

				$result = $this->model->create($status, $descripcion);

				//Si pudo ser creado
				if ($result) {
					$data = array($status, $descripcion);
					//Cargar la vista
					require_once 'views/consultaStatusInserted.php';
				}else{
					require_once 'views/consultaStatusInsertedError.html';
				}
			}else{
				require_once 'views/consultaStatusInsertedError.html';
			}
		}

		private function read(){

		}

		private function delete(){

		}

		private function update(){
			$errors = array();

			$idConsultaStatus=$this->validateNumber(isset($_POST['idConsultaStatus'])?$_POST['idConsultaStatus']:NULL);
			$status		    = $this->validateText(isset($_POST['status'])?$_POST['status']:NULL);
			$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

			if(strlen($idConsultaStatus)==0)
				$errors['idConsultaStatus'] = 1;
			if(strlen($status)==0)
				$errors['status'] = 1;
			if(strlen($descripcion)==0)
				$errors['descripcion'] = 1;
			
			if (count($errors) == 0){

				$result = $this->model->update($idConsultaStatus,$status, $descripcion);

				//Si pudo ser creado
				if ($result) {
					$data = array($status, $descripcion);
					//Cargar la vista
					require_once 'views/consultaStatusUpdated.php';
				}else{
					require_once 'views/consultaStatusUpdatedError.html';
				}
			}else{
				require_once 'views/consultaStatusUpdatedError.html';
			}
		}

		private function lists(){

		}

		function __construct(){
			require_once 'models/consultaStatusMdl.php';
			$this->model = new ConsultaStatusMdl();
		}
	}
?>