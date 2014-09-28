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
			switch ($_GET['act']) {
				case 'create':
					//Crear 
					$this->create();
					break;
				
				default:
					# code...
					break;
			}
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

		}

		private function lists(){

		}

		function __construct(){
			require_once 'models/consultaStatusMdl.php';
			$this->model = new ConsultaStatusMdl();
		}
	}
?>