<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Ajuste Salida
	*/
	class AjusteSalidaCtrl extends BaseCtrl
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
					//Obtener un AjusteSalida
					$this->getAjusteSalida();
					break;
				case 'getFolio':
					$this->getFolio();
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
		* Crea un Ajuste Salida
		*/
		private function create(){
			if($this->api){
				$errors = array();

				$idAjusteSalidaTipo 	= $this->validateNumber(isset($_POST['idAjusteSalidaTipo'])?$_POST['idAjusteSalidaTipo']:NULL);
				$idProveedor 			= $this->validateNumber(isset($_POST['idProveedor'])?$_POST['idProveedor']:NULL);
				$folio					= $this->model->getFolio('AjusteSalida'); //$this->validateNumber(isset($_POST['folio'])?$_POST['folio']:NULL);
				$observaciones			= $this->validateText(isset($_POST['observaciones'])?$_POST['observaciones']:NULL);
				$idProductoServicios 	= (isset($_POST['idProductoServicios'])?$_POST['idProductoServicios']:NULL);
				$cantidades				= (isset($_POST['cantidades'])?$_POST['cantidades']:NULL);

				if(strlen($idAjusteSalidaTipo)==0)
					$errors['idAjusteSalidaTipo'] = 1;
				if(strlen($idProveedor)==0)
					$errors['idProveedor'] = 1;
				if(count($this->validateNumericArray($cantidades)) != 0)
					$errors['cantidades'] = 1;
				/*
				if(strlen($observaciones)==0)
					$errors['observaciones'] = 1;
				*/
				if (count($errors) == 0) {

					$result = $this->model->create($idAjusteSalidaTipo, $idProveedor, $folio, $observaciones, $idProductoServicios, $cantidades);

					//Si pudo ser creado
					if ($result != false) {
						//$data = array($idAjusteSalidaTipo, $idProveedor, $folio, $observaciones, $idProductoServicios, $cantidades);
						
						echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
					}else{
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
					}
				}else{
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}
			}else{
				$this->session['action']='create';
				$template = $this->twig->loadTemplate('ajusteSalidaForm.html');
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
		*listamos todos los Ajustes de Salida activos
		**/
		private function lists(){
			$constrain = '';
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
			$idAjusteSalida = $this->validateNumber(isset($_GET['id'])?$_GET['id']:NULL);
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
				if ($idAjusteSalida!=='') {
					if(($result = $this->model->listsDetails($idAjusteSalida))){
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
								$template = $this->twig->loadTemplate('ajusteSalidaForm.html');
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
							$template = $this->twig->loadTemplate('ajusteSalidaList.html');
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
		*obtenemos los datos de un AjusteSalida activo
		**/
		private function getAjusteSalida(){
			$idAjusteSalida = $this->validateNumber(isset($_GET['idAjusteSalida'])?$_GET['idAjusteSalida']:NULL);
			if($idAjusteSalida!==''){
				if(($result = $this->model->lists(-1,$idAjusteSalida))){
					if(is_numeric($result)){
						echo $this->json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
					}else{
						header('Content-Type: application/json');
						BaseCtrl::utf8_encode_deep($result);
						echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
					}
				}else{
					echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}
			}else{
				echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		* Llama al formulario para la actualización de un Ajuste de Salida
		*/
		private function updateF(){
			//TODO
			//Cargar en $data desde la base de datos
			$data = $this->model->get(1);
			if($data){
				$this->session['action']='update';
				$template = $this->twig->loadTemplate('ajusteSalidaForm.html');
				echo $template->render(array('session'=>$this->session,'data'=>$data));
			}else{
				//TODO
				//Enviar a listar ajusteSalidas con vista de inválido
				//echo 'Error';
			}
		}

		private function getFolio(){
			$folio = $this->model->getFolio('AjusteSalida');
			var_dump($folio);
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
		*listamos los detalles de un ajuste de salida
		**/
		private function listsDetails(){
			$idAjusteSalida = $this->validateNumber(isset($_GET['id'])?$_GET['id']:NULL);
			if($idAjusteSalida!==''){
				if(($result = $this->model->listsDetails($idAjusteSalida))){
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
							$template = $this->twig->loadTemplate('ajusteSalidaList.html');
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
			require_once 'models/ajusteSalidaMdl.php';
			$this->model = new AjusteSalidaMdl();
		}
	}
?>
