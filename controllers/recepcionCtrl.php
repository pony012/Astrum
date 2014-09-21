<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Repecion
	*/
	class RecepcionCtrl extends BaseCtrl
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
		* Crea una Repecion
		*/
		private function create(){
			
			$errors = array();
			
			$idProveedor	= $this->validateNumber(isset($_POST['idProveedor'])?$_POST['idProveedor']:NULL);
			$folio			= $this->validateNumber(isset($_POST['folio'])?$_POST['folio']:NULL);
			$fechaRecepcion	= $this->validateDate(isset($_POST['fechaRecepcion'])?$_POST['fechaRecepcion']:NULL);
			$idProductos 	= (isset($_POST['idProductos'])?$_POST['idProductos']:NULL);
			$cantidades		= (isset($_POST['cantidades'])?$_POST['cantidades']:NULL);
			$precioUnitario	= (isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
			$ivas 			= (isset($_POST['ivas'])?$_POST['ivas']:NULL);
			$descuentos 	= (isset($_POST['descuentos'])?$_POST['descuentos']:NULL);
			
			if(strlen($idProveedor)==0)
				$errors['idProveedor'] = 1;
			if(strlen($folio)==0)
				$errors['folio'] = 1;
			if(strlen($fechaRecepcion)==0)
				$errors['fechaRecepcion'] = 1;
			if(count($this->validateNumericArrays($cantidades)) != 0)
				$errors['cantidades'] = 1;
			if(count($this->validateNumericArrays($ivas)) != 0)
				$errors['ivas'] = 1;
			if(count($this->validateNumericArrays($descuentos)) != 0)
				$errors['descuentos'] = 1;
			
			if (count($errors) == 0) {
				
				$result = $this->model->create($idProveedor, $folio, $fechaRecepcion,$idProductos,$cantidades,$precioUnitario,$ivas,$descuentos);

				//Si pudo ser creado
				if ($result) {
					//Guardamos los campos en un arreglo
					$data = array($idProveedor, $folio, $fechaRecepcion,$idProductos,$cantidades,$precioUnitario,$ivas,$descuentos);
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

		private function lists(){

		}

		function __construct(){
			require_once 'models/recepcionMdl.php';
			$this->model = new RecepcionMdl();
		}
	}
?>