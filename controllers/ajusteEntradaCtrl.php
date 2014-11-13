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
					//Obtener un AjusteEntrada
					$this->getAjusteEntrada();
					break;
				case 'listsDeleters':
					//Lista los AjusteEntrada
					$this->listsDeleters();
					break;
				case 'getDeleter':
					//Obtener un AjusteEntrada
					$this->getAjusteEntradaDeleter();
					break;
				default:
					return json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
					break;
			}
		}

		/**
		* Crea un Ajuste Entrada
		*/
		private function create(){
			
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
					$data = array($idAjusteEntradaTipo, $idCliente, $folio, $observaciones, $idProductoServicios, $cantidades);
					
					return json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
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
		*listamos todos los Ajustes de Entrada activos
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
		*obtenemos los datos de un AjusteEntrada activo
		**/
		private function getAjusteEntrada(){
			$idAjusteEntrada = $this->validateNumber(isset($_POST['idAjusteEntrada'])?$_POST['idAjusteEntrada']:NULL);
			if($idAjusteEntrada!==''){
				if(($result = $this->model->lists(-1,$idAjusteEntrada))){
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
		*listamos todos los Ajustes de Entrada inactivos
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
		*obtenemos los datos de un AjusteEntrada inactivo
		**/
		private function getAjusteEntradaDeleter(){
			$idAjusteEntrada = $this->validateNumber(isset($_POST['idAjusteEntrada'])?$_POST['idAjusteEntrada']:NULL);
			if($idAjusteEntrada!==''){
				if(($result = $this->model->listsDeleters(-1,$idAjusteEntrada))){
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
		* Llama al formulario para la creación de un Ajuste de Entrada
		*/
		private function createF(){
			$this->session['action']='create';
			$template = $this->twig->loadTemplate('ajusteEntradaForm.html');
			echo $template->render(array('session'=>$this->session));
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

		/**
		*Listamos todas los ajustes de entrada con sus detalles
		**/
		private function listss(){

			if($resultAjusteEntrada = $this->model->lists()){

				$data = array();
				foreach($resultAjusteEntrada as $row){

					$details = array();

					if($resultAjusteEntradaDetalle = $this->model->listsDetails($row['IDAjusteEntrada'])){

						foreach($resultAjusteEntradaDetalle as $rowDetails)
							array_push($details, $rowDetails);

					}

					array_push($data, array($row,$details));
				}
				
				require_once 'views/ajusteEntradaSelected.php';
			}else
				require_once 'views/ajusteEntradaSelectedError.html';
		}

		function __construct(){
			parent::__construct();
			require_once 'models/ajusteEntradaMdl.php';
			$this->model = new AjusteEntradaMdl();
		}
	}
?>
