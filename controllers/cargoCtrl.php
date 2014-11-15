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
					case 'update':
						//Actualizar
						if(BaseCtrl::isAdmin())
							$this->update();
						else
							echo json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
						break;
					case 'updateF':
						//Actualizar
						if(BaseCtrl::isAdmin())
							$this->updateF();
						else
							echo json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
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
						echo json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
						break;
				}
			else
				echo json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
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
					echo json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
				}else{
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}
			}else{
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
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
					echo json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
				}else{
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}
			}else{
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
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
		*obtenemos los datos de un cargo
		**/
		private function getCargo(){
			$idCargo = $this->validateNumber(isset($_POST['idCargo'])?$_POST['idCargo']:NULL);
			if($idCargo!==''){
				if(($result = $this->model->lists(-1,$idCargo))){
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
		* Llama al formulario para la creación de un Cargo
		*/
		private function createF(){
			$this->session['action']='create';
			$template = $this->twig->loadTemplate('cargoForm.html');
			echo $template->render(array('session'=>$this->session));
		}

		/**
		* Llama al formulario para la actualización de un Cargo
		*/
		private function updateF(){
			//TODO
			//Cargar en $data desde la base de datos
			$data = $this->model->get(1);
			if($data){
				$this->session['action']='update';
				$template = $this->twig->loadTemplate('cargoForm.html');
				echo $template->render(array('session'=>$this->session,'data'=>$data));
			}else{
				//TODO
				//Enviar a listar clientes con vista de inválido
				//echo 'Error';
			}
		}

		function __construct(){
			parent::__construct();
			require_once 'models/cargoMdl.php';
			$this->model = new CargoMdl();
		}
	}
?>