<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Detalle de Ajuste Entrada
	*/
	class AjusteEntradaDetalleCtrl extends baseCtrl
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
		* Crea un Detalle de Ajuste Entrada
		*/
		private function create(){
			
			$errors = array();

			$idProductoServicio = $this->validateNumber(isset($_POST['idProductoServicio'])?$_POST['idProductoServicio']:NULL);
			$cantidad			= $this->validateNumber(isset($_POST['cantidad'])?$_POST['cantidad']:NULL);

			if(strlen($idProductoServicio)==0)
				$errors['idProductoServicio'] = 1;
			if(strlen($cantidad)==0)
				$errors['cantidad'] = 1;

			if (count($errors) == 0) {

				$result = $this->model->create($idProductoServicio, $cantidad);

				//Si pudo ser creado
				if ($result) {
					//Cargar la vista
					require_once 'views/ajusteEntradaDetalleInserted.php';
				}else{
					require_once 'views/ajusteEntradaDetalleInsertedError.html';
				}
			}else{
				require_once 'views/ajusteEntradaDetalleInsertedError.html';
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
			require_once 'models/ajusteEntradaDetalleMdl.php';
			$this->model = new AjusteEntradaDetalleMdl();
		}
	}
?>