<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Empleado
	*/
	class EmpleadoCtrl extends BaseCtrl
	{
		/**
		 * Ejecuta acciones basado en la accion seleccionada por los agrumentos
		 */
		public function run()
		{
			
			if(BaseCtrl::isAdmin())
				switch ($_GET['act']) {
					case 'create':
						//Crear un Empleado
						$this->create();
						break;
					case 'createF':
						//Crear un Empleado
						$this->createF();
						break;
					case 'lists':
						$this->lists();
						break;
					case 'delete':
						$this->delete();
						break;
					case 'active':
						$this->active();
						break;
					case 'update':
						//Baja
						$this->update();
						break;
					case 'updateF':
						//Baja
						$this->updateF();
						break;
					case 'get':
						$this->getEmpleado();
						break;
					case 'listsDeleters':
						$this->listsDeleters();
						break;
					case 'getDeleter':
						$this->getEmpleadoDeleter();
						break;
					default:
						echo json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
						break;
				}
			else
				echo json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
		}
		/**
		* Crea un Empleado
		*/
		private function create(){
			
			$errors = array();

			$nombre 			= $this->validateName(isset($_POST['nombre'])?$_POST['nombre']:NULL);
			$apellidoPaterno 	= $this->validateName(isset($_POST['apellidoPaterno'])?$_POST['apellidoPaterno']:NULL);
			$apellidoMaterno	= $this->validateName(isset($_POST['apellidoMaterno'])?$_POST['apellidoMaterno']:NULL);
			$usuario			= $this->validateText(isset($_POST['usuario'])?$_POST['usuario']:NULL);
			$idCargo			= $this->validateNumber(isset($_POST['idCargo'])?$_POST['idCargo']:NULL);
			$calle				= $this->validateText(isset($_POST['calle'])?$_POST['calle']:NULL);
			$numExterior		= $this->validateText(isset($_POST['numExterior'])?$_POST['numExterior']:NULL);
			$numInterior		= $this->validateText(isset($_POST['numInterior'])?$_POST['numInterior']:NULL);
			$colonia			= $this->validateText(isset($_POST['colonia'])?$_POST['colonia']:NULL);
			$codigoPostal		= $this->validateNumber(isset($_POST['codigoPostal'])?$_POST['codigoPostal']:NULL);
			$foto				= $this->validateText(isset($_POST['foto'])?$_POST['foto']:NULL);
			$email				= $this->validateEmail(isset($_POST['email'])?$_POST['email']:NULL);
			$telefono			= $this->validatePhone(isset($_POST['telefono'])?$_POST['telefono']:NULL);
			$celular			= $this->validatePhone(isset($_POST['celular'])?$_POST['celular']:NULL);
			$contrasena 		= sha1(chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)));
			if(strlen($nombre)==0)
				$errors['nombre'] = 1;
			if(strlen($apellidoPaterno)==0)
				$errors['apellidoPaterno'] = 1;
			if(strlen($apellidoMaterno)==0)
				$errors['apellidoMaterno'] = 1;
			if(strlen($usuario)==0)
				$errors['usuario'] = 1;
			if(strlen($idCargo)==0)
				$errors['idCargo'] = 1;
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
											$usuario,
											$contrasena,
											$idCargo,
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
					if($email !== NULL){
						$remplazos = array(
						'$@Nombre@$' => $nombre,
						'$@Usuario@$' => $usuario,
						'$@Contrasena@$' => $contrasena
						);
						if(!BaseCtrl::enviarCorreo($email,'Bienvenido a SpaDamaris','../views/emails/altaEmpleado.html',$remplazos))
							require_once 'views/empleadoInsertedError.html';
						else{/*
							$data = array(	$nombre, 
										$apellidoPaterno, 
										$apellidoMaterno,
										$usuario,
										$contrasena,
										$idCargo,
										$calle,
										$numExterior,
										$numInterior,
										$colonia,
										$codigoPostal,
										$foto,
										$email,
										$telefono,
										$celular);*/
						//Cargar la vista
						echo json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
						}
					}else{/*
						$data = array(	$nombre, 
										$apellidoPaterno, 
										$apellidoMaterno,
										$usuario,
										$contrasena,
										$idCargo,
										$calle,
										$numExterior,
										$numInterior,
										$colonia,
										$codigoPostal,
										$foto,
										$email,
										$telefono,
										$celular);*/
						//Cargar la vista
						echo json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
					}
				}else{
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
				}	
			}else{
				//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		private function read(){

		}
		
		/**
		*Da de baja a un determinado empleado
		**/
		private function delete(){
			$idEmpleado	= $this->validateNumber(isset($_POST['idEmpleado'])?$_POST['idEmpleado']:NULL);
			if(strlen($idEmpleado)==0)
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->delete($idEmpleado))
					echo json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				else
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
			}
		}

		/**
		*Activa a un determinado empleado
		**/
		private function active(){
			$idEmpleado	= $this->validateNumber(isset($_POST['idEmpleado'])?$_POST['idEmpleado']:NULL);
			if(strlen($idEmpleado)==0)
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->active($idEmpleado))
					echo json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				else
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
			}
		}

		private function update(){
			$errors = array();

			$idEmpleado			= $this->validateNumber(isset($_POST['idEmpleado'])?$_POST['idEmpleado']:NULL);
			$nombre 			= $this->validateName(isset($_POST['nombre'])?$_POST['nombre']:NULL);
			$apellidoPaterno 	= $this->validateName(isset($_POST['apellidoPaterno'])?$_POST['apellidoPaterno']:NULL);
			$apellidoMaterno	= $this->validateName(isset($_POST['apellidoMaterno'])?$_POST['apellidoMaterno']:NULL);
			$usuario			= $this->validateText(isset($_POST['usuario'])?$_POST['usuario']:NULL);
			$contrasena			= $this->validateText(isset($_POST['contrasena'])?$_POST['contrasena']:NULL);
			$idCargo			= $this->validateNumber(isset($_POST['idCargo'])?$_POST['idCargo']:NULL);
			$calle				= $this->validateText(isset($_POST['calle'])?$_POST['calle']:NULL);
			$numExterior		= $this->validateText(isset($_POST['numExterior'])?$_POST['numExterior']:NULL);
			$numInterior		= $this->validateText(isset($_POST['numInterior'])?$_POST['numInterior']:NULL);
			$colonia			= $this->validateText(isset($_POST['colonia'])?$_POST['colonia']:NULL);
			$codigoPostal		= $this->validateNumber(isset($_POST['codigoPostal'])?$_POST['codigoPostal']:NULL);
			$foto				= $this->validateText(isset($_POST['foto'])?$_POST['foto']:NULL);
			$email				= $this->validateEmail(isset($_POST['email'])?$_POST['email']:NULL);
			$telefono			= $this->validatePhone(isset($_POST['telefono'])?$_POST['telefono']:NULL);
			$celular			= $this->validatePhone(isset($_POST['celular'])?$_POST['celular']:NULL);

			if(strlen($idEmpleado)==0)
				$errors['idEmpleado'] = 1;
			if(strlen($nombre)==0)
				$errors['nombre'] = 1;
			if(strlen($apellidoPaterno)==0)
				$errors['apellidoPaterno'] = 1;
			if(strlen($apellidoMaterno)==0)
				$errors['apellidoMaterno'] = 1;
			if(strlen($usuario)==0)
				$errors['usuario'] = 1;
			if(strlen($contrasena)==0)
				$errors['contrasena'] = 1;
			if(strlen($idCargo)==0)
				$errors['idCargo'] = 1;
			if(strlen($calle)==0)
				$errors['calle'] = 1;
			if(strlen($numExterior)==0)
				$errors['numExterior'] = 1;
			if(strlen($colonia)==0)
				$errors['colonia'] = 1;
			if(strlen($codigoPostal)==0)
				$errors['codigoPostal'] = 1;
			if(strlen($email)==0)
				$errors['email'] = 1;

			
			if (count($errors) == 0) {
				$result = $this->model->update($idEmpleado,$nombre, 
											$apellidoPaterno, 
											$apellidoMaterno,
											$usuario,
											$contrasena,
											$idCargo,
											$calle,
											$numExterior,
											$numInterior,
											$colonia,
											$codigoPostal,
											$email,
											$foto,
											$telefono,
											$celular);

				//Si pudo ser actualizado
				if ($result) {
					$data = array(	$nombre, 
									$apellidoPaterno, 
									$apellidoMaterno,
									$usuario,
									$contrasena,
									$idCargo,
									$calle,
									$numExterior,
									$numInterior,
									$colonia,
									$codigoPostal,
									$email,
									$foto,
									$telefono,
									$celular);
					//Cargar la vista
					echo json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				}else{
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
				}	
			}else{
				//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		*listamos todos los empleados activos
		**/
		private function lists(){
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
			if($offset!==''){ 
				if(($result = $this->model->lists($offset))){
					if(is_numeric($result)){
						echo json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
					}else{
						//print_r($result);
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
		*obtenemos los datos de un empleado activo
		**/
		private function getEmpleado(){
			$idEmpleado = $this->validateNumber(isset($_POST['idEmpleado'])?$_POST['idEmpleado']:NULL);
			if($idEmpleado!==''){
				if(($result = $this->model->lists(-1,$idEmpleado))){
					if(is_numeric($result)){
						echo json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
					}else{
						echo json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
					}
				}else{
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}
			}else{
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		*listamos todos los empleados inactivos
		**/
		private function listsDeleters(){
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
			if($offset!==''){ 
				if(($result = $this->model->listsDeleters($offset))){
					if(is_numeric($result)){
						echo json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
					}else{
						echo json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
					}
				}else{
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}
			}else{
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		*obtenemos los datos de un empleado inactivo
		**/
		private function getEmpleadoDeleter(){
			$idEmpleado = $this->validateNumber(isset($_POST['idEmpleado'])?$_POST['idEmpleado']:NULL);
			if($idEmpleado!==''){
				if(($result = $this->model->listsDeleters(-1,$idEmpleado))){
					if(is_numeric($result)){
						echo json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
					}else{
						echo json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
					}
				}else{
					echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
				}
			}else{
				echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			}
		}

		/**
		* Llama al formulario para la creación de un empleado
		*/
		private function createF(){
			$this->session['action']='create';
			$template = $this->twig->loadTemplate('empleadoForm.html');
			echo $template->render(array('session'=>$this->session));
		}

		/**
		* Llama al formulario para la actualización de un empleado
		*/
		private function updateF(){
			//TODO
			//Cargar en $data desde la base de datos
			$data = $this->model->get(1);
			if($data){
				$this->session['action']='update';
				$template = $this->twig->loadTemplate('empleadoForm.html');
				echo $template->render(array('session'=>$this->session,'data'=>$data));
			}else{
				//TODO
				//Enviar a listar clientes con vista de inválido
				//echo 'Error';
			}
		}

		function __construct(){
			parent::__construct();
			require_once 'models/empleadoMdl.php';
			$this->model = new EmpleadoMdl();
		}
	}
?>
