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
		public function run(){
			switch ($_GET['act']) {
				case 'create':
					//Crear 
					if(BaseCtrl::isAdmin())
						$this->create();
					else{
						if ($this->api) {
							echo $this->json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
						}else{
							//CARGAR VISTA DE NO PERMITIDO
						}
					}
					break;
				case 'lists':
					//Listar 
					$this->lists();
					break;
				case 'delete':
					//Baja 
					if(BaseCtrl::isAdmin())
						$this->delete();
					else{
						if ($this->api) {
							echo $this->json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
						}else{
							//CARGAR VISTA DE NO PERMITIDO
						}
					}
					break;
				case 'active':
					//Baja
					if(BaseCtrl::isAdmin())
						$this->active();
					else{
						if ($this->api) {
							echo $this->json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
						}else{
							//CARGAR VISTA DE NO PERMITIDO
						}
					}
					break;
				case 'update':
					//Baja
					if(BaseCtrl::isAdmin())
						$this->update();
					else{
						if ($this->api) {
							echo $this->json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
						}else{
							//CARGAR VISTA DE NO PERMITIDO
						}
					}
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
					if ($this->api) {
						echo $this->json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
					}else{
						//CARGAR VISTA DE SERVICIO INEXISTENTE
					}
					break;
			}
		}

		/**
		* Crea un Servicio
		*/
		private function create(){
			if ($this->api) {
				$errors = array();

				$servicio 		= $this->validateText(isset($_POST['servicio'])?$_POST['servicio']:NULL);
				$precioUnitario	= $this->validateNumber(isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
				$foto 			= $this->validateText(isset($_POST['foto'])?$_POST['foto']:NULL);
				$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

				if(strlen($servicio)==0)
					$errors['servicio'] = 1;
				if(strlen($precioUnitario)==0)
					$errors['precioUnitario'] = 1;
				//if(strlen($foto)==0)
				//	$errors['foto'] = 1;
				if(strlen($descripcion)==0)
					$errors['descripcion'] = 1;

				if (count($errors) == 0) {

					$result = $this->model->create($servicio, $precioUnitario, $foto, $descripcion);

					//Si pudo ser creado
					if ($result) {
						//$data = array($idServicioTipo, $servicio, $precioUnitario, $foto, $descripcion);
						//Cargar la vista
						echo $this->json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
					}else{
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
					}
				}else{
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}
			}else{
				$this->session['action']='create';
				$template = $this->twig->loadTemplate('servicioForm.html');
				echo $template->render(array('session'=>$this->session));
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
				echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->delete($idServicio))
					echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				else
					echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
			}
		}

		/**
		*Activa a un determinado servicio
		**/
		private function active(){
			$idServicio	= $this->validateNumber(isset($_POST['idServicio'])?$_POST['idServicio']:NULL);
			if(strlen($idServicio)==0)
				echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->active($idServicio))
					echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				else
					echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
			}
		}

		private function update(){
			if ($this->api) {
				$errors = array();

				$idServicio 	= $this->validateNumber(isset($_POST['idServicio'])?$_POST['idServicio']:NULL);
				$servicio 		= $this->validateText(isset($_POST['servicio'])?$_POST['servicio']:NULL);
				$precioUnitario	= $this->validateNumber(isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
				$foto 			= $this->validateText(isset($_POST['foto'])?$_POST['foto']:NULL);
				$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

				if(strlen($idServicio)==0)
					$errors['idServicio'] = 1;
				if(strlen($servicio)==0)
					$errors['servicio'] = 1;
				if(strlen($precioUnitario)==0)
					$errors['precioUnitario'] = 1;
				if(strlen($foto)==0)
					$errors['foto'] = 1;
				if(strlen($descripcion)==0)
					$errors['descripcion'] = 1;

				if (count($errors) == 0) {

					$result = $this->model->update($idServicio, $servicio, $precioUnitario, $foto, $descripcion);

					//Si pudo ser creado
					if ($result) {
						//$data = array($idServicioTipo, $servicio, $precioUnitario, $foto, $descripcion);
						//Cargar el modal
						echo $this->json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
					}else{
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
					}
				}else{
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}
			}else{
				//TODO
				//Cargar en $data desde la base de datos
				$data = $this->model->lists(-1, $_GET['id']);
				if($data){
					$this->session['action']='update';
					$template = $this->twig->loadTemplate('servicioForm.html');
					echo $template->render(array('session'=>$this->session,'data'=>$data[0]));
				}else{
					//TODO
					//Enviar a listar servicios con vista de inválido
					//echo 'Error';
				}
			}
		}

		/**
		*listamos todos los Servicios activos
		**/
		private function lists(){
			$constrain = '';
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
			$idServicio = $this->validateNumber(isset($_GET['id'])?$_GET['id']:NULL);
			$constrains = isset($_POST['constrains'])?$_POST['constrains']:'1 = 1';
			
			if($constrains === '1 = 1'){
				$constrain = $constrains;
			}else{
				$tam = count($constrains);
				foreach ($constrains as $campo => $valor) {
					if(--$tam){
						if(is_numeric($valor)){
							$constrain.=$campo.' = '.$valor.' AND ';
						}else{
							$constrain.=$campo.' LIKE "%'.$valor.'%" AND ';
						}
					}else{
						if(is_numeric($valor)){
							$constrain.=$campo.' = '.$valor;
						}else{
							$constrain.=$campo.' LIKE "%'.$valor.'%"';
						}
					}
				}
			}
			if($offset!==''){ 
				if ($idServicio!=='') {
					if(($result = $this->model->lists($offset,$idServicio,$constrain))){
						if(is_numeric($result)){
							if ($this->api) {
								echo $this->json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
							}else{
								$template = $this->twig->loadTemplate('vacio.html');
								echo $template->render(array('session'=>$this->session,'data'=>NULL));
							}
						}else{
							if($this->api){
								echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
							}else{
								$this->session['action']='list';
								$template = $this->twig->loadTemplate('servicioForm.html');
								echo $template->render(array('session'=>$this->session,'data'=>$result[0]));
							}
						}
					}else{
						if($this->api){
							echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
						}else{
							//CARGAR VISTA FORMATO INCORRECTO
						}
					}
				}else if(($result = $this->model->lists($offset,-1,$constrain))){
					if(is_numeric($result)){
						if ($this->api) {
							echo $this->json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
						}else{
							$template = $this->twig->loadTemplate('vacio.html');
							echo $template->render(array('session'=>$this->session,'data'=>NULL));
						}
					}else{
						if($this->api){
							echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
						}else{
							$this->session['action']='list';
							$template = $this->twig->loadTemplate('servicioList.html');
							echo $template->render(array('session'=>$this->session,'data'=>$result));
						}
					}
				}else{
					if($this->api){
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
					}else{
						//CARGAR VISTA ERROR DB
					}
				}
			}else{
				if($this->api){
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}else{
					//CARGAR VISTA FORMATO INCORRECTO
				}
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
						if ($this->api) {
							echo $this->json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
						}else{
							$template = $this->twig->loadTemplate('vacio.html'); echo $template->render(array('session'=>$this->session,'data'=>NULL));
						}
					}else{
						if($this->api){
							echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
						}else{
							$template = $this->twig->loadTemplate('servicioList.html');
							echo $template->render(array('session'=>$this->session,'data'=>$result));
						}
					}
				}else{
					if($this->api){
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
					}else{
						//CARGAR VISTA ERROR DB
					}
				}
			}else{
				if($this->api){
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}else{
					//CARGAR VISTA FORMATO INCORRECTO
				}
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
						if ($this->api) {
							echo $this->json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
						}else{
							$template = $this->twig->loadTemplate('vacio.html'); echo $template->render(array('session'=>$this->session,'data'=>NULL));
						}
					}else{
						if($this->api){
							echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
						}else{
							$template = $this->twig->loadTemplate('servicioList.html');
							echo $template->render(array('session'=>$this->session,'data'=>$result));
						}
					}
				}else{
					if($this->api){
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
					}else{
						//CARGAR VISTA ERROR DB
					}
				}
			}else{
				if($this->api){
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}else{
					//CARGAR VISTA FORMATO INCORRECTO
				}
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
						if ($this->api) {
							echo $this->json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
						}else{
							$template = $this->twig->loadTemplate('vacio.html'); echo $template->render(array('session'=>$this->session,'data'=>NULL));
						}
					}else{
						if($this->api){
							echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
						}else{
							$template = $this->twig->loadTemplate('servicioList.html');
							echo $template->render(array('session'=>$this->session,'data'=>$result));
						}
					}
				}else{
					if($this->api){
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
					}else{
						//CARGAR VISTA ERROR DB
					}
				}
			}else{
				if($this->api){
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}else{
					//CARGAR VISTA FORMATO INCORRECTO
				}
			}
		}

		function __construct(){
			parent::__construct();
			require_once 'models/servicioMdl.php';
			$this->model = new ServicioMdl();
		}
	}
?>
