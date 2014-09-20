<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Detalle de Ajuste Salida
	*/
	class AjusteSalidaDetalleCtrl extends baseCtrl
	{
		private $model;

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
		* Crea un Detalle de Ajuste Salida
		*/
		private function create(){
			
			$errors = array();

			$idAjusteSalida 	= $this->validateNumber(isset($_POST['idAjusteSalida'])?$_POST['idAjusteSalida']:NULL);
			$idProductoServicio = $this->validateNumber(isset($_POST['idProductoServicio'])?$_POST['idProductoServicio']:NULL);
			$cantidad			= $this->validateNumber(isset($_POST['cantidad'])?$_POST['cantidad']:NULL);

			if(strlen($idAjusteSalida)==0)
				$errors['idAjusteSalida'] = 1;
			if(strlen($idProductoServicio)==0)
				$errors['idProductoServicio'] = 1;
			if(strlen($cantidad)==0)
				$errors['cantidad'] = 1;

			if (count($errors) == 0) {

				$result = $this->model->create($idAjusteSalida, $idProductoServicio, $cantidad);

				//Si pudo ser creado
				if ($result) {
					//Cargar la vista
					require_once 'views/ajusteSalidaDetalleInserted.php';
				}else{
					require_once 'views/ajusteSalidaDetalleInsertedError.html';
				}
			}else{
				require_once 'views/ajusteSalidaDetalleInsertedError.html';
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
			require_once 'models/ajusteSalidaDetalleMdl.php';
			$this->model = new AjusteSalidaDetalleMdl();
		}
	}
?>