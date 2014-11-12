<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Producto
	*/
	class ConsultaStatusCtrl extends BaseCtrl
	{
		/**
		 * Ejecuta acciones basado en la accion seleccionada por los agrumentos
		 */
		public function run()
		{
			if(BaseCtrl::isAdmin())
				switch ($_GET['act']) {
					case 'create':
						//Crear 
						$this->create();
						break;
					case 'update':
						//Baja
						$this->update();
						break;
					case 'lists':
					//Listar
						$this->lists();
						break;
					case 'get':
						$this->getConsultaStatus();
						break;
					default:
						return json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
						break;
				}
			else
				return json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
		}
		/**
		* Crea un Producto
		*/
		private function create(){
			
			$errors = array();

			$status		    = $this->validateText(isset($_POST['status'])?$_POST['status']:NULL);
			$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

			if(strlen($status)==0)
				$errors['status'] = 1;
			if(strlen($descripcion)==0)
				$errors['descripcion'] = 1;
			
			if (count($errors) == 0){

				$result = $this->model->create($status, $descripcion);

				//Si pudo ser creado
				if ($result) {
					//$data = array($status, $descripcion);
					//Cargar la vista
					return json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
				}else{
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}	
			}else{
				//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		private function read(){

		}

		private function delete(){

		}

		private function update(){
			$errors = array();

			$idConsultaStatus=$this->validateNumber(isset($_POST['idConsultaStatus'])?$_POST['idConsultaStatus']:NULL);
			$status		    = $this->validateText(isset($_POST['status'])?$_POST['status']:NULL);
			$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

			if(strlen($idConsultaStatus)==0)
				$errors['idConsultaStatus'] = 1;
			if(strlen($status)==0)
				$errors['status'] = 1;
			if(strlen($descripcion)==0)
				$errors['descripcion'] = 1;
			
			if (count($errors) == 0){

				$result = $this->model->update($idConsultaStatus,$status, $descripcion);

				//Si pudo ser creado
				if ($result) {
					//$data = array($status, $descripcion);
					//Cargar la vista
					return json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
				}else{
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}	
			}else{
				//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		*Listamos todos los estatus de una consulta
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
		*obtenemos los datos de un estatus de una consulta
		**/
		private function getConsultaStatus(){
			$idConsultaStatus = $this->validateNumber(isset($_POST['idConsultaStatus'])?$_POST['idConsultaStatus']:NULL);
			if($idConsultaStatus!==''){
				if(($result = $this->model->lists(-1,$idConsultaStatus))){
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

		function __construct(){
			parent::__construct();
			require_once 'models/consultaStatusMdl.php';
			$this->model = new ConsultaStatusMdl();
		}
	}
?>