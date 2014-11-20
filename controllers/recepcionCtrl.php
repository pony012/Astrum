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
				case 'listsDetails':
					//Crear 
					$this->listsDetails();
					break;	
				case 'get':
					//Obtener una Recepcion
					$this->getRecepcion();
					break;
				case 'getFolio':
					$this->getFolio();
					break;
				default:
					if ($this->api) {
						echo $this->json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este recepcion no está disponible'));
					}else{
						//CARGAR VISTA DE SERVICIO INEXISTENTE
					}
					break;
			}
		}
		/**
		* Crea una Recepcion
		*/
		private function create(){
			if ($this->api) {
				$errors = array();
				
				$idProveedor	= $this->validateNumber(isset($_POST['idProveedor'])?$_POST['idProveedor']:NULL);
				$folio			= $this->model->getFolio('Recepcion');//$this->validateNumber(isset($_POST['folio'])?$_POST['folio']:NULL);
				$fechaRecepcion	= $this->validateDate(isset($_POST['fechaRecepcion'])?$_POST['fechaRecepcion']:NULL);
				$idProductos 	= (isset($_POST['idProductos'])?$_POST['idProductos']:NULL);
				$cantidades		= (isset($_POST['cantidades'])?$_POST['cantidades']:NULL);
				$precioUnitario	= (isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
				$ivas 			= (isset($_POST['ivas'])?$_POST['ivas']:NULL);
				$descuentos 	= (isset($_POST['descuentos'])?$_POST['descuentos']:NULL);
				
				if(strlen($idProveedor)==0)
					$errors['idProveedor'] = 1;
				if(strlen($fechaRecepcion)==0)
					$errors['fechaRecepcion'] = 1;
				if(count($this->validateNumericArray($idProductos)) != 0)
					$errors['idProductos'] = 1;
				if(count($this->validateNumericArray($cantidades)) != 0)
					$errors['cantidades'] = 1;
				if(count($this->validateNumericArray($ivas)) != 0)
					$errors['ivas'] = 1;
				if(count($this->validateNumericArray($descuentos)) != 0)
					$errors['descuentos'] = 1;

				if (count($errors) == 0) {
					
					$result = $this->model->create($idProveedor, $folio, $fechaRecepcion,$idProductos,$cantidades,$precioUnitario,$ivas,$descuentos);

					//Si pudo ser creado
					if ($result != false) {
						//Guardamos los campos en un arreglo
						//$data = array($idProveedor, $folio, $fechaRecepcion,$idProductos,$cantidades,$precioUnitario,$ivas,$descuentos);
						
						echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
					}else{
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
					}
				}else{
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}
			}else{
				$this->session['action']='create';
				$template = $this->twig->loadTemplate('recepcionForm.html');
				echo $template->render(array('session'=>$this->session));
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
			$constrain = '';
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
			$idRecepcion = $this->validateNumber(isset($_GET['id'])?$_GET['id']:NULL);
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
				if ($idRecepcion!=='') {
					if(($result = $this->model->listsDetails($idRecepcion))){
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
								$template = $this->twig->loadTemplate('recepcionForm.html');
								echo $template->render(array('session'=>$this->session,'data'=>$result));
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
							$template = $this->twig->loadTemplate('vacio.html'); echo $template->render(array('session'=>$this->session,'data'=>NULL));
						}
					}else{
						if($this->api){
							echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
						}else{
							$template = $this->twig->loadTemplate('recepcionList.html');
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
		*obtenemos los datos de una Recepcion activo
		**/
		private function getRecepcion(){
			$idRecepcion = $this->validateNumber(isset($_REQUEST['idRecepcion'])?$_REQUEST['idRecepcion']:NULL);
			if($idRecepcion!==''){
				if(($result = $this->model->lists(-1,$idRecepcion))){
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
							$template = $this->twig->loadTemplate('recepcionList.html');
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

		private function getFolio(){
			$folio = $this->model->getFolio('Recepcion');
			if(is_numeric($folio)){
				if($this->api){
					echo $this->json_encode(array('error'=>OK,'data'=>array('Folio' => ($folio+1)),'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
				}else{
					//CARGAR VISTA OK
				}
			}else{
				if($this->api){
					echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Generar el Folio'));
				}else{
					//CARGAR VISTA ERROR DB
				}
			}
		}

		/**
		*listamos los detalles de una recepcion
		**/
		private function listsDetails(){
			$idRecepcion = $this->validateNumber(isset($_GET['id'])?$_GET['id']:NULL);
			if($idRecepcion!==''){
				if(($result = $this->model->listsDetails($idRecepcion))){
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
							$template = $this->twig->loadTemplate('recepcionList.html');
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
			require_once 'models/recepcionMdl.php';
			$this->model = new RecepcionMdl();
		}
	}
?>
