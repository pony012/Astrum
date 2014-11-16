<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Producto
	*/
	class AjusteSalidaTipoCtrl extends BaseCtrl
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
						else
							if ($this->api) {
								echo $this->json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
							}else{
								//CARGAR VISTA DE NO PERMITIDO
							}
						break;
					case 'lists':
						//Crear 
						$this->lists();
						break;
					case 'get':
						//Baja
						$this->getAjusteSalidaTipo();
						break;
					default:
						if ($this->api) {
							echo $this->json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
						}else{
							//CARGAR VISTA DE SERVICIO INEXISTENTE
						}
						break;
			}
		}
		/**
		* Crea un Producto
		*/
		private function create(){
			if($this->api){

				$errors = array();

				$tipo		    	= $this->validateText(isset($_POST['tipo'])?$_POST['tipo']:NULL);
				$exclusivoSistema	= $this->validateText(isset($_POST['exclusivoSistema'])?$_POST['exclusivoSistema']:NULL);
				$descripcion 		= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

				if(strlen($tipo)==0)
					$errors['tipo'] = 1;
				if(strlen($exclusivoSistema)==0)
					$errors['exclusivoSistema'] = 1;
				if(strlen($descripcion)==0)
					$errors['descripcion'] = 1;
				
				if (count($errors) == 0){

					$result = $this->model->create($tipo, $exclusivoSistema,$descripcion);

					//Si pudo ser creado
					if ($result) {
						//Cargar la vista
						echo $this->json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
					}else{
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
					}
				}else{
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}
			}else{
				$this->session['action']='create';
				$template = $this->twig->loadTemplate('ajusteSalidaTipoForm.html');
				echo $template->render(array('session'=>$this->session));
			}
		}

		private function read(){

		}

		private function delete(){

		}

		private function update(){
			if($this->api){

				$errors = array();

				$idAjusteSalidaTipo = $this->validateNumber(isset($_POST['idAjusteSalidaTipo'])?$_POST['idAjusteSalidaTipo']:NULL);
				$tipo		    	= $this->validateText(isset($_POST['tipo'])?$_POST['tipo']:NULL);
				$exclusivoSistema	= $this->validateText(isset($_POST['exclusivoSistema'])?$_POST['exclusivoSistema']:NULL);
				$descripcion 		= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

				if(strlen($idAjusteSalidaTipo)==0)
					$errors['idAjusteSalidaTipo'] = 1;
				if(strlen($tipo)==0)
					$errors['tipo'] = 1;
				if(strlen($exclusivoSistema)==0)
					$errors['exclusivoSistema'] = 1;
				if(strlen($descripcion)==0)
					$errors['descripcion'] = 1;
				
				if (count($errors) == 0){

					$result = $this->model->update($idAjusteSalidaTipo,$tipo, $exclusivoSistema,$descripcion);

					//Si pudo ser creado
					if ($result) {
						//$data = array($cargo, $descripcion);
						//Cargar la vista
						echo $this->json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
					}else{
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
					}
				}else{
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}
			}else{
				//TODO
				//Cargar en $data desde la base de datos
				$data = $this->model->get(1);
				if($data){
					$this->session['action']='update';
					$template = $this->twig->loadTemplate('ajusteSalidaTipoForm.html');
					echo $template->render(array('session'=>$this->session,'data'=>$data));
				}else{
					//TODO
					//Enviar a listar clientes con vista de inválido
					//echo 'Error';
				}
			}
		}

		/**
		*Listamos todos los tipos de ajustes de Salida
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
		*obtenemos los datos de un tipo de ajuste de Salida
		**/
		private function getAjusteSalidaTipo(){
			$idAjusteSalidaTipo = $this->validateNumber(isset($_POST['idAjusteSalidaTipo'])?$_POST['idAjusteSalidaTipo']:NULL);
			if($idAjusteSalidaTipo!==''){
				if(($result = $this->model->lists(-1,$idAjusteSalidaTipo))){
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
					echo "string";
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}else{
					//CARGAR VISTA FORMATO INCORRECTO
				}
			}
		}

		function __construct(){
			parent::__construct();
			require_once 'models/ajusteSalidaTipoMdl.php';
			$this->model = new AjusteSalidaTipoMdl();
		}
	}
?>