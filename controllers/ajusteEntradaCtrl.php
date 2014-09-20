<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Ajuste Entrada
	*/
	class AjusteEntradaCtrl extends baseCtrl
	{
		private $model;

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
		* Crea un Ajuste Entrada
		*/
		private function create(){
			
			$errors = array();

			$idAjusteEntradaTipo 	= $this->validateNumber(isset($_POST['idAjusteEntradaTipo'])?$_POST['idAjusteEntradaTipo']:NULL);
			$idCliente 				= $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
			$folio					= $this->validateNumber(isset($_POST['folio'])?$_POST['folio']:NULL);
			$observaciones			= $this->validateText(isset($_POST['observaciones'])?$_POST['observaciones']:NULL);

			if(strlen($idAjusteEntradaTipo)==0)
				$errors['idAjusteEntradaTipo'] = 1;
			if(strlen($idCliente)==0)
				$errors['idCliente'] = 1;
			if(strlen($folio)==0)
				$errors['folio'] = 1;
			/*
			if(strlen($observaciones)==0)
				$errors['observaciones'] = 1;
			*/

			if (count($errors) == 0) {

				$result = $this->model->create($idAjusteEntradaTipo, $idCliente, $folio, $observaciones);

				//Si pudo ser creado
				if ($result) {
					//Cargar la vista
					require_once 'views/ajusteEntradaInserted.php';
				}else{
					require_once 'views/ajusteEntradaInsertedError.html';
				}
			}else{
				require_once 'views/ajusteEntradaInsertedError.html';
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
			require_once 'models/ajusteEntradaMdl.php';
			$this->model = new AjusteEntradaMdl();
		}
	}
?>