<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Producto
	*/
	class CargoCtrl extends BaseCtrl
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

			$cargo		    = $this->validateText(isset($_POST['cargo'])?$_POST['cargo']:NULL);
			$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

			if(strlen($cargo)==0)
				$errors['cargo'] = 1;
			if(strlen($descripcion)==0)
				$errors['descripcion'] = 1;
			
			if (count($errors) == 0){

				$result = $this->model->create($cargo, $descripcion);

				//Si pudo ser creado
				if ($result) {
					$data = array($cargo, $descripcion);
					//Cargar la vista
					require_once 'views/cargoInserted.php';
				}else{
					require_once 'views/cargoInsertedError.html';
				}
			}else{
				require_once 'views/cargoInsertedError.html';
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
			require_once 'models/cargoMdl.php';
			$this->model = new CargoMdl();
		}
	}
?>