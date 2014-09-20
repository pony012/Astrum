<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Repecion
	*/
	class RecepcionCtrl extends baseCtrl
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
		* Crea una Repecion
		*/
		private function create(){
			
			$errors = array();

			$idMovimientoAlmacen 	= $this->validateNumber(isset($_POST['idMovimientoAlmacen'])?$_POST['idMovimientoAlmacen']:NULL);
			$idProveedor 			= $this->validateNumber(isset($_POST['idProveedor'])?$_POST['idProveedor']:NULL);
			$folio					= $this->validateNumber(isset($_POST['folio'])?$_POST['folio']:NULL);
			$fechaRecepcion 		= $this->validateDate(isset($_POST['fechaRecepcion'])?$_POST['fechaRecepcion']:NULL);
			$total 					= $this->validateNumber(isset($_POST['total'])?$_POST['total']:NULL);
			
			if(strlen($idMovimientoAlmacen)==0)
				$errors['idMovimientoAlmacen'] = 1;
			if(strlen($idProveedor)==0)
				$errors['idProveedor'] = 1;
			if(strlen($folio)==0)
				$errors['folio'] = 1;
			if(strlen($fechaRecepcion)==0)
				$errors['fechaRecepcion'] = 1;
			if(strlen($total)==0)
				$errors['total'] = 1;

			if (count($errors) == 0) {

				$result = $this->model->create($idMovimientoAlmacen, $idProveedor, $folio, $fechaRecepcion, $total);

				//Si pudo ser creado
				if ($result) {
					//Cargar la vista
					require_once 'views/recepcionInserted.php';
				}else{
					require_once 'views/recepcionInsertedError.html';
				}
			}else{
				require_once 'views/recepcionInsertedError.html';
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
			require_once 'models/recepcionMdl.php';
			$this->model = new RecepcionMdl();
		}
	}
?>