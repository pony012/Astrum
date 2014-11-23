<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Consulta
	*/
	class ConsultaCtrl extends BaseCtrl
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
				case 'update':
					//Crear 
					$this->update();
					break;
				case 'lists':
					//Listar 
					$this->lists();
					break;
				case 'get':
					$this->getConsulta();
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
		* Crea una Consulta
		*/
		private function create(){
			if ($this->api) {
				$errors = array();

				$idCliente 			= $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
				$idTerapeuta 		= $this->validateNumber(isset($_POST['idTerapeuta'])?$_POST['idTerapeuta']:NULL);
				$idHistorialMedico	= $this->validateNumber(isset($_POST['idHistorialMedico'])?$_POST['idHistorialMedico']:NULL);
				$fechaCita 			= $this->validateDate(isset($_POST['fechaCita'])?$_POST['fechaCita']:NULL);
				$idConsultaStatus 	= $this->validateNumber(isset($_POST['idConsultaStatus'])?$_POST['idConsultaStatus']:NULL);
				$idServicio 		= $this->validateNumber(isset($_POST['idServicio'])?$_POST['idServicio']:NULL);
				$observaciones		= $this->validateText(isset($_POST['observaciones'])?$_POST['observaciones']:NULL);

				if(strlen($idCliente)==0)
					$errors['idCliente'] = 1;
				if(strlen($idTerapeuta)==0)
					$errors['idTerapeuta'] = 1;
				if(strlen($fechaCita)==0)
					$errors['fechaCita'] = 1;
				if(strlen($idConsultaStatus)==0)
					$errors['idConsultaStatus'] = 1;
				if(strlen($idServicio)==0)
					$errors['idServicio'] = 1;
				if(strlen($observaciones)==0)
					$errors['observaciones'] = 1;
				if (count($errors) == 0) {

					$result = $this->model->create($idCliente, $idTerapeuta, $idHistorialMedico,$fechaCita, $idConsultaStatus, $idServicio,$observaciones);

					//Si pudo ser creado
					if ($result) {
						//$data = array($idCliente, $idTerapeuta, $idHistorialMedico,$fechaCita, $idConsultaStatus, $observaciones);
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
				$template = $this->twig->loadTemplate('consultaForm.html');
				echo $template->render(array('session'=>$this->session));
			}
		}

		private function read(){

		}

		private function delete(){

		}

		private function update(){
			if ($this->api) {
				$errors = array();
				$idConsulta 		= $this->validateNumber(isset($_POST['idConsulta'])?$_POST['idConsulta']:NULL);
				$idCliente 			= $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
				$idTerapeuta 		= $this->validateNumber(isset($_POST['idTerapeuta'])?$_POST['idTerapeuta']:NULL);
				$idServicio 		= $this->validateNumber(isset($_POST['idServicio'])?$_POST['idServicio']:NULL);
				$fechaCita 			= $this->validateDateHour(isset($_POST['fechaCita'])?$_POST['fechaCita']:NULL);
				$idHistorialMedico	= $this->validateNumber(isset($_POST['idHistorialMedico'])?$_POST['idHistorialMedico']:NULL);
				$idConsultaStatus 	= $this->validateNumber(isset($_POST['idConsultaStatus'])?$_POST['idConsultaStatus']:NULL);
				$observaciones		= $this->validateText(isset($_POST['observaciones'])?$_POST['observaciones']:NULL);

				if(strlen($idConsulta)==0)
					$errors['idConsulta'] = 1;
				if(strlen($idCliente)==0)
					$errors['idCliente'] = 1;
				if(strlen($idTerapeuta)==0)
					$errors['idTerapeuta'] = 1;
				if(strlen($idServicio)==0)
					$errors['idServicio'] = 1;
				if(strlen($fechaCita)==0)
					$errors['fechaCita'] = 1;
				if(strlen($idConsultaStatus)==0)
					$errors['idConsultaStatus'] = 1;
				if(strlen($observaciones)==0)
					$errors['observaciones'] = 1;
				if (count($errors) == 0) {
					$result = $this->model->update($idConsulta,$idCliente, $idTerapeuta, $idHistorialMedico,$fechaCita, $idConsultaStatus, $idServicio, $observaciones);

					//Si pudo ser creado
					if ($result) {
						//$data = array($idCliente, $idTerapeuta, $idHistorialMedico,$fechaCita, $idConsultaStatus, $observaciones);
						echo $this->json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
					}else{
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
					}	
				}else{
					//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}
			}else{
				$data = $this->model->lists(-1, $_GET['id']);
				if($data){
					$this->session['action']='update';
					$template = $this->twig->loadTemplate('consultaForm.html');
					echo $template->render(array('session'=>$this->session,'data'=>$data[0]));
				}else{
					//TODO
					//Enviar a listar empleados con vista de inválido
					//echo 'Error';
				}
				/*
				//TODO
				//Cargar en $data desde la base de datos
				$data = $this->model->lists(-1, $_GET['id']);
				if($data){
					$this->session['action']='update';
					$template = $this->twig->loadTemplate('consultaForm.html');
					echo $template->render(array('session'=>$this->session,'data'=>$data));
				}else{
					//TODO
					//Enviar a listar consultas con vista de inválido
					//echo 'Error';
				}*/
			}
		}

		/**
		*Listamos todas las Consultas registrados
		**/
		private function lists(){
			$constrain = '';
			$offset = $this->validateNumber(isset($_GET['offset'])?$_GET['offset']:NULL);
			$Consulta = $this->validateNumber(isset($_GET['id'])?$_GET['id']:NULL);
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
				if ($Consulta!=='') {
					if(($result = $this->model->lists($offset,$Consulta,$constrain))){
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
								$template = $this->twig->loadTemplate('consultaForm.html');
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
							$template = $this->twig->loadTemplate('consultaList.html');
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
			/*
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
							$template = $this->twig->loadTemplate('vacio.html'); echo $template->render(array('session'=>$this->session,'data'=>NULL));
						}
					}else{

						if($this->api){
							echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
						}else{
							$template = $this->twig->loadTemplate('consultaList.html');
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
			}*/
		}

		/**
		*obtenemos los datos de un consulta
		**/
		private function getConsulta(){
			$idConsulta = $this->validateNumber(isset($_POST['idConsulta'])?$_POST['idConsulta']:NULL);
			if($idConsulta!==''){
				if(($result = $this->model->lists(-1,$idConsulta))){
					if(is_numeric($result)){
						if($this->api){
							echo $this->json_encode(array('error'=>VACIO,'data'=>NULL,'mensaje'=>'No se encontro Registro alguno'));
						}else{
							$template = $this->twig->loadTemplate('vacio.html'); echo $template->render(array('session'=>$this->session,'data'=>NULL));
						}
					}else{
						if($this->api){
							echo $this->json_encode(array('error'=>OK,'data'=>$result,'mensaje'=>'Correcto'),JSON_UNESCAPED_UNICODE);
						}else{
							$template = $this->twig->loadTemplate('consultaList.html');
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

		function __construct(){
			parent::__construct();
			require_once 'models/consultaMdl.php';
			$this->model = new ConsultaMdl();
		}
	}
?>
