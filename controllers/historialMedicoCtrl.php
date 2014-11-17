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
			if(BaseCtrl::isTerapeuta() || BaseCtrl::isAdmin())
				switch ($_GET['act']) {
					case 'create':
						//Crear un Historial Clinico
						$this->create();
						break;
					case 'update':
						//Crear un Historial Clinico
						$this->update();
						break;
					case 'lists':
						//Listar
						$this->lists();
						break;
					default:
						if ($this->api) {
							echo $this->json_encode(array('error'=>SERVICIO_INEXISTENTE,'data'=>NULL,'mensaje'=>'Este servicio no está disponible'));
						}else{
							//CARGAR VISTA DE SERVICIO INEXISTENTE
						}
						break;
				}
			else{
				if ($this->api) {
					echo $this->json_encode(array('error'=>NO_PERMITIDO,'data'=>NULL,'mensaje'=>'No tienes permisos suficientes'));
				}else{
					//CARGAR VISTA DE NO PERMITIDO
				}
			}
		}

		/**
		* Crea un Historial Clinico
		*/
		private function create(){
			if ($this->api) {
				$errors = array();
				
				$pesoIni			  = $this->validateNumber(isset($_POST['pesoIni'])?$_POST['pesoIni']:NULL);
				$bustoIni			  = $this->validateNumber(isset($_POST['bustoIni'])?$_POST['bustoIni']:NULL);
				$diafragmaIni		  = $this->validateNumber(isset($_POST['diafragmaIni'])?$_POST['diafragmaIni']:NULL);
				$brazoIni			  = $this->validateNumber(isset($_POST['brazoIni'])?$_POST['brazoIni']:NULL);
				$cinturaIni           = $this->validateNumber(isset($_POST['cinturaIni'])?$_POST['cinturaIni']:NULL);
				$abdomenIni			  = $this->validateNumber(isset($_POST['abdomenIni'])?$_POST['abdomenIni']:NULL);
				$caderaIni			  = $this->validateNumber(isset($_POST['caderaIni'])?$_POST['caderaIni']:NULL);
				$musloIni			  = $this->validateNumber(isset($_POST['musloIni'])?$_POST['musloIni']:NULL);

				$pesoIni			  = ($pesoIni === ''?0:(double)$pesoIni);
				$bustoIni			  = ($bustoIni === ''?0:(double)$bustoIni);
				$diafragmaIni		  = ($diafragmaIni === ''?0:(double)$diafragmaIni);
				$brazoIni			  = ($brazoIni === ''?0:(double)$brazoIni);
				$cinturaIni			  = ($cinturaIni === ''?0:(double)$cinturaIni);
				$abdomenIni			  = ($abdomenIni === ''?0:(double)$abdomenIni);
				$caderaIni			  = ($caderaIni === ''?0:(double)$caderaIni);
				$musloIni			  = ($musloIni === ''?0:(double)$musloIni);
				
				$pesoFin			  = $this->validateNumber(isset($_POST['pesoFin'])?$_POST['pesoFin']:NULL);
				$bustoFin			  = $this->validateNumber(isset($_POST['bustoFin'])?$_POST['bustoFin']:NULL);
				$diafragmaFin		  = $this->validateNumber(isset($_POST['diafragmaFin'])?$_POST['diafragmaFin']:NULL);
				$brazoFin			  = $this->validateNumber(isset($_POST['brazoFin'])?$_POST['brazoFin']:NULL);
				$cinturaFin			  = $this->validateNumber(isset($_POST['cinturaFin'])?$_POST['cinturaFin']:NULL);
				$abdomenFin			  = $this->validateNumber(isset($_POST['abdomenFin'])?$_POST['abdomenFin']:NULL);
				$caderaFin			  = $this->validateNumber(isset($_POST['caderaFin'])?$_POST['caderaFin']:NULL);
				$musloFin  			  = $this->validateNumber(isset($_POST['musloFin'])?$_POST['musloFin']:NULL);

				$pesoFin			  = ($pesoFin === ''?0:(double)$pesoFin);
				$bustoFin			  = ($bustoFin === ''?0:(double)$bustoFin);
				$diafragmaFin		  = ($diafragmaFin === ''?0:(double)$diafragmaFin);
				$brazoFin			  = ($brazoFin === ''?0:(double)$brazoFin);
				$cinturaFin			  = ($cinturaFin === ''?0:(double)$cinturaFin);
				$abdomenFin			  = ($abdomenFin === ''?0:(double)$abdomenFin);
				$caderaFin			  = ($caderaFin === ''?0:(double)$caderaFin);
				$musloFin			  = ($musloFin === ''?0:(double)$musloFin);
				
				$motivoConsulta		  = $this->validateText(isset($_POST['motivoConsulta'])?$_POST['motivoConsulta']:NULL);
				$tiempoProblema		  = $this->validateText(isset($_POST['tiempoProblema'])?$_POST['tiempoProblema']:NULL);
				$relacionaCon	  	  = $this->validateText(isset($_POST['relacionaCon'])?$_POST['relacionaCon']:NULL);
				$tratamientoAnterior  = $this->validateText(isset($_POST['tratamientoAnterior'])?$_POST['tratamientoAnterior']:NULL);
				$metProbados		  = $this->validateText(isset($_POST['metProbados'])?$_POST['metProbados']:NULL);
				$resAnteriores		  = $this->validateText(isset($_POST['resAnteriores'])?$_POST['resAnteriores']:NULL);
				
				$idCliente			  = $this->validateNumber(isset($_POST['idCliente'])?$_POST['idCliente']:NULL);
				$idServicio			  = $this->validateNumber(isset($_POST['idServicio'])?$_POST['idServicio']:NULL);
				$observaciones		  = $this->validateText(isset($_POST['observaciones'])?$_POST['observaciones']:NULL);
				
				$aguaAlDia	  		  = $this->validateText(isset($_POST['aguaAlDia'])?$_POST['aguaAlDia']:NULL);
				$alimentacion	  	  = $this->validateText(isset($_POST['alimentacion'])?$_POST['alimentacion']:NULL);
				
				$arregloExfolacion    = (isset($_POST['arregloExfolacion'])?$_POST['arregloExfolacion']:NULL);
				$arregloHabito		  = (isset($_POST['arregloHabito'])?$_POST['arregloHabito']:NULL);
				$arregloPadecimiento  = (isset($_POST['arregloPadecimiento'])?$_POST['arregloPadecimiento']:NULL);
				$arregloPiel		  = (isset($_POST['arregloPiel'])?$_POST['arregloPiel']:NULL);
				$arregloTipoCelulitis = (isset($_POST['arregloTipoCelulitis'])?$_POST['arregloTipoCelulitis']:NULL);

				//var_dump($arregloExfolacion);
				//var_dump($arregloHabito);
				//var_dump($arregloPadecimiento);
				//var_dump($arregloPiel);
				//var_dump($arregloTipoCelulitis);
				//die();
				
				//Los siguientes if's para los arreglos se borrarán
				/*if(count($arregloExfolacion) <= 1)
					$arregloExfolacion = array($arregloExfolacion);
				if(count($arregloHabito) <= 1)
					$arregloHabito =  array($arregloHabito);
				if(count($arregloPadecimiento) <= 1)
					$arregloPadecimiento =  array($arregloPadecimiento);
				if(count($arregloPiel) <= 1)
					$arregloPiel =  array($arregloPiel);
				if(count($arregloTipoCelulitis) <= 1)
					$arregloTipoCelulitis =  array($arregloTipoCelulitis);
				*/

				if(strlen($idCliente)==0)
					$errors['idCliente'] = 1;
				if(strlen($idServicio)==0)
					$errors['idServicio'] = 1;
				

				if (count($errors) == 0) {
					
					$poca = NULL;
					$regularAg = NULL;
					$mucha = NULL;

					switch ($aguaAlDia) {
						case 'poca':
							$poca = 'S';
							break;

						case 'regular':
							$regularAg = 'S';
							break;

						case 'mucha':
							$mucha = 'S';
							break;
						
						default:

					}

					$buena = NULL;
					$regularAl = NULL;
					$mala = NULL;

					switch ($alimentacion) {
						case 'buena':
							$buena = 'S';
							break;

						case 'regular':
							$regularAl = 'S';
							break;

						case 'mala':
							$mala = 'S';
							break;
						
						default:
					}
					
					$peelingQuim = NULL;
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
					
					//var_dump($arregloExfolacion);
					foreach($arregloExfolacion as $value){
						//var_dump($value);
						switch($value){
							case 'peelingQuim':
								//echo "string";
								//die();
								$peelingQuim ='S';
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
					}
					//die();
					
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

					$result 			= $this->model->create($idCliente, $idServicio, $observaciones, 
																$pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, $abdomenIni, $caderaIni, $musloIni,
																$pesoFin, $bustoFin, $diafragmaFin, $brazoFin, $cinturaFin, $abdomenFin, $caderaFin, $musloFin,
																$motivoConsulta, $tiempoProblema, $relacionaCon, $tratamientoAnterior, $metProbados, $resAnteriores,
																$poca,$regularAg,$mucha,$buena,$regularAl,$mala,
																$peelingQuim,$laser,$dermobrasion,$retinA,$renova,$racutan,
																$adapaleno,$acidoGlicolico,$alfaHidroiacidos,$exfolianteGranuloso,
																$acidoLactico,$vitaminaA,$blanqueadorAclarador, $fumar, $ejercicio, $usarFaja, $suenio, $tomaSol, $bloqueador, $hidroquinona,
																$diabetes, $obesisdad, $depresion, $estres, $sobrepeso, $estrenimiento, $colitis,
															    $retencionLiquidos, $transtornoMes, $cuidadoCorporal, $embarazo,
																$fina,$gruesa,$deshidratada,$flacida,$seca,$mixta,$grasa,$acneica,$manchas,
																$cicatrices,$poroAbierto,$ojeras,$lunares,$pecas,$puntosNegros,$verrugas,$arrugas,
																$brilloFacial,$pielAsfixiada,$despigmentacion, $fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa);

					if (!$result)
						echo 'Historial Medico';
					
					//Si pudo ser creado
					if ($result ){
						/*$data = array($idCliente, $idServicio, $observaciones, 
													$pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, $abdomenIni, $caderaIni, $musloIni,
													$pesoFin, $bustoFin, $diafragmaFin, $brazoFin, $cinturaFin, $abdomenFin, $caderaFin, $musloFin,
													$motivoConsulta, $tiempoProblema, $relacionaCon, $tratamientoAnterior, $metProbados, $resAnteriores,
													$poca,$regularAg,$mucha,$buena,$regularAl,$mala,
													$peelingQuim,$laser,$dermobrasion,$retinA,$renova,$racutan,
													$adapaleno,$acidoGlicolico,$alfaHidroiacidos,$exfolianteGranuloso,
													$acidoLactico,$vitaminaA,$blanqueadorAclarador, $fumar, $ejercicio, $usarFaja, $suenio, $tomaSol, $bloqueador, $hidroquinona,
													$diabetes, $obesisdad, $depresion, $estres, $sobrepeso, $estrenimiento, $colitis,
												    $retencionLiquidos, $transtornoMes, $cuidadoCorporal, $embarazo,
													$fina,$gruesa,$deshidratada,$flacida,$seca,$mixta,$grasa,$acneica,$manchas,
													$cicatrices,$poroAbierto,$ojeras,$lunares,$pecas,$puntosNegros,$verrugas,$arrugas,
													$brilloFacial,$pielAsfixiada,$despigmentacion, $fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa);*/
						//Cargar la vista
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
				$template = $this->twig->loadTemplate('historialMedicoForm.html');
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
				
				$pesoIni			  = $this->validateNumber(isset($_POST['pesoIni'])?$_POST['pesoIni']:NULL);
				$bustoIni			  = $this->validateNumber(isset($_POST['bustoIni'])?$_POST['bustoIni']:NULL);
				$diafragmaIni		  = $this->validateNumber(isset($_POST['diafragmaIni'])?$_POST['diafragmaIni']:NULL);
				$brazoIni			  = $this->validateNumber(isset($_POST['brazoIni'])?$_POST['brazoIni']:NULL);
				$cinturaIni           = $this->validateNumber(isset($_POST['cinturaIni'])?$_POST['cinturaIni']:NULL);
				$abdomenIni			  = $this->validateNumber(isset($_POST['abdomenIni'])?$_POST['abdomenIni']:NULL);
				$caderaIni			  = $this->validateNumber(isset($_POST['caderaIni'])?$_POST['caderaIni']:NULL);
				$musloIni			  = $this->validateNumber(isset($_POST['musloIni'])?$_POST['musloIni']:NULL);

				$pesoIni			  = ($pesoIni === ''?0:(double)$pesoIni);
				$bustoIni			  = ($bustoIni === ''?0:(double)$bustoIni);
				$diafragmaIni		  = ($diafragmaIni === ''?0:(double)$diafragmaIni);
				$brazoIni			  = ($brazoIni === ''?0:(double)$brazoIni);
				$cinturaIni			  = ($cinturaIni === ''?0:(double)$cinturaIni);
				$abdomenIni			  = ($abdomenIni === ''?0:(double)$abdomenIni);
				$caderaIni			  = ($caderaIni === ''?0:(double)$caderaIni);
				$musloIni			  = ($musloIni === ''?0:(double)$musloIni);
				
				$pesoFin			  = $this->validateNumber(isset($_POST['pesoFin'])?$_POST['pesoFin']:NULL);
				$bustoFin			  = $this->validateNumber(isset($_POST['bustoFin'])?$_POST['bustoFin']:NULL);
				$diafragmaFin		  = $this->validateNumber(isset($_POST['diafragmaFin'])?$_POST['diafragmaFin']:NULL);
				$brazoFin			  = $this->validateNumber(isset($_POST['brazoFin'])?$_POST['brazoFin']:NULL);
				$cinturaFin			  = $this->validateNumber(isset($_POST['cinturaFin'])?$_POST['cinturaFin']:NULL);
				$abdomenFin			  = $this->validateNumber(isset($_POST['abdomenFin'])?$_POST['abdomenFin']:NULL);
				$caderaFin			  = $this->validateNumber(isset($_POST['caderaFin'])?$_POST['caderaFin']:NULL);
				$musloFin  			  = $this->validateNumber(isset($_POST['musloFin'])?$_POST['musloFin']:NULL);

				$pesoFin			  = ($pesoFin === ''?0:(double)$pesoFin);
				$bustoFin			  = ($bustoFin === ''?0:(double)$bustoFin);
				$diafragmaFin		  = ($diafragmaFin === ''?0:(double)$diafragmaFin);
				$brazoFin			  = ($brazoFin === ''?0:(double)$brazoFin);
				$cinturaFin			  = ($cinturaFin === ''?0:(double)$cinturaFin);
				$abdomenFin			  = ($abdomenFin === ''?0:(double)$abdomenFin);
				$caderaFin			  = ($caderaFin === ''?0:(double)$caderaFin);
				$musloFin			  = ($musloFin === ''?0:(double)$musloFin);
				
				$motivoConsulta		  = $this->validateText(isset($_POST['motivoConsulta'])?$_POST['motivoConsulta']:NULL);
				$tiempoProblema		  = $this->validateText(isset($_POST['tiempoProblema'])?$_POST['tiempoProblema']:NULL);
				$relacionaCon	  	  = $this->validateText(isset($_POST['relacionaCon'])?$_POST['relacionaCon']:NULL);
				$tratamientoAnterior  = $this->validateText(isset($_POST['tratamientoAnterior'])?$_POST['tratamientoAnterior']:NULL);
				$metProbados		  = $this->validateText(isset($_POST['metProbados'])?$_POST['metProbados']:NULL);
				$resAnteriores		  = $this->validateText(isset($_POST['resAnteriores'])?$_POST['resAnteriores']:NULL);
				
				$idHistorialMedico	  = $this->validateNumber(isset($_POST['idHistorialMedico'])?$_POST['idHistorialMedico']:NULL);
				$observaciones		  = $this->validateText(isset($_POST['observaciones'])?$_POST['observaciones']:NULL);
				
				$aguaAlDia	  		  = $this->validateText(isset($_POST['aguaAlDia'])?$_POST['aguaAlDia']:NULL);
				$alimentacion	  	  = $this->validateText(isset($_POST['alimentacion'])?$_POST['alimentacion']:NULL);
				
				$arregloExfolacion    = (isset($_POST['arregloExfolacion'])?$_POST['arregloExfolacion']:NULL);
				$arregloHabito		  = (isset($_POST['arregloHabito'])?$_POST['arregloHabito']:NULL);
				$arregloPadecimiento  = (isset($_POST['arregloPadecimiento'])?$_POST['arregloPadecimiento']:NULL);
				$arregloPiel		  = (isset($_POST['arregloPiel'])?$_POST['arregloPiel']:NULL);
				$arregloTipoCelulitis = (isset($_POST['arregloTipoCelulitis'])?$_POST['arregloTipoCelulitis']:NULL);

				//var_dump($arregloExfolacion);
				//var_dump($arregloHabito);
				//var_dump($arregloPadecimiento);
				//var_dump($arregloPiel);
				//var_dump($arregloTipoCelulitis);
				//die();
				
				//Los siguientes if's para los arreglos se borrarán
				/*if(count($arregloExfolacion) <= 1)
					$arregloExfolacion = array($arregloExfolacion);
				if(count($arregloHabito) <= 1)
					$arregloHabito =  array($arregloHabito);
				if(count($arregloPadecimiento) <= 1)
					$arregloPadecimiento =  array($arregloPadecimiento);
				if(count($arregloPiel) <= 1)
					$arregloPiel =  array($arregloPiel);
				if(count($arregloTipoCelulitis) <= 1)
					$arregloTipoCelulitis =  array($arregloTipoCelulitis);
				*/

				if(strlen($idHistorialMedico)==0)
					$errors['idHistorialMedico'] = 1;

				if (count($errors) == 0) {
					
					$poca = NULL;
					$regularAg = NULL;
					$mucha = NULL;

					switch ($aguaAlDia) {
						case 'poca':
							$poca = 'S';
							break;

						case 'regular':
							$regularAg = 'S';
							break;

						case 'mucha':
							$mucha = 'S';
							break;
						
						default:

					}

					$buena = NULL;
					$regularAl = NULL;
					$mala = NULL;

					switch ($alimentacion) {
						case 'buena':
							$buena = 'S';
							break;

						case 'regular':
							$regularAl = 'S';
							break;

						case 'mala':
							$mala = 'S';
							break;
						
						default:
					}
					
					$peelingQuim = NULL;
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
					
					//var_dump($arregloExfolacion);
					foreach($arregloExfolacion as $value){
						//var_dump($value);
						switch($value){
							case 'peelingQuim':
								//echo "string";
								//die();
								$peelingQuim ='S';
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
					}
					//die();
					
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

					$result 			= $this->model->update($idHistorialMedico, $observaciones, 
																$pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, $abdomenIni, $caderaIni, $musloIni,
																$pesoFin, $bustoFin, $diafragmaFin, $brazoFin, $cinturaFin, $abdomenFin, $caderaFin, $musloFin,
																$motivoConsulta, $tiempoProblema, $relacionaCon, $tratamientoAnterior, $metProbados, $resAnteriores,
																$poca,$regularAg,$mucha,$buena,$regularAl,$mala,
																$peelingQuim,$laser,$dermobrasion,$retinA,$renova,$racutan,
																$adapaleno,$acidoGlicolico,$alfaHidroiacidos,$exfolianteGranuloso,
																$acidoLactico,$vitaminaA,$blanqueadorAclarador, $fumar, $ejercicio, $usarFaja, $suenio, $tomaSol, $bloqueador, $hidroquinona,
																$diabetes, $obesisdad, $depresion, $estres, $sobrepeso, $estrenimiento, $colitis,
															    $retencionLiquidos, $transtornoMes, $cuidadoCorporal, $embarazo,
																$fina,$gruesa,$deshidratada,$flacida,$seca,$mixta,$grasa,$acneica,$manchas,
																$cicatrices,$poroAbierto,$ojeras,$lunares,$pecas,$puntosNegros,$verrugas,$arrugas,
																$brilloFacial,$pielAsfixiada,$despigmentacion, $fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa);

					if (!$result)
						echo 'Historial Medico';
					
					//Si pudo ser creado
					if ($result ){
						/*$data = array($idHistorialMedico, $idServicio, $observaciones, 
													$pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, $abdomenIni, $caderaIni, $musloIni,
													$pesoFin, $bustoFin, $diafragmaFin, $brazoFin, $cinturaFin, $abdomenFin, $caderaFin, $musloFin,
													$motivoConsulta, $tiempoProblema, $relacionaCon, $tratamientoAnterior, $metProbados, $resAnteriores,
													$poca,$regularAg,$mucha,$buena,$regularAl,$mala,
													$peelingQuim,$laser,$dermobrasion,$retinA,$renova,$racutan,
													$adapaleno,$acidoGlicolico,$alfaHidroiacidos,$exfolianteGranuloso,
													$acidoLactico,$vitaminaA,$blanqueadorAclarador, $fumar, $ejercicio, $usarFaja, $suenio, $tomaSol, $bloqueador, $hidroquinona,
													$diabetes, $obesisdad, $depresion, $estres, $sobrepeso, $estrenimiento, $colitis,
												    $retencionLiquidos, $transtornoMes, $cuidadoCorporal, $embarazo,
													$fina,$gruesa,$deshidratada,$flacida,$seca,$mixta,$grasa,$acneica,$manchas,
													$cicatrices,$poroAbierto,$ojeras,$lunares,$pecas,$puntosNegros,$verrugas,$arrugas,
													$brilloFacial,$pielAsfixiada,$despigmentacion, $fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa);*/
						//Cargar la vista
						echo $this->json_encode(array('error'=>OK,'data'=>NULL,'mensaje'=>'Correcto'));
					}else{
						echo $this->json_encode(array('error'=>ERROR_DB,'data'=>NULL,'mensaje'=>'Error al Realizar la Consulta'));
					}	
				}else{
					//Se cambiará por la misma vista donde se encuentre el formulario de insercción, y se mostrarán los errores en un modal
					echo $this->json_encode(array('error'=>FORMATO_INCORRECTO,'data'=>NULL,'mensaje'=>'Formato Incorrecto'));
				}
			}else{
				$this->session['action']='update';
				$template = $this->twig->loadTemplate('historialMedicoForm.html');
				echo $template->render(array('session'=>$this->session));
			}
		}

		/**
		*Listamos todos los Historiales Médicos
		**/
		private function lists(){
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
			require_once 'models/historialMedicoMdl.php';
			$this->model = new HistorialMedicoMdl();
		}
	}
?>
