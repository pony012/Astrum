<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Ajuste Salida
	*/
	class AjusteSalidaCtrl extends BaseCtrl
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
				default:
					# code...
					break;
			}
		}
		/**
		* Crea un Ajuste Salida
		*/
		private function create(){
			
			$errors = array();

			$idAjusteSalidaTipo 	= $this->validateNumber(isset($_POST['idAjusteSalidaTipo'])?$_POST['idAjusteSalidaTipo']:NULL);
			$idProveedor 			= $this->validateNumber(isset($_POST['idProveedor'])?$_POST['idProveedor']:NULL);
			$folio					= $this->validateNumber(isset($_POST['folio'])?$_POST['folio']:NULL);
			$observaciones			= $this->validateText(isset($_POST['observaciones'])?$_POST['observaciones']:NULL);
			$idProductoServicios 	= (isset($_POST['idProductoServicios'])?$_POST['idProductoServicios']:NULL);
			$cantidades				= (isset($_POST['cantidades'])?$_POST['cantidades']:NULL);

			if(strlen($idAjusteSalidaTipo)==0)
				$errors['idAjusteSalidaTipo'] = 1;
			if(strlen($idProveedor)==0)
				$errors['idProveedor'] = 1;
			if(strlen($folio)==0)
				$errors['folio'] = 1;
			if(strlen($folio)==0)
				$errors['folio'] = 1;
			if(count($this->validateNumericArray($cantidades)) != 0)
				$errors['cantidades'] = 1;
			/*
			if(strlen($observaciones)==0)
				$errors['observaciones'] = 1;
			*/

			if (count($errors) == 0) {

				$result = $this->model->create($idAjusteSalidaTipo, $idProveedor, $folio, $observaciones, $idProductoServicios, $cantidades);

				//Si pudo ser creado
				if ($result) {
					$data = array($idAjusteSalidaTipo, $idProveedor, $folio, $observaciones, $idProductoServicios, $cantidades);
					//Cargar la vista
					require_once 'views/ajusteSalidaInserted.php';
				}else{
					require_once 'views/ajusteSalidaInsertedError.html';
				}
			}else{
				require_once 'views/ajusteSalidaInsertedError.html';
			}
		}

		private function read(){

		}

		private function delete(){

		}

		private function update(){

		}

		/**
		*Listamos todas los ajustes de salida con sus detalles
		**/
		private function lists(){

			if($resultRemision = $this->model->lists()){

				$data = array();
				foreach($resultRemision as $row){

					$details = array();

					if($resultRemisionDetalle = $this->model->listsDetails($row['IDAjusteSalida'])){

						foreach($resultRemisionDetalle as $rowDetails)
							array_push($details, $rowDetails);

					}

					array_push($data, array($row,$details));
				}
				
				require_once 'views/ajusteSalidaSelected.php';
			}else
				require_once 'views/ajusteSalidaSelectedError.html';
		}

		function __construct(){
			parent::__construct();
			require_once 'models/ajusteSalidaMdl.php';
			$this->model = new AjusteSalidaMdl();
		}
	}
?>
