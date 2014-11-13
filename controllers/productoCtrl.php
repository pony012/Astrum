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
						return json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
					break;
				case 'createF':
					//Crear
					if(BaseCtrl::isAdmin())
						$this->createF();
					else
						return json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
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
						return json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
					break;
				case 'update':
					//Baja
					if(BaseCtrl::isAdmin)
						$this->update();
					else
						return json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
					break;
				case 'updateF':
					//Baja
					if(BaseCtrl::isAdmin)
						$this->updateF();
					else
						return json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
					break;
				case 'get':
					//Obtener un Producto
					$this->getProducto();
					break;
				case 'listsDeleters':
					//Lista los Productos
					$this->listsDeleters();
					break;
				case 'getDeleter':
					//Obtener un Producto
					$this->getProductoDeleter();
					break;
				default:
					return json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
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
					return json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				}else{
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
				}
			}else{
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
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
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->delete($idProducto))
					return json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				else
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
			}
		}

		/**
		*Activa a un determinado producto
		**/
		private function active(){
			$idProducto	= $this->validateNumber(isset($_POST['idProducto'])?$_POST['idProducto']:NULL);
			if(strlen($idProducto)==0)
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->active($idProducto))
					return json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				else
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
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
					return json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				}else{
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
				}
			}else{
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}
		
		/**
		*listamos todos los Productos activos
		**/
		private function lists(){
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
			if($offset!==''){ 
				if(($result = $this->model->lists($offset))){
					if(is_numeric($result)){
						return json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
					}else{
						return json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
					}
				}else{
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}
			}else{
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		*obtenemos los datos de un Producto activo
		**/
		private function getProducto(){
			$idProducto = $this->validateNumber(isset($_POST['idProducto'])?$_POST['idProducto']:NULL);
			if($idProducto!==''){
				if(($result = $this->model->lists(-1,$idProducto))){
					if(is_numeric($result)){
						return json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
					}else{
						return json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
					}
				}else{
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}
			}else{
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		*listamos todos los Productos inactivos
		**/
		private function listsDeleters(){
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
			if($offset!==''){ 
				if(($result = $this->model->listsDeleters($offset))){
					if(is_numeric($result)){
						return json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
					}else{
						return json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
					}
				}else{
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}
			}else{
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		*obtenemos los datos de un Producto inactivo
		**/
		private function getProductoDeleter(){
			$idProducto = $this->validateNumber(isset($_POST['idProducto'])?$_POST['idProducto']:NULL);
			if($idProducto!==''){
				if(($result = $this->model->listsDeleters(-1,$idProducto))){
					if(is_numeric($result)){
						return json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
					}else{
						return json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
					}
				}else{
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}
			}else{
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}
		
		/**
		* Llama al formulario para la creación de un Producto
		*/
		private function createF(){
			$this->session['action']='create';
			$template = $this->twig->loadTemplate('productoForm.html');
			echo $template->render(array('session'=>$this->session));
		}

		/**
		* Llama al formulario para la actualización de un producto
		*/
		private function updateF(){
			//TODO
			//Cargar en $data desde la base de datos
			$data = $this->model->get(1);
			if($data){
				$this->session['action']='update';
				$template = $this->twig->loadTemplate('productoForm.html');
				echo $template->render(array('session'=>$this->session,'data'=>$data));
			}else{
				//TODO
				//Enviar a listar clientes con vista de inválido
				//echo 'Error';
			}
		}

		function __construct(){
			parent::__construct();
			require_once 'models/productoMdl.php';
			$this->model = new ProductoMdl();
		}
	}
?>
