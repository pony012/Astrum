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
				case 'createF':
					//Crear 
					$this->createF();
					break;
				case 'lists':
					//Listar 
					$this->lists();
					break;
				case 'get':
					$this->getConsulta();
					break;
				default:
					return json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
					break;
			}
		}
		/**
		* Crea una Consulta
		*/
		private function create(){
			
			$errors = array();

			$idCliente 			= $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
			$idTerapeuta 		= $this->validateNumber(isset($_POST['idTerapeuta'])?$_POST['idTerapeuta']:NULL);
			$idHistorialMedico	= $this->validateNumber(isset($_POST['idHistorialMedico'])?$_POST['idHistorialMedico']:NULL);
			$fechaCita 			= $this->validateDate(isset($_POST['fechaCita'])?$_POST['fechaCita']:NULL);
			$idConsultaStatus 	= $this->validateNumber(isset($_POST['idConsultaStatus'])?$_POST['idConsultaStatus']:NULL);
			$observaciones		= $this->validateText(isset($_POST['observaciones'])?$_POST['observaciones']:NULL);

			if(strlen($idCliente)==0)
				$errors['idCliente'] = 1;
			if(strlen($idTerapeuta)==0)
				$errors['idTerapeuta'] = 1;
			if(strlen($idHistorialMedico)==0)
				$errors['idHistorialMedico'] = 1;
			if(strlen($fechaCita)==0)
				$errors['fechaCita'] = 1;
			if(strlen($idConsultaStatus)==0)
				$errors['idConsultaStatus'] = 1;
			if(strlen($observaciones)==0)
				$errors['observaciones'] = 1;

			if (count($errors) == 0) {

				$result = $this->model->create($idCliente, $idTerapeuta, $idHistorialMedico,$fechaCita, $idConsultaStatus, $observaciones);

				//Si pudo ser creado
				if ($result) {
					//$data = array($idCliente, $idTerapeuta, $idHistorialMedico,$fechaCita, $idConsultaStatus, $observaciones);
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
		*Listamos todas las Consultas registrados
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
		*obtenemos los datos de un consulta
		**/
		private function getConsulta(){
			$idConsulta = $this->validateNumber(isset($_POST['idConsulta'])?$_POST['idConsulta']:NULL);
			if($idConsulta!==''){
				if(($result = $this->model->lists(-1,$idConsulta))){
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
		* Llama al formulario para la creación de una consulta
		*/
		private function createF(){
			$this->session['action']='create';
			$template = $this->twig->loadTemplate('consultaForm.html');
			echo $template->render(array('session'=>$this->session));
		}

		function __construct(){
			parent::__construct();
			require_once 'models/consultaMdl.php';
			$this->model = new ConsultaMdl();
		}
	}
?>
