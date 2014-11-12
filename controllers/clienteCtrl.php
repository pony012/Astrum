<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Cliente
	*/
	class ClienteCtrl extends BaseCtrl
	{
		/**
		 * Ejecuta acciones basado en la accion seleccionada por los agrumentos
		 */
		public function run()
		{	
			switch ($_GET['act']) {
				case 'create':
					//Crear un Cliente
					$this->create();
					break;
				case 'createF':
					//Crear un cliente
					$this->createF();
					break;
				case 'lists':
					//Listar
					$this->lists();
					break;
				case 'get':
					$this->getCliente();
					break;
				case 'listsDeleters':
					//Listar
					$this->listsDeleters();
					break;
				case 'getDeleter':
					$this->getClienteDeleter();
					break;
				case 'delete':
					//Baja
					if(BaseCtrl::isAdmin())
						$this->delete();
					else
						return json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
					break;
				case 'update':
					//Baja
					if(BaseCtrl::isAdmin())
						$this->update();
					else
						return json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
					break;
				case 'active':
					//Baja
					if(BaseCtrl::isAdmin())
						$this->active();
					else
						return json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
					break;
				case 'updateF':
						$this->updateF();
						break;
				default:
					return json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
					break;
			}
		}
		/**
		* Crea un Cliente
		*/
		private function create(){
			
			$errors = array();

			$nombre 			= $this->validateName(isset($_POST['nombre'])?$_POST['nombre']:NULL);
			$apellidoPaterno 	= $this->validateName(isset($_POST['apellidoPaterno'])?$_POST['apellidoPaterno']:NULL);
			$apellidoMaterno	= $this->validateName(isset($_POST['apellidoMaterno'])?$_POST['apellidoMaterno']:NULL);
			$calle				= $this->validateText(isset($_POST['calle'])?$_POST['calle']:NULL);
			$numExterior		= $this->validateText(isset($_POST['numExterior'])?$_POST['numExterior']:NULL);
			$numInterior		= $this->validateText(isset($_POST['numInterior'])?$_POST['numInterior']:NULL);
			$colonia			= $this->validateText(isset($_POST['colonia'])?$_POST['colonia']:NULL);
			$codigoPostal		= $this->validateNumber(isset($_POST['codigoPostal'])?$_POST['codigoPostal']:NULL);
			$email				= $this->validateEmail(isset($_POST['email'])?$_POST['email']:NULL);
			$telefono			= $this->validatePhone(isset($_POST['telefono'])?$_POST['telefono']:NULL);
			$celular			= $this->validatePhone(isset($_POST['celular'])?$_POST['celular']:NULL);

			if(strlen($nombre)==0)
				$errors['nombre'] = 1;
			if(strlen($apellidoPaterno)==0)
				$errors['apellidoPaterno'] = 1;
			if(strlen($apellidoMaterno)==0)
				$errors['apellidoMaterno'] = 1;
			if(strlen($calle)==0)
				$errors['calle'] = 1;
			if(strlen($numExterior)==0)
				$errors['numExterior'] = 1;
			if(strlen($colonia)==0)
				$errors['colonia'] = 1;
			if(strlen($codigoPostal)==0)
				$errors['codigoPostal'] = 1;

			if (count($errors) == 0) {
				$result = $this->model->create(	$nombre, 
											$apellidoPaterno, 
											$apellidoMaterno,
											$calle,
											$numExterior,
											$numInterior,
											$colonia,
											$codigoPostal,
											$email,
											$telefono,
											$celular);

				//Si pudo ser creado
				if ($result) {
					
					/*$data = array(	$nombre, 
									$apellidoPaterno, 
									$apellidoMaterno,
									$calle,
									$numExterior,
									$numInterior,
									$colonia,
									$codigoPostal,
									$email,
									$telefono,
									$celular);*/
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

		/**
		*Da de baja a un determinado cliente
		**/
		private function delete(){
			$idCliente	= $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
			if(strlen($idCliente)==0)
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->delete($idCliente))
					return json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
				else
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
			}
		}

		/**
		*Activa a un determinado cliente
		**/
		private function active(){
			$idCliente	= $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
			if(strlen($idCliente)==0)
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->active($idCliente))
					return json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
				else
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
			}
		}

		private function update(){
			$errors = array();

			$idCliente			= $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
			$nombre 			= $this->validateName(isset($_POST['nombre'])?$_POST['nombre']:NULL);
			$apellidoPaterno 	= $this->validateName(isset($_POST['apellidoPaterno'])?$_POST['apellidoPaterno']:NULL);
			$apellidoMaterno	= $this->validateName(isset($_POST['apellidoMaterno'])?$_POST['apellidoMaterno']:NULL);
			$calle				= $this->validateText(isset($_POST['calle'])?$_POST['calle']:NULL);
			$numExterior		= $this->validateText(isset($_POST['numExterior'])?$_POST['numExterior']:NULL);
			$numInterior		= $this->validateText(isset($_POST['numInterior'])?$_POST['numInterior']:NULL);
			$colonia			= $this->validateText(isset($_POST['colonia'])?$_POST['colonia']:NULL);
			$codigoPostal		= $this->validateNumber(isset($_POST['codigoPostal'])?$_POST['codigoPostal']:NULL);
			$email				= $this->validateEmail(isset($_POST['email'])?$_POST['email']:NULL);
			$telefono			= $this->validatePhone(isset($_POST['telefono'])?$_POST['telefono']:NULL);
			$celular			= $this->validatePhone(isset($_POST['celular'])?$_POST['celular']:NULL);

			if(strlen($idCliente)==0)
				$errors['idCliente'] = 1;
			if(strlen($nombre)==0)
				$errors['nombre'] = 1;
			if(strlen($apellidoPaterno)==0)
				$errors['apellidoPaterno'] = 1;
			if(strlen($apellidoMaterno)==0)
				$errors['apellidoMaterno'] = 1;
			if(strlen($calle)==0)
				$errors['calle'] = 1;
			if(strlen($numExterior)==0)
				$errors['numExterior'] = 1;
			if(strlen($colonia)==0)
				$errors['colonia'] = 1;
			if(strlen($codigoPostal)==0)
				$errors['codigoPostal'] = 1;

			if (count($errors) == 0) {
				$result = $this->model->update(	$idCliente,$nombre, 
											$apellidoPaterno, 
											$apellidoMaterno,
											$calle,
											$numExterior,
											$numInterior,
											$colonia,
											$codigoPostal,
											$email,
											$telefono,
											$celular);

				//Si pudo ser creado
				if ($result) {
					return json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
					/*$data = array(	$nombre, 
									$apellidoPaterno, 
									$apellidoMaterno,
									$calle,
									$numExterior,
									$numInterior,
									$colonia,
									$codigoPostal,
									$email,
									$telefono,
									$celular);*/
					//Cargar la vista
				}else{
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}	
			}else{
				//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		*Listamos todos los Clientes
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
		*obtenemos los datos de un cliente
		**/
		private function getCliente(){
			$idCliente = $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
			if($idCliente!==''){
				if(($result = $this->model->lists(-1,$idCliente))){
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
		*Listamos todos los Clientes eliminados
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
		*obtenemos los datos de un cliente eliminado
		**/
		private function getClienteDeleter(){
			$idCliente = $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
			if($idCliente!==''){
				if(($result = $this->model->listsDeleters(-1,$idCliente))){
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
		* Llama al formulario para la creación de un cliente
		*/
		private function createF(){
			$this->session['action']='create';
			$template = $this->twig->loadTemplate('clienteForm.html');
			echo $template->render(array('session'=>$this->session));
		}

		/**
		* Llama al formulario para la actualización de un cliente
		*/
		private function updateF(){
			//TODO
			//Cargar en $data desde la base de datos
			$data = $this->model->get(1);
			if($data){
				$this->session['action']='update';
				$template = $this->twig->loadTemplate('clienteForm.html');
				echo $template->render(array('session'=>$this->session,'data'=>$data));
			}else{
				//TODO
				//Enviar a listar clientes con vista de inválido
				//echo 'Error';
			}
		}

		function __construct(){
			parent::__construct();
			require_once 'models/clienteMdl.php';
			$this->model = new ClienteMdl();
		}
	}
?>
