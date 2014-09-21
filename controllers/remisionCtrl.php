<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Remision
	*/
	class RemisionCtrl extends BaseCtrl
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
		* Crea una Remision
		*/
		private function create(){
			
			$errors = array();
			
			$idCliente	= $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
			$folio			= $this->validateNumber(isset($_POST['folio'])?$_POST['folio']:NULL);
			$fechaRemision	= $this->validateDate(isset($_POST['fechaRemision'])?$_POST['fechaRemision']:NULL);
			$idProductos 	= (isset($_POST['idProductos'])?$_POST['idProductos']:NULL);
			$cantidades		= (isset($_POST['cantidades'])?$_POST['cantidades']:NULL);
			$precioUnitario	= (isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
			$ivas 			= (isset($_POST['ivas'])?$_POST['ivas']:NULL);
			$descuentos 	= (isset($_POST['descuentos'])?$_POST['descuentos']:NULL);
			
			if(strlen($idCliente)==0)
				$errors['idCliente'] = 1;
			if(strlen($folio)==0)
				$errors['folio'] = 1;
			if(strlen($fechaRemision)==0)
				$errors['fechaRemision'] = 1;
			if(count($this->validateNumericArrays($cantidades)) != 0)
				$errors['cantidades'] = 1;
			if(count($this->validateNumericArrays($ivas)) != 0)
				$errors['ivas'] = 1;
			if(count($this->validateNumericArrays($descuentos)) != 0)
				$errors['descuentos'] = 1;
			
			if (count($errors) == 0) {
				
				$result = $this->model->create($idCliente, $folio, $fechaRemision,$idProductos,$cantidades,$precioUnitario,$ivas,$descuentos);

				//Si pudo ser creado
				if ($result) {
					//Guardamos los campos en un arreglo
					$data = array($idCliente, $folio, $fechaRemision,$idProductos,$cantidades,$precioUnitario,$ivas,$descuentos);
					//Cargar la vista
					require_once 'views/remisionInserted.php';
				}else{
					require_once 'views/remisionInsertedError.html';
				}
			}else{

				require_once 'views/remisionInsertedError.html';
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
			require_once 'models/remisionMdl.php';
			$this->model = new RemisionMdl();
		}
	}
?>
