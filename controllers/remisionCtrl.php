<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Remision
	*/
	class RemisionCtrl extends BaseCtrl
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
					else
						return json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
					break;
				case 'createF':
					//Crear 
					if(BaseCtrl::isAdmin())
						$this->createF();
					else
						return json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
					break;
				case 'lists':
					//Crear 
					$this->lists();
					break;	
				case 'get':
					//Obtener una Remision
					$this->getRemision();
					break;
				case 'listsDeleters':
					//Lista las Remisiones
					$this->listsDeleters();
					break;
				case 'getDeleter':
					//Obtener una Remision
					$this->getRemisionDeleter();
					break;
				default:
					return json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
					break;
			}
		}

		/**
		* Crea una Remision
		*/
		private function create(){
			
			$errors = array();
			
			$idCliente	= $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
			$folio			= $this->validateNumber(isset($_POST['folio'])?$_POST['folio']:NULL);
			$fechaRemision	= $this->validateDate(isset($_POST['fechaRemision'])?$_POST['fechaRemision']:NULL);
			$idProductos 	= (isset($_POST['idProductos'])?$_POST['idProductos']:NULL);
			$cantidades		= (isset($_POST['cantidades'])?$_POST['cantidades']:NULL);
			$precioUnitario	= (isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
			$ivas 			= (isset($_POST['ivas'])?$_POST['ivas']:NULL);
			$descuentos 	= (isset($_POST['descuentos'])?$_POST['descuentos']:NULL);
			
			if(strlen($idCliente)==0)
				$errors['idCliente'] = 1;
			if(strlen($folio)==0)
				$errors['folio'] = 1;
			if(strlen($fechaRemision)==0)
				$errors['fechaRemision'] = 1;
			if(count($this->validateNumericArray($cantidades)) != 0)
				$errors['cantidades'] = 1;
			if(count($this->validateNumericArray($ivas)) != 0)
				$errors['ivas'] = 1;
			if(count($this->validateNumericArray($descuentos)) != 0)
				$errors['descuentos'] = 1;
			
			if (count($errors) == 0) {
				
				$result = $this->model->create($idCliente, $folio, $fechaRemision,$idProductos,$cantidades,$precioUnitario,$ivas,$descuentos);

				//Si pudo ser creado
				if ($result) {
					//Guardamos los campos en un arreglo
					$data = array($idCliente, $folio, $fechaRemision,$idProductos,$cantidades,$precioUnitario,$ivas,$descuentos);
					
					return json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
				}else{
					return json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
				}
			}else{
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
		*listamos todos las Remisiones activos
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
		*obtenemos los datos de una Remision activo
		**/
		private function getRemision(){
			$idRemision = $this->validateNumber(isset($_POST['idRemision'])?$_POST['idRemision']:NULL);
			if($idRemision!==''){
				if(($result = $this->model->lists(-1,$idRemision))){
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
		*listamos todos las Remisiones inactivos
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
		*obtenemos los datos de una Remision inactivo
		**/
		private function getRemisionDeleter(){
			$idRemision = $this->validateNumber(isset($_POST['idRemision'])?$_POST['idRemision']:NULL);
			if($idRemision!==''){
				if(($result = $this->model->listsDeleters(-1,$idRemision))){
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
		* Llama al formulario para la creación de una Remisión
		*/
		private function createF(){
			$this->session['action']='create';
			$template = $this->twig->loadTemplate('remisionForm.html');
			echo $template->render(array('session'=>$this->session));
		}

		/**
		* Llama al formulario para la actualización de una Remisión
		*/
		private function updateF(){
			//TODO
			//Cargar en $data desde la base de datos
			$data = $this->model->get(1);
			if($data){
				$this->session['action']='update';
				$template = $this->twig->loadTemplate('remisionForm.html');
				echo $template->render(array('session'=>$this->session,'data'=>$data));
			}else{
				//TODO
				//Enviar a listar clientes con vista de inválido
				//echo 'Error';
			}
		}

		/**
		*listamos todas las remisiones con sus detalles
		**/
		private function listss(){

			if($resultRemision = $this->model->lists()){

				$data = array();
				foreach($resultRemision as $row){

					$details = array();

					if($resultRemisionDetalle = $this->model->listsDetails($row['IDRemision'])){

						foreach($resultRemisionDetalle as $rowDetails)
							array_push($details, $rowDetails);

					}

					array_push($data, array($row,$details));
				}
				
				require_once 'views/remisionSelected.php';
			}else
				require_once 'views/remisionSelectedError.html';
		}

		function __construct(){
			parent::__construct();
			require_once 'models/remisionMdl.php';
			$this->model = new RemisionMdl();
		}
	}
?>
