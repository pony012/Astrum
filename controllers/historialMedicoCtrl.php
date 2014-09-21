<?php
	require_once 'controllers/baseCtrl.php';
	
	/**
	* Controlador de Empleado
	*/
	class HistorialMedicoCtrl extends BaseCtrl
	{
		private $exploracionMdl;
		private $fichaClinicaMdl;
		private $aguaAlDiaMdl;
		private $alimentacionMdl;
		private $exfoliacionMdl;
		private $habitoMdl;
		private $padecimientoMdl;
		private $pielMdl;
		private $tipoCelulitisMdl;
	
		/**
		 * Ejecuta acciones basado en la accion seleccionada por los agrumentos
		 */
		public function run()
		{
			switch ($_GET['act']) {
				case 'create':
					//Crear un Historial Clinico
					$this->create();
					break;
				
				default:
					# code...
					break;
			}
		}
		/**
		* Crea un Historial Clinico
		*/
		private function create(){
			
			$errors = array();
			
			$pesoIni			  = $this->validateNumber(isset($_POST['pesoIni'])?$_POST['pesoIni']:NULL);
			$bustoIni			  = $this->validateNumber(isset($_POST['bustoIni'])?$_POST['bustoIni']:NULL);
			$diafragmaIni		  = $this->validateNumber(isset($_POST['diafragmaIni'])?$_POST['diafragmaIni']:NULL);
			$brazoIni			  = $this->validateNumber(isset($_POST['brazoIni'])?$_POST['brazoIni']:NULL);
			$cinturaIni           = $this->validateNumber(isset($_POST['cinturaIni'])?$_POST['cinturaIni']:NULL);
			$abdomenIni			  = $this->validateNumber(isset($_POST['abdomenIni'])?$_POST['abdomenIni']:NULL);
			$caderaIni			  = $this->validateNumber(isset($_POST['caderaIni'])?$_POST['caderaIni']:NULL);
			$musloIni			  = $this->validateNumber(isset($_POST['musloIni'])?$_POST['musloIni']:NULL);
			
			$pesoFin			  = $this->validateNumber(isset($_POST['pesoFin'])?$_POST['pesoFin']:NULL);
			$bustoFin			  = $this->validateNumber(isset($_POST['bustoFin'])?$_POST['bustoFin']:NULL);
			$diafragmaFin		  = $this->validateNumber(isset($_POST['diafragmaFin'])?$_POST['diafragmaFin']:NULL);
			$brazoFin			  = $this->validateNumber(isset($_POST['brazoFin'])?$_POST['brazoFin']:NULL);
			$cinturaFin			  = $this->validateNumber(isset($_POST['cinturaFin'])?$_POST['cinturaFin']:NULL);
			$abdomenFin			  = $this->validateNumber(isset($_POST['abdomenFin'])?$_POST['abdomenFin']:NULL);
			$caderaFin			  = $this->validateNumber(isset($_POST['caderaFin'])?$_POST['caderaFin']:NULL);
			$musloFin  			  = $this->validateNumber(isset($_POST['musloFin'])?$_POST['musloFin']:NULL);
			
			$motivoConsulta		  = $this->validateText(isset($_POST['motivoConsulta'])?$_POST['motivoConsulta']:NULL);
			$tiempoProblema		  = $this->validateText(isset($_POST['tiempoProblema'])?$_POST['tiempoProblema']:NULL);
			$relacionaCon	  	  = $this->validateText(isset($_POST['relacionaCon'])?$_POST['relacionaCon']:NULL);
			$tratamientoAnterior  = $this->validateText(isset($_POST['tratamientoAnterior'])?$_POST['tratamientoAnterior']:NULL);
			$metProbados		  = $this->validateText(isset($_POST['metProbados'])?$_POST['metProbados']:NULL);
			$resAnteriores		  = $this->validateText(isset($_POST['resAnteriores'])?$_POST['resAnteriores']:NULL);
			
			$idCliente			  = $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
			$fechaRegistro		  = $this->validateDate(isset($_POST['fechaRegistro'])?$_POST['fechaRegistro']:NULL);
			$idServicio			  = $this->validateNumber(isset($_POST['idServicio'])?$_POST['idServicio']:NULL);
			$observaciones		  = $this->validateText(isset($_POST['observaciones'])?$_POST['observaciones']:NULL);
			
			$estadoAguaAlDia	  = $this->validateText(isset($_POST['estadoAguaAlDia'])?$_POST['estadoAguaAlDia']:NULL);
			$estadoAlimentacion	  = $this->validateText(isset($_POST['estadoAguaAlDia'])?$_POST['estadoAguaAlDia']:NULL);
			
			$arregloExfolacion    = (isset($_POST['arregloExfolacion'])?$_POST['arregloExfolacion']:NULL);
			$arregloHabito		  = (isset($_POST['arregloHabito'])?$_POST['arregloHabito']:NULL);
			$arregloPadecimiento  = (isset($_POST['arregloPadecimiento'])?$_POST['arregloPadecimiento']:NULL);
			$arregloPiel		  = (isset($_POST['arregloPiel'])?$_POST['arregloPiel']:NULL);
			$arregloTipoCelulitis = (isset($_POST['arregloTipoCelulitis'])?$_POST['arregloTipoCelulitis']:NULL);
			
			//Los siguientes if's para los arreglos se borrarán
			if(count($arregloExfolacion) <= 1)
				$arregloExfolacion = array($arregloExfolacion);
			if(count($arregloHabito) <= 1)
				$arregloHabito =  array($arregloHabito);
			if(count($arregloPadecimiento) <= 1)
				$arregloPadecimiento =  array($arregloPadecimiento);
			if(count($arregloPiel) <= 1)
				$arregloPiel =  array($arregloPiel);
			if(count($arregloTipoCelulitis) <= 1)
				$arregloTipoCelulitis =  array($arregloTipoCelulitis);
				
			if(strlen($idCliente)==0)
				$errors['idCliente'] = 1;
			if(strlen($fechaRegistro)==0)
				$errors['fechaRegistro'] = 1;
			if(strlen($idServicio)==0)
				$errors['idServicio'] = 1;
			

			if (count($errors) == 0) {
				$result 			= $this->model->create($idCliente, $fechaRegistro, $idServicio, $observaciones);
				$exploracionIni   = $this->exploracionMdl->createInit($pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, $abdomenIni, $caderaIni, $musloIni);
				$exploracionFin   = $this->exploracionMdl->createFin($pesoFin, $bustoFin, $diafragmaFin, $brazoFin, $cinturaFin, $abdomenFin, $caderaFin, $musloFin);
				$fichaClinica  	  = $this->fichaClinicaMdl->create($motivoConsulta, $tiempoProblema, $relacionaCon, $tratamientoAnterior, $metProbados, $resAnteriores);
				$aguaAlDia        = $this->aguaAlDiaMdl->create($estadoAguaAlDia);
				$alimentacion     = $this->alimentacionMdl->create($estadoAlimentacion);
				
				$peellingQuim = NULL;
				$laser = NULL;
				$dermobrasion = NULL;
				$retinA = NULL;
				$renova = NULL;
				$racutan = NULL;
				$adapaleno = NULL;
				$acidoGlicolico = NULL;
				$alfaHidroiacidos = NULL;
				$exfolianteGranuloso = NULL;
				$acidoLactico = NULL;
				$vitaminaA = NULL;
				$blanqueadorAclarador = NULL;
				
				foreach($arregloExfolacion as $value)
					switch($value){
						case 'peellingQuim':
							$peellingQuim ='S';
							break;
						case 'laser':
							$laser = 'S';
							break;
						case 'dermobrasion':
							$dermobrasion = 'S';
							break;
						case 'retinA':
							$retinA = 'S';
							break;
						case 'renova':
							$renova = 'S';
							break;
						case 'racutan':
							$racutan = 'S';
							break;
						case 'adapaleno':
							$adapaleno = 'S';
							break;
						case 'acidoGlicolico':
							$acidoGlicolico = 'S';
							break;
						case 'alfaHidroiacidos':
							$alfaHidroiacidos = 'S';
							break;
						case 'exfolianteGranuloso':
							$exfolianteGranuloso = 'S';
							break;
						case 'acidoLactico':
							$acidoLactico = 'S';
							break;
						case 'vitaminaA':
							$vitaminaA = 'S';
							break;
						case 'blanqueadorAclarador':
							$blanqueadorAclarador = 'S';
							break;
						default:
					};
				
				$exfoliacion      = $this->exfoliacionMdl->create($peellingQuim,$laser,$dermobrasion,$retinA,$renova,$racutan,
																	$adapaleno,$acidoGlicolico,$alfaHidroiacidos,$exfolianteGranuloso,
																	$acidoLactico,$vitaminaA,$blanqueadorAclarador);
				
				$fumar 			= NULL;
				$ejercicio 	    = NULL;
				$usarFaja 		= NULL;
				$suenio 		= NULL;
				$tomaSol 		= NULL;
				$bloqueador 	= NULL;
				$hidroquinona   = NULL;
				
				foreach($arregloHabito as $value)
					switch($value){
						case 'fumar':
							$fumar ='S';
							break;
						case 'ejercicio':
							$ejercicio = 'S';
							break;
						case 'usarFaja':
							$usarFaja = 'S';
							break;
						case 'suenio':
							$suenio = 'S';
							break;
						case 'tomaSol':
							$tomaSol = 'S';
							break;
						case 'bloqueador':
							$bloqueador = 'S';
							break;
						case 'hidroquinona':
							$hidroquinona = 'S';
							break;
						default:
					};
					
				$habito   	      = $this->habitoMdl->create($fumar, $ejercicio, $usarFaja, $suenio, $tomaSol, $bloqueador, $hidroquinona);
				
				$diabetes			= NULL;
				$obesisdad			= NULL;
				$depresion			= NULL;
				$estres				= NULL;
				$sobrepeso			= NULL;
				$estrenimiento		= NULL;
				$colitis			= NULL;
				$retencionLiquidos	= NULL;
				$transtornoMes		= NULL;
				$cuidadoCorporal	= NULL;
				$embarazo			= NULL;
				
				foreach($arregloPadecimiento as $value)
					switch($value){
						case 'diabetes':
							$diabetes ='S';
							break;
						case 'obesisdad':
							$obesisdad = 'S';
							break;
						case 'depresion':
							$depresion = 'S';
							break;
						case 'estres':
							$estres = 'S';
							break;
						case 'sobrepeso':
							$sobrepeso = 'S';
							break;
						case 'estrenimiento':
							$estrenimiento = 'S';
							break;
						case 'colitis':
							$colitis = 'S';
							break;
						case 'retencionLiquidos':
							$retencionLiquidos = 'S';
							break;
						case 'transtornoMes':
							$transtornoMes = 'S';
							break;
						case 'cuidadoCorporal':
							$cuidadoCorporal = 'S';
							break;
						case 'embarazo':
							$embarazo = 'S';
							break;
						default:
					};
					
				$padecimiento     = $this->padecimientoMdl->create($diabetes, $obesisdad, $depresion, $estres, $sobrepeso, $estrenimiento, $colitis,
																   $retencionLiquidos, $transtornoMes, $cuidadoCorporal, $embarazo);
				
				$fina = NULL;
				$gruesa = NULL;
				$deshidratada = NULL;
				$flacida = NULL;
				$seca = NULL;
				$mixta = NULL;
				$grasa = NULL;
				$acneica = NULL;
				$manchas = NULL;
				$cicatrices = NULL;
				$poroAbierto = NULL;
				$ojeras = NULL;
				$lunares = NULL;
				$pecas = NULL;
				$puntosNegros = NULL;
				$verrugas = NULL;
				$arrugas = NULL;
				$brilloFacial = NULL;
				$pielAsfixiada = NULL;
				$despigmentacion = NULL;
				
				foreach($arregloPiel as $value)
					switch($value){
						case 'fina':
							$fina ='S';
							break;
						case 'gruesa':
							$gruesa = 'S';
							break;
						case 'deshidratada':
							$deshidratada = 'S';
							break;
						case 'flacida':
							$flacida = 'S';
							break;
						case 'seca':
							$seca = 'S';
							break;
						case 'mixta':
							$mixta = 'S';
							break;
						case 'grasa':
							$grasa = 'S';
							break;
						case 'acneica':
							$acneica = 'S';
							break;
						case 'manchas':
							$manchas = 'S';
							break;
						case 'cicatrices':
							$cicatrices = 'S';
							break;
						case 'ojeras':
							$ojeras = 'S';
							break;
						case 'lunares':
							$lunares = 'S';
							break;
						case 'pecas':
							$pecas = 'S';
							break;
						case 'puntosNegros':
							$puntosNegros = 'S';
							break;
						case 'verrugas':
							$verrugas = 'S';
							break;
						case 'arrugas':
							$arrugas = 'S';
							break;
						case 'brilloFacial':
							$brilloFacial = 'S';
							break;
						case 'pielAsfixiada':
							$pielAsfixiada = 'S';
							break;
						case 'despigmentacion':
							$despigmentacion = 'S';
							break;
						default:
					};
				
				$piel		      = $this->pielMdl->create($fina,$gruesa,$deshidratada,$flacida,$seca,$mixta,$grasa,$acneica,$manchas,
															$cicatrices,$poroAbierto,$ojeras,$lunares,$pecas,$puntosNegros,$verrugas,$arrugas,
															$brilloFacial,$pielAsfixiada,$despigmentacion);
															
				$fibrosa = NULL;
				$edematosa = NULL;
				$flacida = NULL;
				$dura = NULL;
				$mixta = NULL;
				$dolorosa = NULL;
				
				foreach($arregloTipoCelulitis as $value)
					switch($value){
						case 'fibrosa':
							$fibrosa ='S';
							break;
						case 'edematosa':
							$edematosa = 'S';
							break;
						case 'flacida':
							$flacida = 'S';
							break;
						case 'dura':
							$dura = 'S';
							break;
						case 'mixta':
							$mixta = 'S';
							break;
						case 'dolorosa':
							$dolorosa = 'S';
							break;
						default:
					};
					
				$tipoCelulitis    = $this->tipoCelulitisMdl->create($fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa);
				if (!$result)
					echo 'Historial Medico';
				if( !$exploracionIni)
					echo 'explo ini';
				if(!$exploracionFin)
					echo 'explo fin';
				if(!$fichaClinica)
					echo 'ficha';
				if(!$aguaAlDia)
					echo 'Agua';
				if(!$alimentacion)
					echo 'ali';
				if(!$exfoliacion)
					echo 'exfo';
				if(!$habito)
					echo 'Habito';
				if(!$padecimiento)
					echo 'Padecimiento';
				if(!$piel)
					echo 'piel';
				if(!$tipoCelulitis)
					echo 'Celulitis';
				
				//Si pudo ser creado
				if ($result and $exploracionIni and $exploracionFin and $fichaClinica and $aguaAlDia and $alimentacion and $exfoliacion and $habito and $padecimiento and $piel and $tipoCelulitis){
					$data = array($idCliente, $fechaRegistro, $idServicio, $observaciones,$pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, 
									$abdomenIni, $caderaIni, $musloIni,$pesoFin, $bustoFin, $diafragmaFin, $brazoFin, $cinturaFin, $abdomenFin, $caderaFin,
									$musloFin,$motivoConsulta, $tiempoProblema, $relacionaCon, $tratamientoAnterior, $metProbados, $resAnteriores,
									$estadoAguaAlDia,$estadoAlimentacion,$peellingQuim,$laser,$dermobrasion,$retinA,$renova,$racutan,
									$adapaleno,$acidoGlicolico,$alfaHidroiacidos,$exfolianteGranuloso,$acidoLactico,$vitaminaA,$blanqueadorAclarador,
									$fumar, $ejercicio, $usarFaja, $suenio, $tomaSol, $bloqueador, $hidroquinona,$diabetes, $obesisdad, $depresion, 
									$estres, $sobrepeso, $estrenimiento, $colitis,$retencionLiquidos, $transtornoMes, $cuidadoCorporal, $embarazo,
									$fina,$gruesa,$deshidratada,$flacida,$seca,$mixta,$grasa,$acneica,$manchas,$cicatrices,$poroAbierto,$ojeras,
									$lunares,$pecas,$puntosNegros,$verrugas,$arrugas,$brilloFacial,$pielAsfixiada,$despigmentacion,
									$fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa);
					//Cargar la vista
					require_once 'views/historialMedicoInserted.php';
				}else{
					require_once 'views/historialMedicoInsertedError.html';
				}	
			}else{
				//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
				require_once 'views/historialMedicoInsertedError.html';
			}
		}

		private function read(){

		}

		private function delete(){

		}

		private function update(){

		}

		private function lists(){

		}

		function __construct(){
			require_once 'models/historialMedicoMdl.php';
			require_once 'models/exploracionMdl.php';
			require_once 'models/fichaClinicaMdl.php';
			require_once 'models/aguaAlDiaMdl.php';
			require_once 'models/alimentacionMdl.php';
			require_once 'models/exfoliacionMdl.php';
			require_once 'models/habitoMdl.php';
			require_once 'models/padecimientoMdl.php';
			require_once 'models/pielMdl.php';
			require_once 'models/tipoCelulitisMdl.php';
			
			$this->model 			= new HistorialMedicoMdl();
			$this->exploracionMdl   = new ExploracionMdl();
			$this->fichaClinicaMdl  = new FichaClinicaMdl();
			$this->aguaAlDiaMdl     = new AguaAlDiaMdl();
			$this->alimentacionMdl  = new AlimentacionMdl();
			
			$this->exfoliacionMdl   = new ExfoliacionMdl();
			$this->habitoMdl    	= new HabitoMdl();
			$this->padecimientoMdl  = new PadecimientoMdl();
			$this->pielMdl		    = new PielMdl();
			$this->tipoCelulitisMdl = new TipoCelulitisMdl();
		}
	}
?>
