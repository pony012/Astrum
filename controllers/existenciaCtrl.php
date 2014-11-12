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
					return json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
					break;
			}
		}
		/**
		* Crea un Producto
		*/
		private function create(){
			
			$errors = array();

			$fechaReferencia	= $this->validateText(isset($_POST['fechaReferencia'])?$_POST['fechaReferencia']:NULL);
			$idProductoServicio = $this->validateNumber(isset($_POST['idProductoServicio'])?$_POST['idProductoServicio']:NULL);
			$precioUnitario 	= $this->validateNumber(isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
			$cantidad 			= $this->validateNumber(isset($_POST['cantidad'])?$_POST['cantidad']:NULL);

			if(strlen($fechaReferencia)==0)
				$errors['fechaReferencia'] = 1;
			if(strlen($idProductoServicio)==0)
				$errors['idProductoServicio'] = 1;
			if(strlen($precioUnitario)==0)
				$errors['precioUnitario'] = 1;
			if(strlen($cantidad)==0)
				$errors['cantidad'] = 1;
			
			if (count($errors) == 0){

				$result = $this->model->create($fechaReferencia, $idProductoServicio,$precioUnitario,$precioUnitario,$cantidad);

				//Si pudo ser creado
				if ($result) {
					//$data = array($fechaReferencia, $idProductoServicio,$precioUnitario,$precioUnitario,$cantidad);
					//Cargar la vista
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
		*obtenemos los datos especificos de la existencia de un producto
		**/
		private function getExistencia(){
			$idExistencia = $this->validateNumber(isset($_POST['idExistencia'])?$_POST['idExistencia']:NULL);
			if($idExistencia!==''){
				if(($result = $this->model->lists(-1,$idExistencia))){
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
			require_once 'models/consultaStatusMdl.php';
			$this->model = new ConsultaStatusMdl();
		}
	}
?>