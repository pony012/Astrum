<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador Detalle de Recepción
	*/
	class RecepcionDetalleCtrl extends baseCtrl
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
		* Crea Detalle de Recepción
		*/
		private function create(){
			
			$errors = array();

			$idProducto 	= $this->validateNumber(isset($_POST['idProducto'])?$_POST['idProducto']:NULL);
			$cantidad 		= $this->validateNumber(isset($_POST['cantidad'])?$_POST['cantidad']:NULL);
			$precioUnitario	= $this->validateNumber(isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
			$iva 			= $this->validateNumber(isset($_POST['iva'])?$_POST['iva']:NULL);
			$descuento 		= $this->validateNumber(isset($_POST['descuento'])?$_POST['descuento']:NULL);

			if(strlen($idProducto)==0)
				$errors['idProducto'] = 1;
			if(strlen($cantidad)==0)
				$errors['cantidad'] = 1;
			if(strlen($precioUnitario)==0)
				$errors['precioUnitario'] = 1;
			if(strlen($iva)==0)
				$errors['iva'] = 1;
			
			if (count($errors) == 0) {

				$result = $this->model->create($idProducto, $cantidad, $precioUnitario, $iva, $descuento);

				//Si pudo ser creado
				if ($result) {
					//Cargar la vista
					require_once 'views/recepcionDetalleInserted.php';
				}else{
					require_once 'views/recepcionDetalleInsertedError.html';
				}
			}else{
				require_once 'views/recepcionDetalleInsertedError.html';
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
			require_once 'models/recepcionDetalleMdl.php';
			$this->model = new RecepcionDetalleMdl();
		}
	}
?>