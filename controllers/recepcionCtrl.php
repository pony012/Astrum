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
				case 'get':
					//Obtener una Recepcion
					$this->getRecepcion();
					break;
				case 'listsDeleters':
					//Lista las Recepciones
					$this->listsDeleters();
					break;
				case 'getDeleter':
					//Obtener una Recepcion
					$this->getRecepcionDeleter();
					break;
				default:
					return json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
					break;
			}
		}
		/**
		* Crea una Recepcion
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
			if(count($this->validateNumericArray($cantidades)) != 0)
				$errors['cantidades'] = 1;
			if(count($this->validateNumericArray($ivas)) != 0)
				$errors['ivas'] = 1;
			if(count($this->validateNumericArray($descuentos)) != 0)
				$errors['descuentos'] = 1;
			
			if (count($errors) == 0) {
				
				$result = $this->model->create($idProveedor, $folio, $fechaRecepcion,$idProductos,$cantidades,$precioUnitario,$ivas,$descuentos);

				//Si pudo ser creado
				if ($result) {
					//Guardamos los campos en un arreglo
					$data = array($idProveedor, $folio, $fechaRecepcion,$idProductos,$cantidades,$precioUnitario,$ivas,$descuentos);
					
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

		private function delete(){

		}

		private function update(){

		}

		/**
		*listamos todos las Recepciones activos
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
		*obtenemos los datos de una Recepcion activo
		**/
		private function getRecepcion(){
			$idRecepcion = $this->validateNumber(isset($_POST['idRecepcion'])?$_POST['idRecepcion']:NULL);
			if($idRecepcion!==''){
				if(($result = $this->model->lists(-1,$idRecepcion))){
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
		*listamos todos las Recepciones inactivos
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
		*obtenemos los datos de una Recepcion inactivo
		**/
		private function getRecepcionDeleter(){
			$idRecepcion = $this->validateNumber(isset($_POST['idRecepcion'])?$_POST['idRecepcion']:NULL);
			if($idRecepcion!==''){
				if(($result = $this->model->listsDeleters(-1,$idRecepcion))){
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
		* Llama al formulario para la creación de una Recepcion
		*/
		private function createF(){
			$this->session['action']='create';
			$template = $this->twig->loadTemplate('recepcionForm.html');
			echo $template->render(array('session'=>$this->session));
		}

		/**
		* Llama al formulario para la actualización de una Recepcion
		*/
		private function updateF(){
			//TODO
			//Cargar en $data desde la base de datos
			$data = $this->model->get(1);
			if($data){
				$this->session['action']='update';
				$template = $this->twig->loadTemplate('recepcionForm.html');
				echo $template->render(array('session'=>$this->session,'data'=>$data));
			}else{
				//TODO
				//Enviar a listar clientes con vista de inválido
				//echo 'Error';
			}
		}

		function __construct(){
			parent::__construct();
			require_once 'models/recepcionMdl.php';
			$this->model = new RecepcionMdl();
		}
	}
?>
