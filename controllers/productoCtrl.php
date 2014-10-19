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
					if(BaseCtrl::isAdmin()) 
						$this->create();
					else
						require_once 'views/permisosError.html';
					break;
				case 'lists':
					//Listar 
					$this->lists();
					break;
				case 'delete':
					//Baja 
					if(BaseCtrl::isAdmin())
						$this->delete();
					else
						require_once 'views/permisosError.html';
					break;
				case 'update':
					//Baja
					if(BaseCtrl::isAdmin)
						$this->update();
					else
						require_once 'views/permisosError.html';
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

		/**
		*Da de baja a un determinado producto
		**/
		private function delete(){
			$idProducto	= $this->validateNumber(isset($_POST['idProducto'])?$_POST['idProducto']:NULL);
			if(strlen($idProducto)==0)
				require_once 'views/productoDeleteError.html';
			else{
				if($result = $this->model->delete($idProducto))
					require_once 'views/productoDelete.html';
				else
					require_once 'views/productoDeleteError.html';
			}
		}

		/**
		*Activa a un determinado producto
		**/
		private function active(){
			$idProducto	= $this->validateNumber(isset($_POST['idProducto'])?$_POST['idProducto']:NULL);
			if(strlen($idProducto)==0)
				require_once 'views/productoActiveError.html';
			else{
				if($result = $this->model->active($idProducto))
					require_once 'views/productoActive.html';
				else
					require_once 'views/productoActiveError.html';
			}
		}

		private function update(){
			$errors = array();

			$idProducto 	= $this->validateNumber(isset($_POST['idProducto'])?$_POST['idProducto']:NULL);
			$idProductoTipo = $this->validateNumber(isset($_POST['idProductoTipo'])?$_POST['idProductoTipo']:NULL);
			$producto 		= $this->validateText(isset($_POST['producto'])?$_POST['producto']:NULL);
			$precioUnitario	= $this->validateNumber(isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
			$foto 			= $this->validateText(isset($_POST['foto'])?$_POST['foto']:NULL);
			$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

			if(strlen($idProducto)==0)
				$errors['idProducto'] = 1;
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

				$result = $this->model->update($idProducto,$idProductoTipo, $producto, $precioUnitario, $foto, $descripcion);

				//Si pudo ser creado
				if ($result) {
					$data = array($idProductoTipo, $producto, $precioUnitario, $foto, $descripcion);
					//Cargar la vista
					require_once 'views/productoUpdated.php';
				}else{
					require_once 'views/productoUpdatedError.html';
				}
			}else{
				require_once 'views/productoUpdatedError.html';
			}
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
