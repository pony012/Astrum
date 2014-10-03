<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Producto
	*/
	class ProductoCtrl extends BaseCtrl
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

			$idProductoTipo = $this->validateNumber(isset($_POST['idProductoTipo'])?$_POST['idProductoTipo']:NULL);
			$producto 		= $this->validateText(isset($_POST['producto'])?$_POST['producto']:NULL);
			$precioUnitario	= $this->validateNumber(isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
			$foto 			= $this->validateText(isset($_POST['foto'])?$_POST['foto']:NULL);
			$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

			if(strlen($idProductoTipo)==0)
				$errors['idProductoTipo'] = 1;
			if(strlen($producto)==0)
				$errors['producto'] = 1;
			if(strlen($precioUnitario)==0)
				$errors['precioUnitario'] = 1;
			if(strlen($foto)==0)
				$errors['foto'] = 1;
			if(strlen($descripcion)==0)
				$errors['descripcion'] = 1;

			if (count($errors) == 0) {

				$result = $this->model->create($idProductoTipo, $producto, $precioUnitario, $foto, $descripcion);

				//Si pudo ser creado
				if ($result) {
					$data = array($idProductoTipo, $producto, $precioUnitario, $foto, $descripcion);
					//Cargar la vista
					require_once 'views/productoInserted.php';
				}else{
					require_once 'views/productoInsertedError.html';
				}
			}else{
				require_once 'views/productoInsertedError.html';
			}
		}

		private function read(){

		}

		private function delete(){

		}

		private function update(){

		}

		/**
		*Listamos todos los productos registrados
		**/
		private function lists(){
			if($result = $this->model->lists()){

				$data = array($result);

				require_once 'views/productoSelected.php';
				
			}else
				require_once 'views/productoSelectedError.html';
		}

		function __construct(){
			require_once 'models/productoMdl.php';
			$this->model = new ProductoMdl();
		}
	}
?>
