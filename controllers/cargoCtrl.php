<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Producto
	*/
	class CargoCtrl extends BaseCtrl
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
						//Crear 
						$this->lists();
						break;
					case 'get':
						//Baja
						$this->getCargo();
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

			$cargo		    = $this->validateText(isset($_POST['cargo'])?$_POST['cargo']:NULL);
			$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

			if(strlen($cargo)==0)
				$errors['cargo'] = 1;
			if(strlen($descripcion)==0)
				$errors['descripcion'] = 1;
			
			if (count($errors) == 0){

				$result = $this->model->create($cargo, $descripcion);

				//Si pudo ser creado
				if ($result) {
					//$data = array($cargo, $descripcion);
					//Cargar la vista
					return json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
				}else{
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
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
			$errors = array();

			$idCargo 	 	= $this->validateNumber(isset($_POST['idCargo'])?$_POST['idCargo']:NULL);
			$cargo		    = $this->validateText(isset($_POST['cargo'])?$_POST['cargo']:NULL);
			$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

			if(strlen($idCargo)==0)
				$errors['idCargo'] = 1;
			if(strlen($cargo)==0)
				$errors['cargo'] = 1;
			if(strlen($descripcion)==0)
				$errors['descripcion'] = 1;
			
			if (count($errors) == 0){

				$result = $this->model->update($idCargo,$cargo, $descripcion);

				//Si pudo ser creado
				if ($result) {
					//$data = array($cargo, $descripcion);
					//Cargar la vista
					return json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
				}else{
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}
			}else{
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		*Listamos todos los cargos
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
		*obtenemos los datos de un cargo
		**/
		private function getCargo(){
			$idCargo = $this->validateNumber(isset($_POST['idCargo'])?$_POST['idCargo']:NULL);
			if($idCargo!==''){
				if(($result = $this->model->lists(-1,$idCargo))){
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
			require_once 'models/cargoMdl.php';
			$this->model = new CargoMdl();
		}
	}
?>