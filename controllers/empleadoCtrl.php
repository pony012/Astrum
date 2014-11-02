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
					case 'update':
						//Baja
						$this->update();
						break;
					default:
						# code...
						break;
				}
			else
				require_once 'views/permisosError.html';
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
						else{
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
										$celular);
						//Cargar la vista
						require_once 'views/empleadoInserted.php';
						}
					}else{
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
										$celular);
						//Cargar la vista
						require_once 'views/empleadoInserted.php';
					}
				}else{
					require_once 'views/empleadoInsertedError.html';
				}	
			}else{
				//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
				require_once 'views/empleadoInsertedError.html';
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
				require_once 'views/empleadoDeleteError.html';
			else{
				if($result = $this->model->delete($idEmpleado))
					require_once 'views/empleadoDelete.html';
				else
					require_once 'views/empleadoDeleteError.html';
			}
		}

		/**
		*Activa a un determinado empleado
		**/
		private function active(){
			$idEmpleado	= $this->validateNumber(isset($_POST['idEmpleado'])?$_POST['idEmpleado']:NULL);
			if(strlen($idEmpleado)==0)
				require_once 'views/empleadoActiveError.html';
			else{
				if($result = $this->model->active($idEmpleado))
					require_once 'views/empleadoActive.html';
				else
					require_once 'views/empleadoActiveError.html';
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
											$foto,
											$email,
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
									$foto,
									$email,
									$telefono,
									$celular);
					//Cargar la vista
					require_once 'views/empleadoUpdated.php';
				}else{
					require_once 'views/empleadoUpdatedError.html';
				}	
			}else{
				//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
				require_once 'views/empleadoUpdatedError.html';
			}

		}

		/**
		*listamos todos los empleados
		**/
		private function lists(){
			if($result = $this->model->lists()){

				$data = array($result);

				require_once 'views/empleadoSelected.php';
				
			}else
				require_once 'views/empleadoSelectedError.html';
		}

		/**
		* Llama al formulario para la creación de un empleado
		*/
		private function createF(){
			$this->session['action']='create';
			print_r($this->twig);
			//$template = $this->twig->loadTemplate('empleadoForm.html');
			//$template->render(array('session'=>$this->session));
		}

		function __construct(){
			parent::__construct();
			require_once 'models/empleadoMdl.php';
			$this->model = new EmpleadoMdl();
		}
	}
?>
