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
				
				default:
					# code...
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
					$data = array($idCliente, $idTerapeuta, $idHistorialMedico,$fechaCita, $idConsultaStatus, $observaciones);
					//Cargar la vista
					require_once 'views/consultaInserted.php';
				}else{
					require_once 'views/consultaInsertedError.html';
				}
			}else{
				require_once 'views/consultaInsertedError.html';
			}
		}

		private function read(){

		}

		private function delete(){

		}

		private function update(){

		}

		private function list(){

		}

		function __construct(){
			require_once 'models/consultaMdl.php';
			$this->model = new ConsultaMdl();
		}
	}
?>
