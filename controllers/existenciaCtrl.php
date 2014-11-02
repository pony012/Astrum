<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Producto
	*/
	class ExistenciaCtrl extends BaseCtrl
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
		* Crea un Producto
		*/
		private function create(){
			
			$errors = array();

			$fechaReferencia	= $this->validateText(isset($_POST['fechaReferencia'])?$_POST['fechaReferencia']:NULL);
			$idProductoServicio = $this->validateNumber(isset($_POST['idProductoServicio'])?$_POST['idProductoServicio']:NULL);
			$precioUnitario 	= $this->validateNumber(isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
			$cantidad 			= $this->validateNumber(isset($_POST['cantidad'])?$_POST['cantidad']:NULL);

			if(strlen($fechaReferencia)==0)
				$errors['fechaReferencia'] = 1;
			if(strlen($idProductoServicio)==0)
				$errors['idProductoServicio'] = 1;
			if(strlen($precioUnitario)==0)
				$errors['precioUnitario'] = 1;
			if(strlen($cantidad)==0)
				$errors['cantidad'] = 1;
			
			if (count($errors) == 0){

				$result = $this->model->create($fechaReferencia, $idProductoServicio,$precioUnitario,$precioUnitario,$cantidad);

				//Si pudo ser creado
				if ($result) {
					$data = array($fechaReferencia, $idProductoServicio,$precioUnitario,$precioUnitario,$cantidad);
					//Cargar la vista
					require_once 'views/existenciaInserted.php';
				}else{
					require_once 'views/existenciaInsertedError.html';
				}
			}else{
				require_once 'views/existenciaInsertedError.html';
			}
		}

		private function read(){

		}

		private function delete(){

		}

		private function update(){

		}

		/**
		*Listamos todas las Existencias de productos registrados
		**/
		private function lists(){
			if($result = $this->model->lists()){

				$data = array($result);

				require_once 'views/existenciaSelected.php';
				
			}else
				require_once 'views/existenciaSelectedError.html';
		}

		function __construct(){
			parent::__construct();
			require_once 'models/consultaStatusMdl.php';
			$this->model = new ConsultaStatusMdl();
		}
	}
?>