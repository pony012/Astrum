<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Producto
	*/
	class ExistenciaCtrl extends BaseCtrl
	{
		/**
		 * Ejecuta acciones basado en la accion seleccionada por los agrumentos
		 */
		public function run()
		{
			switch ($_GET['act']) {
				case 'create':
					//Crear 
					$this->create();
					break;
				case 'lists':
					//Listar 
					$this->lists();
					break;
				case 'get':
					$this->getExistencia();
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
			if ($this->api) {
				$errors = array();

				$idProductoServicio = $this->validateNumber(isset($_POST['idProductoServicio'])?$_POST['idProductoServicio']:NULL);
				$precioUnitario 	= $this->validateNumber(isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
				$cantidad 			= $this->validateNumber(isset($_POST['cantidad'])?$_POST['cantidad']:NULL);

				if(strlen($idProductoServicio)==0)
					$errors['idProductoServicio'] = 1;
				if(strlen($precioUnitario)==0)
					$errors['precioUnitario'] = 1;
				if(strlen($cantidad)==0)
					$errors['cantidad'] = 1;
				
				if (count($errors) == 0){

					$result = $this->model->create($idProductoServicio,$precioUnitario,$precioUnitario,$cantidad);

					//Si pudo ser creado
					if ($result) {
						//$data = array($idProductoServicio,$precioUnitario,$precioUnitario,$cantidad);
						//Cargar la vista
						echo json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
					}else{
						echo json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
					}	
				}else{
					//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
					echo json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}
			}else{
				$this->session['action']='create';
				$template = $this->twig->loadTemplate('existenciaForm.html');
				echo $template->render(array('session'=>$this->session));
			}
		}

		private function read(){

		}

		private function delete(){

		}

		private function update(){

		}

		/**
		*Listamos todas las Existencias de productos registrados
		**/
		private function lists(){
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
			if($offset!==''){ 
				if(($result = $this->model->lists($offset))){
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
		*obtenemos los datos especificos de la existencia de un producto
		**/
		private function getExistencia(){
			$idExistencia = $this->validateNumber(isset($_POST['idExistencia'])?$_POST['idExistencia']:NULL);
			if($idExistencia!==''){
				if(($result = $this->model->lists(-1,$idExistencia))){
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
			require_once 'models/existenciaMdl.php';
			$this->model = new ExistenciaMdl();
		}
	}
?>