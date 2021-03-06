<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Producto
	*/
	class ProductoCtrl extends BaseCtrl
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
				case 'lists':
					//Listar 
					$this->lists();
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
				case 'update':
					//Baja
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
				case 'get':
					//Obtener un Producto
					$this->getProducto();
					break;
				case 'listsDeleters':
					//Lista los Productos
					$this->listsDeleters();
					break;
				case 'getDeleter':
					//Obtener un Producto
					$this->getProductoDeleter();
					break;
				/*case 'xls':
					$this->cargaXlsCsv();
					break;*/
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

				$producto 		= $this->validateText(isset($_POST['producto'])?$_POST['producto']:NULL);
				$precioUnitario	= $this->validateNumber(isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
				$foto 			= $this->validateText(isset($_POST['foto'])?$_POST['foto']:NULL);
				$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

				if(strlen($producto)==0)
					$errors['producto'] = 1;
				if(strlen($precioUnitario)==0)
					$errors['precioUnitario'] = 1;
				//if(strlen($foto)==0)
				//	$errors['foto'] = 1;
				if(strlen($descripcion)==0)
					$errors['descripcion'] = 1;

				//die($_FILES['archivo']['name']);
				if(isset($_FILES['archivo'])){
					$respuesta = $this->cargaXlsCsv();
					if($respuesta['error'] !== 0){
						echo $this->json_encode($respuesta);
						die();
					}
				}
				if (count($errors) == 0) {

					$result = $this->model->create($producto, $precioUnitario, $foto, $descripcion);

					//Si pudo ser creado
					if ($result) {
						//$data = array($idProductoTipo, $producto, $precioUnitario, $foto, $descripcion);
						//Cargar la vista
						echo $this->json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
					}else{
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
					}
				}else{
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}
			}else{
				$this->session['action']='create';
				$template = $this->twig->loadTemplate('productoForm.html');
				echo $template->render(array('session'=>$this->session));
			}
		}

		private function read(){

		}

		/**
		*Da de baja a un determinado producto
		**/
		private function delete(){
			$idProducto	= $this->validateNumber(isset($_POST['idProducto'])?$_POST['idProducto']:NULL);
			if(strlen($idProducto)==0)
				echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->delete($idProducto))
					echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				else
					echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
			}
		}

		/**
		*Activa a un determinado producto
		**/
		private function active(){
			$idProducto	= $this->validateNumber(isset($_POST['idProducto'])?$_POST['idProducto']:NULL);
			if(strlen($idProducto)==0)
				echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
			else{
				if($result = $this->model->active($idProducto))
					echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
				else
					echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
			}
		}

		private function update(){
			if ($this->api) {
				$errors = array();

				$idProducto 	= $this->validateNumber(isset($_POST['idProducto'])?$_POST['idProducto']:NULL);
				$producto 		= $this->validateText(isset($_POST['producto'])?$_POST['producto']:NULL);
				$precioUnitario	= $this->validateNumber(isset($_POST['precioUnitario'])?$_POST['precioUnitario']:NULL);
				$foto 			= $this->validateText(isset($_POST['foto'])?$_POST['foto']:NULL);
				$descripcion 	= $this->validateText(isset($_POST['descripcion'])?$_POST['descripcion']:NULL);

				if(strlen($idProducto)==0)
					$errors['idProducto'] = 1;
				if(strlen($producto)==0)
					$errors['producto'] = 1;
				if(strlen($precioUnitario)==0)
					$errors['precioUnitario'] = 1;
				//if(strlen($foto)==0)
					//$errors['foto'] = 1;
				if(strlen($descripcion)==0)
					$errors['descripcion'] = 1;

				//die($_FILES['archivo']['name']);
				if(isset($_FILES['archivo'])){
					$respuesta = $this->cargaXlsCsv();
					if($respuesta['error'] !== 0){
						echo $this->json_encode($respuesta);
						die();
					}
				}

				if (count($errors) == 0) {

					$result = $this->model->update($idProducto, $producto, $precioUnitario, $foto, $descripcion);

					//Si pudo ser creado
					if ($result) {
						//$data = array($idProductoTipo, $producto, $precioUnitario, $foto, $descripcion);
						//Cargar la vista
						echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'));
					}else{
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error en la Base de Datos'));
					}
				}else{
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}
			}else{
				//TODO
				//Cargar en $data desde la base de datos
				$data = $this->model->lists(-1, $_GET['id']);
				if($data){
					$this->session['action']='update';
					$template = $this->twig->loadTemplate('productoForm.html');
					echo $template->render(array('session'=>$this->session,'data'=>$data[0]));
				}else{
					//TODO
					//Enviar a listar clientes con vista de inválido
					//echo 'Error';
				}
			}
		}
		
		/**
		*listamos todos los Productos activos
		**/
		private function lists(){
			$constrain = '';
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
			$idProducto = $this->validateNumber(isset($_GET['id'])?$_GET['id']:NULL);
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
				if ($idProducto!=='') {
					if(($result = $this->model->lists($offset,$idProducto,$constrain))){
						if(is_numeric($result)){
							if ($this->api) {
								echo $this->json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
							}else{
								$template = $this->twig->loadTemplate('vacio.html');
								echo $template->render(array('session'=>$this->session,'data'=>NULL));
							}
						}else{
							if($this->api){
								echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
							}else{
								$this->session['action']='list';
								$template = $this->twig->loadTemplate('productoForm.html');
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
							$template = $this->twig->loadTemplate('vacio.html');
							echo $template->render(array('session'=>$this->session,'data'=>NULL));
						}
					}else{
						if($this->api){
							echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
						}else{
							$this->session['action']='list';
							$template = $this->twig->loadTemplate('productoList.html');
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
		*obtenemos los datos de un Producto activo
		**/
		private function getProducto(){
			$idProducto = $this->validateNumber(isset($_POST['idProducto'])?$_POST['idProducto']:NULL);
			if($idProducto!==''){
				if(($result = $this->model->lists(-1,$idProducto))){
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
							$template = $this->twig->loadTemplate('productoList.html');
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
		*listamos todos los Productos inactivos
		**/
		private function listsDeleters(){
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
			if($offset!==''){ 
				if(($result = $this->model->listsDeleters($offset))){
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
							$template = $this->twig->loadTemplate('productoList.html');
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
		*obtenemos los datos de un Producto inactivo
		**/
		private function getProductoDeleter(){
			$idProducto = $this->validateNumber(isset($_POST['idProducto'])?$_POST['idProducto']:NULL);
			if($idProducto!==''){
				if(($result = $this->model->listsDeleters(-1,$idProducto))){
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
							$template = $this->twig->loadTemplate('productoList.html');
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
		*cargamos un archivo xls o csv
		**/
		public function cargaXlsCsv(){
			//declaramos una variable con el archivo
			$archivo=$_FILES['archivo'];

			if(is_uploaded_file($archivo['tmp_name'])){
				$path = getcwd().'/uploads/'.$archivo['name'];
				if(!move_uploaded_file($archivo['tmp_name'],$path)){
					return array('error'=>ERROR_SERVIDOR,'data'=>NULL,'mensaje'=>'Extención Invalida');
				}else{
					$info=pathinfo($path);
					if($info['extension']==='xls' or $info['extension']==='csv' or $info['extension']==='xlsx'){
						$objPHPExcel  = PHPExcel_IOFactory::load($path);
		                $objWorkSheet = $objPHPExcel->getActiveSheet();
		                $flag = 1;
		                $rows = array();
		                foreach($objWorkSheet->getRowIterator() as $row){
	                  		$cellIterator = $row->getCellIterator();
	                    	$cellIterator->setIterateOnlyExistingCells(false);
	                    	if(!$flag){
		                    	$aux = array();
		                    	$errors = array();
		                    	foreach($cellIterator as $cell){
		                            $aux[]=$cell->getValue();
		                        }
		                        $producto 		= $this->validateText(isset($aux[0])?$aux[0]:NULL);
								$precioUnitario	= $this->validateNumber(isset($aux[1])?$aux[1]:NULL);
								$descripcion 	= $this->validateText(isset($aux[2])?$aux[2]:NULL);

								if(strlen($producto)==0)
									$errors['producto'] = 1;
								if(strlen($precioUnitario)==0)
									$errors['precioUnitario'] = 1;
								if(strlen($descripcion)==0)
									$errors['descripcion'] = 1;

								if (count($errors) == 0) {

									$result = $this->model->create($producto, $precioUnitario,  $descripcion);

									if ($result) {
										$rows[] = array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto');
									}else{
										$rows[] = array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Tratar de Insertar el Producto '.$aux[0]);
									}
								}else{
									$rows[] = array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto en el Producto '.$aux[0]);
								}
	                    	}else{
	                    		$flag = 0;
	                    	}
	                    }
						unlink($path);
						foreach ($rows as  $value) {
	                    	if($value['error'] !== OK){
	                    		return $value;	                 
	                    	}
	                    }
	                    return array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto');	               
					}else{
						return array('error'=>ARCHIVO_INVALIDO,'data'=>NULL,'mensaje'=>'Extención Invalida');	
					}
				}
			}else{
				return array('error'=>VACIO,'data'=>NULL,'mensaje'=>'Extención Invalida');
			}
		}

		function __construct(){
			parent::__construct();
			require_once 'models/productoMdl.php';
			$this->model = new ProductoMdl();
		}
	}
?>
