<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Proveedor
	*/
	class ProveedorCtrl extends BaseCtrl
	{
		/**
		 * Ejecuta acciones basado en la accion seleccionada por los agrumentos
		 */
		public function run()
		{
			switch ($_GET['act']) {
				case 'create':
					//Crear proveedor
					$this->create();
					break;
				case 'createF':
						//Crear un proveedor
						$this->createF();
						break;
				case 'lists':
					//Listar Proveedores
					$this->lists();
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
				case 'updateF':
					//Actualizar un proveedor
					if(BaseCtrl::isAdmin())
						$this->updateF();
					else
						return json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
					break;
				case 'get':
					//Obtener un proveedor
					$this->getProveedor();
					break;
				case 'listsDeleters':
					//Lista los proveedores
					$this->listsDeleters();
					break;
				case 'getDeleter':
					//Obtener un proveedor
					$this->getProveedorDeleter();
					break;
				default:
					return json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
					break;
			}
		}
		/**
		* Crea un proveedor
		*/
		private function create(){
			
			$errors = array();

			$nombre 			= $this->validateName(isset($_POST['nombre'])?$_POST['nombre']:NULL);
			$apellidoPaterno 	= $this->validateName(isset($_POST['apellidoPaterno'])?$_POST['apellidoPaterno']:NULL);
			$apellidoMaterno	= $this->validateName(isset($_POST['apellidoMaterno'])?$_POST['apellidoMaterno']:NULL);
			$RFC				= $this->validateText(isset($_POST['RFC'])?$_POST['RFC']:NULL);
			$calle				= $this->validateText(isset($_POST['calle'])?$_POST['calle']:NULL);
			$numExterior		= $this->validateText(isset($_POST['numExterior'])?$_POST['numExterior']:NULL);
			$numInterior		= $this->validateText(isset($_POST['numInterior'])?$_POST['numInterior']:NULL);
			$colonia			= $this->validateText(isset($_POST['colonia'])?$_POST['colonia']:NULL);
			$codigoPostal		= $this->validateNumber(isset($_POST['codigoPostal'])?$_POST['codigoPostal']:NULL);
			$foto				= $this->validateText(isset($_POST['foto'])?$_POST['foto']:NULL);
			$email				= $this->validateEmail(isset($_POST['email'])?$_POST['email']:NULL);
			$telefono			= $this->validatePhone(isset($_POST['telefono'])?$_POST['telefono']:NULL);
			$celular			= $this->validatePhone(isset($_POST['celular'])?$_POST['celular']:NULL);

			if(strlen($nombre)==0)
				$errors['nombre'] = 1;
			if(strlen($apellidoPaterno)==0)
				$errors['apellidoPaterno'] = 1;
			if(strlen($apellidoMaterno)==0)
				$errors['apellidoMaterno'] = 1;
			if(strlen($RFC)==0)
				$errors['RFC'] = 1;
			if(strlen($calle)==0)
				$errors['calle'] = 1;
			if(strlen($colonia)==0)
				$errors['colonia'] = 1;
			if(strlen($codigoPostal)==0)
				$errors['codigoPostal'] = 1;

			if (count($errors) == 0) {
				$result = $this->model->create(	$nombre, 
											$apellidoPaterno, 
											$apellidoMaterno,
											$RFC,
											$calle,
											$numExterior,
											$numInterior,
											$colonia,
											$codigoPostal,
											$foto,
											$email,
											$telefono,
											$celular);
				//Si pudo ser creado
				if ($result) {
					//Guardamos los campos en un arreglo
					$data = array(	$nombre, 
									$apellidoPaterno, 
									$apellidoMaterno,
									$RFC,
									$calle,
									$numExterior,
									$numInterior,
									$colonia,
									$codigoPostal,
									$foto,
									$email,
									$telefono,
									$celular);
					//Cargar la vista
					return json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				}else{
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
				}
			}else{
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		private function read(){

		}

		/**
		*Da de baja a un determinado proveedor
		**/
		private function delete(){
			$idProveedor	= $this->validateNumber(isset($_POST['idProveedor'])?$_POST['idProveedor']:NULL);
			if(strlen($idProveedor)==0)
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->delete($idProveedor))
					return json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				else
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
			}
		}

		/**
		*Activa a un determinado proveedor
		**/
		private function active(){
			$idProveedor	= $this->validateNumber(isset($_POST['idProveedor'])?$_POST['idProveedor']:NULL);
			if(strlen($idProveedor)==0)
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->active($idProveedor))
					return json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				else
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
			}
		}

		private function update(){
			$errors = array();

			$idProveedor		= $this->validateNumber(isset($_POST['idProveedor'])?$_POST['idProveedor']:NULL);
			$nombre 			= $this->validateName(isset($_POST['nombre'])?$_POST['nombre']:NULL);
			$apellidoPaterno 	= $this->validateName(isset($_POST['apellidoPaterno'])?$_POST['apellidoPaterno']:NULL);
			$apellidoMaterno	= $this->validateName(isset($_POST['apellidoMaterno'])?$_POST['apellidoMaterno']:NULL);
			$RFC				= $this->validateText(isset($_POST['RFC'])?$_POST['RFC']:NULL);
			$calle				= $this->validateText(isset($_POST['calle'])?$_POST['calle']:NULL);
			$numExterior		= $this->validateText(isset($_POST['numExterior'])?$_POST['numExterior']:NULL);
			$numInterior		= $this->validateText(isset($_POST['numInterior'])?$_POST['numInterior']:NULL);
			$colonia			= $this->validateText(isset($_POST['colonia'])?$_POST['colonia']:NULL);
			$codigoPostal		= $this->validateNumber(isset($_POST['codigoPostal'])?$_POST['codigoPostal']:NULL);
			$foto				= $this->validateText(isset($_POST['foto'])?$_POST['foto']:NULL);
			$email				= $this->validateEmail(isset($_POST['email'])?$_POST['email']:NULL);
			$telefono			= $this->validatePhone(isset($_POST['telefono'])?$_POST['telefono']:NULL);
			$celular			= $this->validatePhone(isset($_POST['celular'])?$_POST['celular']:NULL);

			if(strlen($idProveedor)==0)
				$errors['idProveedor'] = 1;
			if(strlen($nombre)==0)
				$errors['nombre'] = 1;
			if(strlen($apellidoPaterno)==0)
				$errors['apellidoPaterno'] = 1;
			if(strlen($apellidoMaterno)==0)
				$errors['apellidoMaterno'] = 1;
			if(strlen($RFC)==0)
				$errors['RFC'] = 1;
			if(strlen($calle)==0)
				$errors['calle'] = 1;
			if(strlen($colonia)==0)
				$errors['colonia'] = 1;
			if(strlen($codigoPostal)==0)
				$errors['codigoPostal'] = 1;

			if (count($errors) == 0) {
				$result = $this->model->update(	$idProveedor,$nombre, 
											$apellidoPaterno, 
											$apellidoMaterno,
											$RFC,
											$calle,
											$numExterior,
											$numInterior,
											$colonia,
											$codigoPostal,
											$foto,
											$email,
											$telefono,
											$celular);
				//Si pudo ser actualizado
				if ($result) {
					//Guardamos los campos en un arreglo
					$data = array(	$nombre, 
									$apellidoPaterno, 
									$apellidoMaterno,
									$RFC,
									$calle,
									$numExterior,
									$numInterior,
									$colonia,
									$codigoPostal,
									$foto,
									$email,
									$telefono,
									$celular);
					//Cargar la vista
					return json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				}else{
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
				}
			}else{
				return json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		*listamos todos los proveedors activos
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
		*obtenemos los datos de un proveedor activo
		**/
		private function getProveedor(){
			$idProveedor = $this->validateNumber(isset($_POST['idProveedor'])?$_POST['idProveedor']:NULL);
			if($idProveedor!==''){
				if(($result = $this->model->lists(-1,$idProveedor))){
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
		*listamos todos los proveedors inactivos
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
		*obtenemos los datos de un proveedor inactivo
		**/
		private function getProveedorDeleter(){
			$idProveedor = $this->validateNumber(isset($_POST['idProveedor'])?$_POST['idProveedor']:NULL);
			if($idProveedor!==''){
				if(($result = $this->model->listsDeleters(-1,$idProveedor))){
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
		* Llama al formulario para la creación de un proveedor
		*/
		private function createF(){
			$this->session['action']='create';
			$template = $this->twig->loadTemplate('proveedorForm.html');
			echo $template->render(array('session'=>$this->session));
		}

		/**
		* Llama al formulario para la actualización de un proveedor
		*/
		private function updateF(){
			//TODO
			//Cargar en $data desde la base de datos
			$data = $this->model->get(1);
			if($data){
				$this->session['action']='update';
				$template = $this->twig->loadTemplate('proveedorForm.html');
				echo $template->render(array('session'=>$this->session,'data'=>$data));
			}else{
				//TODO
				//Enviar a listar clientes con vista de inválido
				//echo 'Error';
			}
		}

		function __construct(){
			parent::__construct();
			require_once 'models/proveedorMdl.php';
			$this->model = new ProveedorMdl();
		}
	}
?>
