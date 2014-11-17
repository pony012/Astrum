<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Ajuste Entrada
	*/
	class AjusteEntradaCtrl extends BaseCtrl
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
					//Obtener un AjusteEntrada
					$this->getAjusteEntrada();
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
		* Crea un Ajuste Entrada
		*/
		private function create(){
			if($this->api){
				$errors = array();

				$idAjusteEntradaTipo 	= $this->validateNumber(isset($_POST['idAjusteEntradaTipo'])?$_POST['idAjusteEntradaTipo']:NULL);
				$idCliente 				= $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
				$folio					= $this->validateNumber(isset($_POST['folio'])?$_POST['folio']:NULL);
				$observaciones			= $this->validateText(isset($_POST['observaciones'])?$_POST['observaciones']:NULL);
				$idProductoServicios 	= (isset($_POST['idProductoServicios'])?$_POST['idProductoServicios']:NULL);
				$cantidades				= (isset($_POST['cantidades'])?$_POST['cantidades']:NULL);

				if(strlen($idAjusteEntradaTipo)==0)
					$errors['idAjusteEntradaTipo'] = 1;
				if(strlen($idCliente)==0)
					$errors['idCliente'] = 1;
				if(strlen($folio)==0)
					$errors['folio'] = 1;
				if(count($this->validateNumericArray($cantidades)) != 0)
					$errors['cantidades'] = 1;
				/*
				if(strlen($observaciones)==0)
					$errors['observaciones'] = 1;
				*/

				if (count($errors) == 0) {

					$result = $this->model->create($idAjusteEntradaTipo, $idCliente, $folio, $observaciones, $idProductoServicios, $cantidades);

					//Si pudo ser creado
					if ($result) {
						//$data = array($idAjusteEntradaTipo, $idCliente, $folio, $observaciones, $idProductoServicios, $cantidades);
						
						echo $this->json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
					}else{
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
					}
				}else{
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}

			}else{
				$this->session['action']='create';
				$template = $this->twig->loadTemplate('ajusteEntradaForm.html');
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
		*listamos todos los Ajustes de Entrada activos
		**/
		private function lists(){
			$constrain = '';
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
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
				if(($result = $this->model->lists($offset,-1,$constrain))){
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
							$template = $this->twig->loadTemplate('ajusteEntradaList.html');
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
		*obtenemos los datos de un AjusteEntrada activo
		**/
		private function getAjusteEntrada(){
			$idAjusteEntrada = $this->validateNumber(isset($_GET['idAjusteEntrada'])?$_GET['idAjusteEntrada']:NULL);
			if($idAjusteEntrada!==''){
				if(($result = $this->model->lists(-1,$idAjusteEntrada))){
					if(is_numeric($result)){
						echo $this->json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
					}else{
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
		* Llama al formulario para la actualización de un Ajuste de Entrada
		*/
		private function updateF(){
			//TODO
			//Cargar en $data desde la base de datos
			$data = $this->model->get(1);
			if($data){
				$this->session['action']='update';
				$template = $this->twig->loadTemplate('ajusteEntradaForm.html');
				echo $template->render(array('session'=>$this->session,'data'=>$data));
			}else{
				//TODO
				//Enviar a listar clientes con vista de inválido
				//echo 'Error';
			}
		}

		private function getFolio(){
			$folio = $this->model->getFolio('AjusteEntrada');
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
		*listamos los detalles de un ajuste de entrada
		**/
		private function listsDetails(){
			$idAjusteEntrada = $this->validateNumber(isset($_GET['id'])?$_GET['id']:NULL);
			if($idAjusteEntrada!==''){
				if(($result = $this->model->listsDetails($idAjusteEntrada))){
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
							$template = $this->twig->loadTemplate('ajusteEntradaList.html');
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
			require_once 'models/ajusteEntradaMdl.php';
			$this->model = new AjusteEntradaMdl();
		}
	}
?>
