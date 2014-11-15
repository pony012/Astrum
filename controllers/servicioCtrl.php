<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Servicio
	*/
	class ServicioCtrl extends BaseCtrl
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
						echo json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
					break;
				case 'createF':
					//Crear 
					if(BaseCtrl::isAdmin())
						$this->createF();
					else
						echo json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
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
						echo json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
					break;
				case 'active':
					//Baja
					if(BaseCtrl::isAdmin())
						$this->active();
					else
						echo json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
					break;
				case 'update':
					//Baja
					if(BaseCtrl::isAdmin())
						$this->update();
					else
						echo json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
					break;
				case 'updateF':
					//Baja
					if(BaseCtrl::isAdmin())
						$this->updateF();
					else
						echo json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
					break;
				case 'get':
					//Obtener un servicio
					$this->getServicio();
					break;
				case 'listsDeleters':
					//Lista los servicios
					$this->listsDeleters();
					break;
				case 'getDeleter':
					//Obtener un servicio
					$this->getServicioDeleter();
					break;
				default:
					echo json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
					break;
			}
		}

		/**
		* Crea un Servicio
		*/
		private function create(){
			
			$errors = array();

			$idServicioTipo = $this->validateNumber(isset($_POST['idServicioTipo'])?$_POST['idServicioTipo']:NULL);
			$servicio 		= $this->validateText(isset($_POST['servicio'])?$_POST['servicio']:NULL);
			$precioUnitario	= $this->validateNumber(isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
			$foto 			= $this->validateText(isset($_POST['foto'])?$_POST['foto']:NULL);
			$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

			if(strlen($idServicioTipo)==0)
				$errors['idServicioTipo'] = 1;
			if(strlen($servicio)==0)
				$errors['servicio'] = 1;
			if(strlen($precioUnitario)==0)
				$errors['precioUnitario'] = 1;
			if(strlen($foto)==0)
				$errors['foto'] = 1;
			if(strlen($descripcion)==0)
				$errors['descripcion'] = 1;

			if (count($errors) == 0) {

				$result = $this->model->create($idServicioTipo, $servicio, $precioUnitario, $foto, $descripcion);

				//Si pudo ser creado
				if ($result) {
					$data = array($idServicioTipo, $servicio, $precioUnitario, $foto, $descripcion);
					//Cargar la vista
					echo json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
				}else{
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
				}
			}else{
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		private function read(){

		}

		/**
		*Da de baja a un determinado servicio
		**/
		private function delete(){
			$idServicio	= $this->validateNumber(isset($_POST['idServicio'])?$_POST['idServicio']:NULL);
			if(strlen($idServicio)==0)
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->delete($idServicio))
					echo json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				else
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
			}
		}

		/**
		*Activa a un determinado servicio
		**/
		private function active(){
			$idServicio	= $this->validateNumber(isset($_POST['idServicio'])?$_POST['idServicio']:NULL);
			if(strlen($idServicio)==0)
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->active($idServicio))
					echo json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				else
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
			}
		}

		private function update(){
			$errors = array();

			$idServicio 	= $this->validateNumber(isset($_POST['idServicio'])?$_POST['idServicio']:NULL);
			$idServicioTipo = $this->validateNumber(isset($_POST['idServicioTipo'])?$_POST['idServicioTipo']:NULL);
			$servicio 		= $this->validateText(isset($_POST['servicio'])?$_POST['servicio']:NULL);
			$precioUnitario	= $this->validateNumber(isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
			$foto 			= $this->validateText(isset($_POST['foto'])?$_POST['foto']:NULL);
			$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

			if(strlen($idServicio)==0)
				$errors['idServicio'] = 1;
			if(strlen($idServicioTipo)==0)
				$errors['idServicioTipo'] = 1;
			if(strlen($servicio)==0)
				$errors['servicio'] = 1;
			if(strlen($precioUnitario)==0)
				$errors['precioUnitario'] = 1;
			if(strlen($foto)==0)
				$errors['foto'] = 1;
			if(strlen($descripcion)==0)
				$errors['descripcion'] = 1;

			if (count($errors) == 0) {

				$result = $this->model->update($idServicio,$idServicioTipo, $servicio, $precioUnitario, $foto, $descripcion);

				//Si pudo ser creado
				if ($result) {
					$data = array($idServicioTipo, $servicio, $precioUnitario, $foto, $descripcion);
					//Cargar el modal
					echo json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				}else{
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
				}
			}else{
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		*listamos todos los Servicios activos
		**/
		private function lists(){
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
			if($offset!==''){ 
				if(($result = $this->model->lists($offset))){
					if(is_numeric($result)){
						echo json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
					}else{
						header('Content-Type: application/json');
						BaseCtrl::utf8_encode_deep($result);
						echo json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
					}
				}else{
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}
			}else{
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		*obtenemos los datos de un Servicio activo
		**/
		private function getServicio(){
			$idServicio = $this->validateNumber(isset($_POST['idServicio'])?$_POST['idServicio']:NULL);
			if($idServicio!==''){
				if(($result = $this->model->lists(-1,$idServicio))){
					if(is_numeric($result)){
						echo json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
					}else{
						header('Content-Type: application/json');
						BaseCtrl::utf8_encode_deep($result);
						echo json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
					}
				}else{
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}
			}else{
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		*listamos todos los Servicios inactivos
		**/
		private function listsDeleters(){
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
			if($offset!==''){ 
				if(($result = $this->model->listsDeleters($offset))){
					if(is_numeric($result)){
						echo json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
					}else{
						header('Content-Type: application/json');
						BaseCtrl::utf8_encode_deep($result);
						echo json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
					}
				}else{
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}
			}else{
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		*obtenemos los datos de un Servicio inactivo
		**/
		private function getServicioDeleter(){
			$idServicio = $this->validateNumber(isset($_POST['idServicio'])?$_POST['idServicio']:NULL);
			if($idServicio!==''){
				if(($result = $this->model->listsDeleters(-1,$idServicio))){
					if(is_numeric($result)){
						echo json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
					}else{
						header('Content-Type: application/json');
						BaseCtrl::utf8_encode_deep($result);
						echo json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
					}
				}else{
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}
			}else{
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		* Llama al formulario para la creación de un Servicio
		*/
		private function createF(){
			$this->session['action']='create';
			$template = $this->twig->loadTemplate('servicioForm.html');
			echo $template->render(array('session'=>$this->session));
		}

		/**
		* Llama al formulario para la actualización de un servicio
		*/
		private function updateF(){
			//TODO
			//Cargar en $data desde la base de datos
			$data = $this->model->get(1);
			if($data){
				$this->session['action']='update';
				$template = $this->twig->loadTemplate('servicioForm.html');
				echo $template->render(array('session'=>$this->session,'data'=>$data));
			}else{
				//TODO
				//Enviar a listar clientes con vista de inválido
				//echo 'Error';
			}
		}

		function __construct(){
			parent::__construct();
			require_once 'models/servicioMdl.php';
			$this->model = new ServicioMdl();
		}
	}
?>
