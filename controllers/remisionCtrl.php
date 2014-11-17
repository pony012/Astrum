<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Remision
	*/
	class RemisionCtrl extends BaseCtrl
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
					//Crear 
					$this->lists();
					break;	
				case 'listsDetails':
					//Crear 
					$this->listsDetails();
					break;	
				case 'get':
					//Obtener una Remision
					$this->getRemision();
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
		* Crea una Remision
		*/
		private function create(){
			if ($this->api) {
				$errors = array();
				
				$idCliente	= $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
				$folio			= $this->validateNumber(isset($_POST['folio'])?$_POST['folio']:NULL);
				$fechaRemision	= $this->validateDate(isset($_POST['fechaRemision'])?$_POST['fechaRemision']:NULL);
				$idProductos 	= (isset($_POST['idProductos'])?$_POST['idProductos']:NULL);
				$cantidades		= (isset($_POST['cantidades'])?$_POST['cantidades']:NULL);
				$precioUnitario	= (isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
				$ivas 			= (isset($_POST['ivas'])?$_POST['ivas']:NULL);
				$descuentos 	= (isset($_POST['descuentos'])?$_POST['descuentos']:NULL);
				
				if(strlen($idCliente)==0)
					$errors['idCliente'] = 1;
				if(strlen($folio)==0)
					$errors['folio'] = 1;
				if(strlen($fechaRemision)==0)
					$errors['fechaRemision'] = 1;
				if(count($this->validateNumericArray($cantidades)) != 0)
					$errors['cantidades'] = 1;
				if(count($this->validateNumericArray($ivas)) != 0)
					$errors['ivas'] = 1;
				if(count($this->validateNumericArray($descuentos)) != 0)
					$errors['descuentos'] = 1;
				
				if (count($errors) == 0) {
					
					$result = $this->model->create($idCliente, $folio, $fechaRemision,$idProductos,$cantidades,$precioUnitario,$ivas,$descuentos);

					//Si pudo ser creado
					if ($result) {
						//Guardamos los campos en un arreglo
						//$data = array($idCliente, $folio, $fechaRemision,$idProductos,$cantidades,$precioUnitario,$ivas,$descuentos);
						
						echo $this->json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
					}else{
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
					}
				}else{
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}
			}else{
				$this->session['action']='create';
				$template = $this->twig->loadTemplate('remisionForm.html');
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
		*listamos todos las Remisiones activos
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
							$template = $this->twig->loadTemplate('remisionList.html');
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
		*obtenemos los datos de una Remision activo
		**/
		private function getRemision(){
			$idRemision = $this->validateNumber(isset($_GET['idRemision'])?$_GET['idRemision']:NULL);
			if($idRemision!==''){
				if(($result = $this->model->lists(-1,$idRemision))){
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
							$template = $this->twig->loadTemplate('remisionList.html');
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
			$folio = $this->model->getFolio('Remision');
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
		*listamos los detalles de una remision
		**/
		private function listsDetails(){
			$idRemision = $this->validateNumber(isset($_GET['id'])?$_GET['id']:NULL);
			if($idRemision!==''){
				if(($result = $this->model->listsDetails($idRemision))){
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
							$template = $this->twig->loadTemplate('remisionList.html');
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
			require_once 'models/remisionMdl.php';
			$this->model = new RemisionMdl();
		}
	}
?>
