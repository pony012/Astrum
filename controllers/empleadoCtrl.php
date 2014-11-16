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
						if ($this->api) {
							echo $this->json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
						}else{
							//CARGAR VISTA DE SERVICIO INEXISTENTE
						}
						break;
				}
			else{
				if ($this->api) {
					echo $this->json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
				}else{
					//CARGAR VISTA DE NO PERMITIDO
				}
			}
		}
		/**
		* Crea un Empleado
		*/
		private function create(){
			if ($this->api) {
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
				
				$uploadOk = 0;
				if(isset($_FILES["foto"])){
					$uploadOk = 1;
					$target_dir = getcwd()."/uploads/";
					//print_r($_FILES);
					$target_file = $target_dir.basename($_FILES["foto"]["name"]);
					$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					$check = getimagesize($_FILES["foto"]["tmp_name"]);
	    			if($check !== false) {
						if (file_exists($target_file)) {
						    //echo "Sorry, file already exists.";
						    $uploadOk = 0;
						}else{
							if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
								&& $imageFileType != "gif" ) {
							    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
							    $uploadOk = 0;
							}else{
								if (is_uploaded_file($_FILES["foto"]["tmp_name"])) {
									if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
								        $foto = $_FILES["foto"]["name"];
								        //echo($foto);
								    } else {
								       //echo "Sorry, there was an error uploading your file.";
								    }
								}
							}
						}
					}
				}
				if(!$uploadOk)
					$foto = '';
				
				//$foto				= $this->validateText(isset($_POST['foto'])?$_POST['foto']:NULL);
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
							if(!BaseCtrl::enviarCorreo($email,'Bienvenido a SpaDamaris','/views/emails/altaEmpleado.html',$remplazos))
								//CARGAR VISTA ERROR
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
							echo $this->json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
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
							echo $this->json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
						}
					}else{
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
					}	
				}else{
					//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}
			}else{
				$this->session['action']='create';
				$template = $this->twig->loadTemplate('empleadoForm.html');
				echo $template->render(array('session'=>$this->session));
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
				echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->delete($idEmpleado))
					echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				else
					echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
			}
		}

		/**
		*Activa a un determinado empleado
		**/
		private function active(){
			$idEmpleado	= $this->validateNumber(isset($_POST['idEmpleado'])?$_POST['idEmpleado']:NULL);
			if(strlen($idEmpleado)==0)
				echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->active($idEmpleado))
					echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				else
					echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
			}
		}

		private function update(){
			if ($this->api) {
				
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
				
				$uploadOk = 0;
				if(isset($_FILES["foto"])){
					$uploadOk = 1;
					$target_dir = getcwd()."/uploads/";
					//print_r($_FILES);
					$target_file = $target_dir.basename($_FILES["foto"]["name"]);
					$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					$check = getimagesize($_FILES["foto"]["tmp_name"]);
	    			if($check !== false) {
						if (file_exists($target_file)) {
						    //echo "Sorry, file already exists.";
						    $uploadOk = 0;
						}else{
							if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
								&& $imageFileType != "gif" ) {
							    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
							    $uploadOk = 0;
							}else{
								if (is_uploaded_file($_FILES["foto"]["tmp_name"])) {
									if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
								        $foto = $_FILES["foto"]["name"];
								        //echo($foto);
								    } else {
								       //echo "Sorry, there was an error uploading your file.";
								    }
								}
							}
						}
					}
				}
				if(!$uploadOk)
					$foto = '';
				
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
						/*$data = array(	$nombre, 
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
										$celular);*/
						//Cargar la vista
						echo $this->json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
					}else{
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
					}	
				}else{
					//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}
			}else{
				$data = $this->model->lists(-1, $_GET['idEmpleado']);
				if($data){
					$this->session['action']='update';
					$template = $this->twig->loadTemplate('empleadoForm.html');
					echo $template->render(array('session'=>$this->session,'data'=>$data[0]));
				}else{
					//TODO
					//Enviar a listar clientes con vista de inválido
					//echo 'Error';
				}
			}
		}

		/**
		*listamos todos los empleados activos
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
							//CARGAR VISTA VACIO
						}
					}else{
						if($this->api){
							echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
						}else{
							$this->session['action']='list';
							$template = $this->twig->loadTemplate('empleadoList.html');
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
		*obtenemos los datos de un empleado activo
		**/
		private function getEmpleado(){
			$idEmpleado = $this->validateNumber(isset($_POST['idEmpleado'])?$_POST['idEmpleado']:NULL);
			if($idEmpleado!==''){
				if(($result = $this->model->lists(-1,$idEmpleado))){
					if(is_numeric($result)){
						if ($this->api) {
							echo $this->json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
						}else{
							//CARGAR VISTA VACIO
						}
					}else{
						if($this->api){
							echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
						}else{
							//CARGAR VISTA OK
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
		*listamos todos los empleados inactivos
		**/
		private function listsDeleters(){
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
			if($offset!==''){ 
				if(($result = $this->model->listsDeleters($offset))){
					if(is_numeric($result)){
						if ($this->api) {
							echo $this->json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
						}else{
							//CARGAR VISTA VACIO
						}
					}else{
						if($this->api){
							echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
						}else{
							//CARGAR VISTA OK
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
		*obtenemos los datos de un empleado inactivo
		**/
		private function getEmpleadoDeleter(){
			$idEmpleado = $this->validateNumber(isset($_POST['idEmpleado'])?$_POST['idEmpleado']:NULL);
			if($idEmpleado!==''){
				if(($result = $this->model->listsDeleters(-1,$idEmpleado))){
					if(is_numeric($result)){
						if ($this->api) {
							echo $this->json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
						}else{
							//CARGAR VISTA VACIO
						}
					}else{
						if($this->api){
							echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
						}else{
							//CARGAR VISTA OK
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
			require_once 'models/empleadoMdl.php';
			$this->model = new EmpleadoMdl();
		}
	}
?>
