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
			if(BaseCtrl::isLoged())
				switch ($_GET['act']) {
					case 'create':
						//Crear un Cliente
						$this->create();
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
						else{
							if ($this->api) {
								echo $this->json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
							}else{
								//CARGAR VISTA DE NO PERMITIDO
							}
						}
						break;
					case 'update':
						//Actualizar
						if(BaseCtrl::isAdmin())
							$this->update();
						else{
							if ($this->api) {
								echo $this->json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
							}else{
								//CARGAR VISTA DE NO PERMITIDO
							}
						}
						break;
					case 'active':
						//Baja
						if(BaseCtrl::isAdmin())
							$this->active();
						else{
							if ($this->api) {
								echo $this->json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
							}else{
								//CARGAR VISTA DE NO PERMITIDO
							}
						}
						break;
					default:
						if ($this->api) {
							echo $this->json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
						}else{
							//CARGAR VISTA DE SERVICIO INEXISTENTE
						}
						break;
				}
			else
				if ($this->api) {
					echo $this->json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
				}else{
					//CARGAR VISTA DE NO PERMITIDO
				}
		}

		/**
		* Crea un Cliente
		*/
		private function create(){
			if($this->api){
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
						echo $this->json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
					}else{
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
					}	
				}else{
					//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}
			}else{
				$this->session['action']='create';
				$template = $this->twig->loadTemplate('clienteForm.html');
				echo $template->render(array('session'=>$this->session));
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
				echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->delete($idCliente))
					echo $this->json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
				else
					echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
			}
		}

		/**
		*Activa a un determinado cliente
		**/
		private function active(){
			$idCliente	= $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
			if(strlen($idCliente)==0)
				echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->active($idCliente))
					echo $this->json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
				else
					echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
			}
		}

		private function update(){
			if($this->api){
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
						echo $this->json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
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
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
					}	
				}else{
					//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}
			}else{
				//TODO
				//Cargar en $data desde la base de datos
				$data = $this->model->lists(-1, $_GET['id']);
				if($data){
					$this->session['action']='update';
					$template = $this->twig->loadTemplate('clienteForm.html');
					echo $template->render(array('session'=>$this->session,'data'=>$data[0]));
				}else{
					//TODO
					//Enviar a listar clientes con vista de inválido
					//echo 'Error';
				}
			}
		}

		/**
		*Listamos todos los Clientes
		**/
		private function lists(){
			$constrain = '';
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
			$idCliente = $this->validateNumber(isset($_GET['id'])?$_GET['id']:NULL);
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
				if ($idCliente!=='') {
					if(($result = $this->model->lists($offset,$idCliente,$constrain))){
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
								$this->session['action']='list';
								$template = $this->twig->loadTemplate('clienteForm.html');
								echo $template->render(array('session'=>$this->session,'data'=>$result[0]));
							}
						}
					}else{
						if($this->api){
							echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
						}else{
							//CARGAR VISTA FORMATO INCORRECTO
						}
					}
				}else if(($result = $this->model->lists($offset,-1,$constrain))){
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
							$this->session['action']='list';
							$template = $this->twig->loadTemplate('clienteList.html');
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
		*obtenemos los datos de un cliente
		**/
		private function getCliente(){
			$idCliente = $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
			if($idCliente!==''){
				if(($result = $this->model->lists(-1,$idCliente))){
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
							$template = $this->twig->loadTemplate('clienteList.html');
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
		*Listamos todos los Clientes eliminados
		**/
		private function listsDeleters(){
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
			if($offset!==''){ 
				if(($result = $this->model->listsDeleters($offset))){
					//var_dump($result);
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
							$template = $this->twig->loadTemplate('clienteList.html');
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
		*obtenemos los datos de un cliente eliminado
		**/
		private function getClienteDeleter(){
			$idCliente = $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
			if($idCliente!==''){
				if(($result = $this->model->listsDeleters(-1,$idCliente))){
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
							$template = $this->twig->loadTemplate('clienteList.html');
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
		* Llama al formulario para la actualización de un cliente
		*/
		private function updateFP(){
			//TODO
			//Cargar en $data desde la base de datos
			$data = $this->model->get(1);
			if($data){
				//Obtener la vista
				$vista		= file_get_contents("views/clienteFormP.html");
				$headerP	= file_get_contents("views/headerP.html");
				$footerP		= file_get_contents("views/footerP.html");

				$diccionario = array(
					'{idCliente}' 		=> $data['IDCliente'],
					'{nombre}' 			=> $data['Nombre'],
					'{apellidoPaterno}' => $data['ApellidoPaterno'],
					'{apellidoMaterno}' => $data['ApellidoMaterno'],
					'{colonia}' 		=> $data['Colonia'],
					'{calle}' 			=> $data['Calle'],
					'{numExterior}'		=> $data['NumExterior'],
					'{numInterior}'		=> $data['NumInterior'],
					'{codigoPostal}'	=> $data['CP'],
					'{email}'			=> $data['Email'],
					'{telefono}'		=> $data['Telefono'],
					'{celular}'			=> $data['Celular']
					);

				$vista = strtr($vista,$diccionario);

				echo $headerP.$vista.$footerP;

				/*$this->session['action']='update';
				$template = $this->twig->loadTemplate('clienteForm.html');
				echo $template->render(array('session'=>$this->session,'data'=>$data));*/
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
