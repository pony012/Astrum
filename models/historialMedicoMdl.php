<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo HistorialMedico del cliente
	*/
class HistorialMedicoMdl extends BaseMdl{
	private $idCliente;
	private $idServicio;
	private $observaciones;

	private $poca;
	private $regularAg;
	private $mucha;

	private $buena;
	private $regularAl;
	private $mala;

	private $peelingQuim;
	private $laser;
	private $dermobrasion;
	private $retinA;
	private $renova;
	private $racutan;
	private $adapaleno;
	private $acidoGlicolico;
	private $alfaHidroiacidos;
	private $exfolianteGranuloso;
	private $acidoLactico;
	private $vitaminaA;
	private $blanqueadorAclarador;

	private $pesoIni;
	private $bustoIni;
	private $diafragmaIni;
	private $brazoIni;
	private $cinturaIni;
	private $abdomenIni;
	private $caderaIni;
	private $musloIni;

	private $pesoFin;
	private $bustoFin;
	private $diafragmaFin;
	private $brazoFin;
	private $cinturaFin;
	private $abdomenFin;
	private $caderaFin;
	private $musloFin;

	private $motivoConsulta;
	private $tiempoProblema;
	private $relacionaCon;
	private $tratamientoAnterior;
	private $metProbados;
	private $resAnteriores;

	private $fumar;
	private $ejercicio;
	private $usarFaja;
	private $suenio;
	private $tomaSol;
	private $bloqueador;
	private $hidroquinona;

	private $diabetes;
	private $obesisdad;
	private $depresion;
	private $estres;
	private $sobrepeso;
	private $estrenimiento;
	private $colitis;
	private $retencionLiquidos;
	private $transtornoMes;
	private $cuidadoCorporal;
	private $embarazo;

	private $fina;
	private $gruesa;
	private $deshidratada;
	private $flacida;
	private $seca;
	private $mixta;
	private $grasa;
	private $acneica;
	private $manchas;
	private $cicatrices;
	private $poroAbierto;
	private $ojeras;
	private $lunares;
	private $pecas;
	private $puntosNegros;
	private $verrugas;
	private $arrugas;
	private $brilloFacial;
	private $pielAsfixiada;
	private $despigmentacion;

	private $fibrosa;
	private $edematosa;
	private $dura;
	private $dolorosa;
	
	/**
	 *@param integer $idCliente
	 *@param integer $idServicio
	 *@param string $observaciones
	 *Crea un nuevo historial medico de un cliente
	 *@return true
	 */
	function create($idCliente, $idServicio, $observaciones, 
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
					$brilloFacial,$pielAsfixiada,$despigmentacion, $fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa){
		$this->idCliente 		= $idCliente;
		$this->idServicio		= $idServicio;

		
		$this->observaciones	= $this->driver->real_escape_string($observaciones);

		$this->driver->autocommit(false);
		$this->driver->begin_transaction();
		
		$stmt = $this->driver->prepare("INSERT INTO HistorialMedico (IDCliente, IDServicio, Observaciones) 
										VALUES(?,?,?)");

		if(!$stmt->bind_param('iis',$this->idCliente,$this->idServicio,$this->observaciones)){
			$this->driver->rollback();
			return false;
		}
		if (!$stmt->execute()) {
			$this->driver->rollback();
			return false;
		}

		if($this->driver->error){
			$this->driver->rollback();
			return false;
		}

		$lastId = $this->driver->insert_id;
		
		if(!$this->createExploracionInicial($lastId, $pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, $abdomenIni, $caderaIni, $musloIni))
			$this->driver->rollback();
		if(!$this->createExploracionFinal($lastId, $pesoFin, $bustoFin, $diafragmaFin, $brazoFin, $cinturaFin, $abdomenFin, $caderaFin, $musloFin))
			$this->driver->rollback();
		if(!$this->createFichaClinica($lastId, $motivoConsulta, $tiempoProblema, $relacionaCon, $tratamientoAnterior, $metProbados, $resAnteriores))
			$this->driver->rollback();
		if(!$this->createAguaAlDia($lastId, $poca,$regularAg,$mucha))
			$this->driver->rollback();
		if(!$this->createAlimentacion($lastId, $buena,$regularAl,$mala))
			$this->driver->rollback();
		if(!$this->createExfoliacion($lastId, $peelingQuim,$laser,$dermobrasion,$retinA,$renova,$racutan,
									$adapaleno,$acidoGlicolico,$alfaHidroiacidos,$exfolianteGranuloso,
									$acidoLactico,$vitaminaA,$blanqueadorAclarador))
			$this->driver->rollback();
		if(!$this->createHabito($lastId, $fumar, $ejercicio, $usarFaja, $suenio, $tomaSol, $bloqueador, $hidroquinona))
			$this->driver->rollback();
		if(!$this->createPadecimiento($lastId, $diabetes, $obesisdad, $depresion, $estres, $sobrepeso, $estrenimiento, $colitis,
									   $retencionLiquidos, $transtornoMes, $cuidadoCorporal, $embarazo))
			$this->driver->rollback();
		if(!$this->createPiel($lastId, $fina,$gruesa,$deshidratada,$flacida,$seca,$mixta,$grasa,$acneica,$manchas,
								$cicatrices,$poroAbierto,$ojeras,$lunares,$pecas,$puntosNegros,$verrugas,$arrugas,
								$brilloFacial,$pielAsfixiada,$despigmentacion))
			$this->driver->rollback();
		if(!$this->createTipoCelulitis($lastId, $fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa))
			$this->driver->rollback();

		$this->driver->commit();
		$this->driver->autocommit(true);
		return true;
	}

	function update($idHistorialMedico,$observaciones, 
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
					$brilloFacial,$pielAsfixiada,$despigmentacion, $fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa){
		
		$this->observaciones	= $this->driver->real_escape_string($observaciones);

		$this->driver->autocommit(false);
		$this->driver->begin_transaction();
		
		$stmt = $this->driver->prepare("UPDATE HistorialMedico SET Observaciones=? WHERE IDHistorialMedico=?");

		if(!$stmt->bind_param('si',$this->observaciones,$idHistorialMedico)){
			$this->driver->rollback();
			return false;
		}
		if (!$stmt->execute()) {
			$this->driver->rollback();
			return false;
		}

		if($this->driver->error){
			$this->driver->rollback();
			return false;
		}
		
		if(!$this->updateExploracionInicial($idHistorialMedico, $pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, $abdomenIni, $caderaIni, $musloIni))
			$this->driver->rollback();
		if(!$this->updateExploracionFinal($idHistorialMedico, $pesoFin, $bustoFin, $diafragmaFin, $brazoFin, $cinturaFin, $abdomenFin, $caderaFin, $musloFin))
			$this->driver->rollback();
		if(!$this->updateFichaClinica($idHistorialMedico, $motivoConsulta, $tiempoProblema, $relacionaCon, $tratamientoAnterior, $metProbados, $resAnteriores))
			$this->driver->rollback();
		if(!$this->updateAguaAlDia($idHistorialMedico, $poca,$regularAg,$mucha))
			$this->driver->rollback();
		if(!$this->updateAlimentacion($idHistorialMedico, $buena,$regularAl,$mala))
			$this->driver->rollback();
		if(!$this->updateExfoliacion($idHistorialMedico, $peelingQuim,$laser,$dermobrasion,$retinA,$renova,$racutan,
									$adapaleno,$acidoGlicolico,$alfaHidroiacidos,$exfolianteGranuloso,
									$acidoLactico,$vitaminaA,$blanqueadorAclarador))
			$this->driver->rollback();
		if(!$this->updateHabito($idHistorialMedico, $fumar, $ejercicio, $usarFaja, $suenio, $tomaSol, $bloqueador, $hidroquinona))
			$this->driver->rollback();
		if(!$this->updatePadecimiento($idHistorialMedico, $diabetes, $obesisdad, $depresion, $estres, $sobrepeso, $estrenimiento, $colitis,
									   $retencionLiquidos, $transtornoMes, $cuidadoCorporal, $embarazo))
			$this->driver->rollback();
		if(!$this->updatePiel($idHistorialMedico, $fina,$gruesa,$deshidratada,$flacida,$seca,$mixta,$grasa,$acneica,$manchas,
								$cicatrices,$poroAbierto,$ojeras,$lunares,$pecas,$puntosNegros,$verrugas,$arrugas,
								$brilloFacial,$pielAsfixiada,$despigmentacion))
			$this->driver->rollback();
		if(!$this->updateTipoCelulitis($idHistorialMedico, $fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa))
			$this->driver->rollback();

		$this->driver->commit();
		$this->driver->autocommit(true);
		return true;
	}
	
	/**
	* Consulta todos los Historiales Medicos registrados
	*@param int $offset
	*@param int $idHistorialMedico
	* @return array or false
	**/
	function lists($offset = -1,$idHistorialMedico = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM V_HistorialMedico WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idHistorialMedico>-1){
				$stmt = $this->driver->prepare('SELECT * FROM V_HistorialMedico WHERE idHistorialMedico=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM V_HistorialMedico WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idHistorialMedico>-1){
				if(!$stmt->bind_param('i',$idHistorialMedico))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				if(empty($rows))
					return VACIO;
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}

	/**
	* @param Integer $idHistorialMedico
	* Consulta los detalles de las remisiones registradas
	* @return array or false
	**/
	function listsDetails($idHistorialMedico){
		$rows = array();

		$historialMedico = $this->lists(-1,$idHistorialMedico);
		if($historialMedico){
			if(is_numeric($historialMedico)){
				return $historialMedico;
			}else{
				array_push($rows, $historialMedico);
			}
		}else{
			return false;
		}

		$aguaAlDia = $this->listsAguaAlDia(-1,$idHistorialMedico);
		if($aguaAlDia){
			if(is_numeric($aguaAlDia)){
				return $aguaAlDia;
			}else{
				array_push($rows, $aguaAlDia);
			}
		}else{
			return false;
		}

		$alimentacion = $this->listsAlimentacion(-1,$idHistorialMedico);
		if($alimentacion){
			if(is_numeric($alimentacion)){
				return $alimentacion;
			}else{
				array_push($rows, $alimentacion);
			}
		}else{
			return false;
		}
		
		$exfoliacion = $this->listsExfoliacion(-1,$idHistorialMedico);
		if($exfoliacion){
			if(is_numeric($exfoliacion)){
				return $exfoliacion;
			}else{
				array_push($rows, $exfoliacion);
			}
		}else{
			return false;
		}
		
		$exploracionInicial = $this->listsExploracionInicial(-1,$idHistorialMedico);
		if($exploracionInicial){
			if(is_numeric($exploracionInicial)){
				return $exploracionInicial;
			}else{
				array_push($rows, $exploracionInicial);
			}
		}else{
			return false;
		}
		
		$exploracionFinal = $this->listsExploracionFinal(-1,$idHistorialMedico);
		if($exploracionFinal){
			if(is_numeric($exploracionFinal)){
				return $exploracionFinal;
			}else{
				array_push($rows, $exploracionFinal);
			}
		}else{
			return false;
		}
		
		$fichaClinica = $this->listsFichaClinica(-1,$idHistorialMedico);
		if($fichaClinica){
			if(is_numeric($fichaClinica)){
				return $fichaClinica;
			}else{
				array_push($rows, $fichaClinica);
			}
		}else{
			return false;
		}
		
		$habito = $this->listsHabito(-1,$idHistorialMedico);
		if($habito){
			if(is_numeric($habito)){
				return $habito;
			}else{
				array_push($rows, $habito);
			}
		}else{
			return false;
		}
		
		$padecimiento = $this->listsPadecimiento(-1,$idHistorialMedico);
		if($padecimiento){
			if(is_numeric($padecimiento)){
				return $padecimiento;
			}else{
				array_push($rows, $padecimiento);
			}
		}else{
			return false;
		}
		
		$piel = $this->listsPiel(-1,$idHistorialMedico);
		if($piel){
			if(is_numeric($piel)){
				return $piel;
			}else{
				array_push($rows, $piel);
			}
		}else{
			return false;
		}
		
		$tipoCelulitis = $this->listsTipoCelulitis(-1,$idHistorialMedico);
		if($tipoCelulitis){
			if(is_numeric($tipoCelulitis)){
				return $tipoCelulitis;
			}else{
				array_push($rows, $tipoCelulitis);
			}
		}else{
			return false;
		}

		if(empty($rows))
			return VACIO;
		return $rows;

	}

	/**
	 *@param int $idHistorialMedico
	 *@param string $poca
	 *@param string $regularAg
	 *@param string $mucha
	 *Crea un nuevo registro del consumo de agua diaria
	 *@return true
	 */
	function createAguaAlDia($idHistorialMedico, $poca,$regularAg,$mucha){
		$this->poca 	 	= $this->driver->real_escape_string($poca);
		$this->regularAg		= $this->driver->real_escape_string($regularAg);
		$this->mucha 		= $this->driver->real_escape_string($mucha);
		
		$stmt = $this->driver->prepare("INSERT INTO AguaAlDia (IDHistorialMedico,Poca,Regular,Mucha) VALUES (?,?,?,?)");
		if(!$stmt->bind_param('isss',$idHistorialMedico, $this->poca,$this->regularAg,$this->mucha))
			return false;
		if (!$stmt->execute()) 
			return false;
		if($this->driver->error)
			return false;

		return true;
	}

	/**
	*Actualiza la información de Agua al dia
	*@param int $idHistorialMedico
	*@param string $poca
	*@param string $regularAg
	*@param string $mucha
	*@return true or false
	**/
	function updateAguaAlDia($idHistorialMedico,$poca,$regularAg,$mucha){
		if($stmt = $this->driver->prepare('SELECT IDHistorialMedico FROM AguaAlDia WHERE IDHistorialMedico=?')){
		
			if(!$stmt->bind_param('i',$idHistorialMedico))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDHistorialMedico']!=''){
				$this->poca 	 = $this->driver->real_escape_string($poca);
				$this->regularAg 	 = $this->driver->real_escape_string($regularAg);
				$this->mucha 	 = $this->driver->real_escape_string($mucha);
				
				$stmt = $this->driver->prepare("UPDATE AguaAlDia SET Poca=?,Regular=?,Mucha=? WHERE IDHistorialMedico=?");

				if(!$stmt->bind_param('sssi',$this->poca,$this->regularAg,$this->mucha,$idHistorialMedico)){
					return false;
				}
				if (!$stmt->execute()) {
					return false;
				}

				if($this->driver->error){
					return false;
				}
				return true;
			}
		}
		else
			return false;
	}

	/**
	* Consulta los registros de Consumo de Agua al Día registrados en el sistema
	*@param int $offset
	*@param int $idHistorialMedico
	* @return array or false
	**/
	function listsAguaAlDia($offset = -1,$idHistorialMedico = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM AguaAlDia WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idHistorialMedico>-1){
				$stmt = $this->driver->prepare('SELECT * FROM AguaAlDia WHERE IDHistorialMedico=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM AguaAlDia WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idHistorialMedico>-1){
				if(!$stmt->bind_param('i',$idHistorialMedico))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				if(empty($rows))
					return VACIO;
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}



	/**
	 *@param int $idHistorialMedico
	 *@param string $buena
	 *@param string $regularAl
	 *@param string $mala
	 *Crea un nuevo registro de alimentacion
	 *@return true
	 */
	function createAlimentacion($idHistorialMedico, $buena,$regularAl,$mala){
		$this->buena 	 = $this->driver->real_escape_string($buena);
		$this->regularAl = $this->driver->real_escape_string($regularAl);
		$this->mala 	 = $this->driver->real_escape_string($mala);
		
		$stmt = $this->driver->prepare("INSERT INTO Alimentacion (IDHistorialMedico,Buena,Regular,Mala) VALUES (?,?,?,?)");
		
		if(!$stmt->bind_param('isss',$idHistorialMedico, $this->buena,$this->regularAl,$this->mala))
			return false;
		if (!$stmt->execute()) 
			return false;
		if($this->driver->error)
			return false;

		return true;
	}

	/**
	*Actualiza la información de la Alimentación
	*@param int $idHistorialMedico
	*@param string $buena
	*@param string $regularAl
	*@param string $mala
	*@return true or false
	**/
	function updateAlimentacion($idHistorialMedico,$buena,$regularAl,$mala){
		if($stmt = $this->driver->prepare('SELECT IDHistorialMedico FROM Alimentacion WHERE IDHistorialMedico=?')){
		
			if(!$stmt->bind_param('i',$idHistorialMedico))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDHistorialMedico']!=''){
				$this->buena 	 = $this->driver->real_escape_string($buena);
				$this->regularAl 	 = $this->driver->real_escape_string($regularAl);
				$this->mala 	 = $this->driver->real_escape_string($mala);
				
				$stmt = $this->driver->prepare("UPDATE Alimentacion SET Buena=?,Regular=?,Mala=? WHERE IDHistorialMedico=?");

				if(!$stmt->bind_param('sssi',$this->buena,$this->regularAl,$this->mala,$idHistorialMedico)){
					return false;
				}
				if (!$stmt->execute()) {
					return false;
				}

				if($this->driver->error){
					return false;
				}
				return true;
			}
		}
		else
			return false;
	}

	/**
	* Consulta las alimentaciones registrados en el sistema
	*@param int $offset
	*@param int $idHistorialMedico
	* @return array or false
	**/
	function listsAlimentacion($offset = -1,$idHistorialMedico = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM Alimentacion WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idHistorialMedico>-1){
				$stmt = $this->driver->prepare('SELECT * FROM Alimentacion WHERE IDHistorialMedico=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM Alimentacion WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idHistorialMedico>-1){
				if(!$stmt->bind_param('i',$idHistorialMedico))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				if(empty($rows))
					return VACIO;
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}


	/**
	 *@param int $idHistorialMedico
	 *@param string $peelingQuim
	 *@param string $laser
	 *@param string $dermobrasion
	 *@param string $retinA
	 *@param string $racutan
	 *@param string $adapaleno
	 *@param string $acidoGlicolico
	 *@param string $exfolianteGranuloso
	 *@param string $acidoLactico
	 *@param string $vitaminaA
	 *@param string $blanqueadorAclarador
	 *Crea un nuevo registro de Exfoliacion
	 *@return true
	 */
	function createExfoliacion($idHistorialMedico, $peelingQuim,$laser,$dermobrasion,$retinA,$renova,$racutan,
					$adapaleno,$acidoGlicolico,$alfaHidroiacidos,$exfolianteGranuloso,
					$acidoLactico,$vitaminaA,$blanqueadorAclarador){
		$this->peelingQuim			= $this->driver->real_escape_string($peelingQuim);
		$this->laser				= $this->driver->real_escape_string($laser);
		$this->dermobrasion			= $this->driver->real_escape_string($dermobrasion);
		$this->retinA				= $this->driver->real_escape_string($retinA);
		$this->renova				= $this->driver->real_escape_string($renova);
		$this->racutan				= $this->driver->real_escape_string($racutan);
		$this->adapaleno			= $this->driver->real_escape_string($adapaleno);
		$this->acidoGlicolico		= $this->driver->real_escape_string($acidoGlicolico);
		$this->alfaHidroiacidos		= $this->driver->real_escape_string($alfaHidroiacidos);
		$this->exfolianteGranuloso	= $this->driver->real_escape_string($exfolianteGranuloso);
		$this->acidoLactico			= $this->driver->real_escape_string($acidoLactico);
		$this->vitaminaA			= $this->driver->real_escape_string($vitaminaA);
		$this->blanqueadorAclarador	= $this->driver->real_escape_string($blanqueadorAclarador);

		$stmt = $this->driver->prepare("INSERT INTO Exfoliacion (IDHistorialMedico,PeelingQuimico, Laser, Dermoabrasion, RetinA, Renova, Racutan, Adapaleno, AcidoGlicolico, AlfaHidroxiacidos, ExfolianteGranuloso,AcidoLactico, VitaminaA, BlanqueadorOAclarador) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		//var_dump($stmt);
		//echo $this->driver->error;
		//die();
		if(!$stmt->bind_param('isssssssssssss',	$idHistorialMedico, $this->peelingQuim, $this->laser, $this->dermobrasion, $this->retinA, $this->renova, 
												$this->racutan, $this->adapaleno, $this->acidoGlicolico, $this->alfaHidroiacidos, 
												$this->exfolianteGranuloso, $this->acidoLactico, $this->vitaminaA, $this->blanqueadorAclarador)){
			return false;
		}
		if (!$stmt->execute()) {
			return false;
		}

		if($this->driver->error){
			return false;
		}

		return true;
	}

	/**
	*Actualiza la información de la Alimentación
	*@param int $idHistorialMedico
	*@param string $peelingQuim
	*@param string $laser
	*@param string $dermobrasion
	*@param string $retinA
	*@param string $racutan
	*@param string $adapaleno
	*@param string $acidoGlicolico
	*@param string $exfolianteGranuloso
	*@param string $acidoLactico
	*@param string $vitaminaA
	*@param string $blanqueadorAclarador
	*@return true or false
	**/
	function updateExfoliacion($idHistorialMedico, $peelingQuim,$laser,$dermobrasion,$retinA,$renova,$racutan,
					$adapaleno,$acidoGlicolico,$alfaHidroiacidos,$exfolianteGranuloso,
					$acidoLactico,$vitaminaA,$blanqueadorAclarador){
		if($stmt = $this->driver->prepare('SELECT IDHistorialMedico FROM Exfoliacion WHERE IDHistorialMedico=?')){
		
			if(!$stmt->bind_param('i',$idHistorialMedico))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDHistorialMedico']!=''){
				$this->peelingQuim			= $this->driver->real_escape_string($peelingQuim);
				$this->laser				= $this->driver->real_escape_string($laser);
				$this->dermobrasion			= $this->driver->real_escape_string($dermobrasion);
				$this->retinA				= $this->driver->real_escape_string($retinA);
				$this->renova				= $this->driver->real_escape_string($renova);
				$this->racutan				= $this->driver->real_escape_string($racutan);
				$this->adapaleno			= $this->driver->real_escape_string($adapaleno);
				$this->acidoGlicolico		= $this->driver->real_escape_string($acidoGlicolico);
				$this->alfaHidroiacidos		= $this->driver->real_escape_string($alfaHidroiacidos);
				$this->exfolianteGranuloso	= $this->driver->real_escape_string($exfolianteGranuloso);
				$this->acidoLactico			= $this->driver->real_escape_string($acidoLactico);
				$this->vitaminaA			= $this->driver->real_escape_string($vitaminaA);
				$this->blanqueadorAclarador	= $this->driver->real_escape_string($blanqueadorAclarador);
				
				$stmt = $this->driver->prepare("UPDATE Exfoliacion SET PeelingQuimico=?, Laser=?, Dermoabrasion=?, RetinA=?, Renova=?, Racutan=?, 
																Adapaleno=?, AcidoGlicolico=?, AlfaHidroxiacidos=?, ExfolianteGranuloso=?,
																AcidoLactico=?, VitaminaA=?, BlanqueadorOAclarador=? WHERE IDHistorialMedico=?");

				if(!$stmt->bind_param('sssssssssssssi',$this->peelingQuim, $this->laser, $this->dermobrasion, $this->retinA, $this->renova, 
												$this->racutan, $this->adapaleno, $this->acidoGlicolico, $this->alfaHidroiacidos, 
												$this->exfolianteGranuloso, $this->acidoLactico, $this->vitaminaA, $this->blanqueadorAclarador,$idHistorialMedico)){
					return false;
				}
				if (!$stmt->execute()) {
					return false;
				}

				if($this->driver->error){
					return false;
				}
				return true;
			}
		}
		else
			return false;
	}

	/**
	* Consulta las alimentaciones registrados en el sistema
	*@param int $offset
	*@param int $idHistorialMedico
	*@return array or false
	**/
	function listsExfoliacion($offset = -1,$idHistorialMedico = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM Exfoliacion WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idHistorialMedico>-1){
				$stmt = $this->driver->prepare('SELECT * FROM Exfoliacion WHERE IDHistorialMedico=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM Exfoliacion WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idHistorialMedico>-1){
				if(!$stmt->bind_param('i',$idHistorialMedico))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				if(empty($rows))
					return VACIO;
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}

	/**
	 *@param decimal $pesoIni
	 *@param decimal $bustoIni
	 *@param decimal $diafragmaIni
	 *@param decimal $brazoIni
	 *@param decimal $cinturaIni
	 *@param decimal $abdomenIni
	 *@param decimal $caderaIni
	 *@param decimal $musloIni
	 *Crea una nueva exploracion con los datos iniciales de un cliente
	 *@return true or false
	 */
	function createExploracionInicial($idHistorialMedico, $pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, $abdomenIni, $caderaIni, $musloIni){
		$this->pesoIni 		= $pesoIni;
		$this->bustoIni 	= $bustoIni;
		$this->diafragmaIni = $diafragmaIni;
		$this->brazoIni 	= $brazoIni;
		$this->cinturaIni 	= $cinturaIni;
		$this->abdomenIni 	= $abdomenIni;
		$this->caderaIni 	= $caderaIni;
		$this->musloIni 	= $musloIni;
		$stmt = $this->driver->prepare("INSERT INTO ExploracionInicial (IDHistorialMedico,PesoInicial,BustoInicial,DiafragmaInicial,BrazoInicial,CinturaInicial,
										AbdomenInicial,CaderaInicial,MusloInicial) VALUES (?,?,?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('idddddddd',$idHistorialMedico, $this->pesoIni,$this->bustoIni,$this->diafragmaIni,$this->brazoIni,$this->cinturaIni,$this->abdomenIni,
			$this->caderaIni,$this->musloIni))
			return false;
		if (!$stmt->execute()) 
			return false;
		if($this->driver->error)
			return false;
		
		return true;
	}

	/**
	*Actualiza la información de la Exploración Inicial
	*@param decimal $pesoIni
	 *@param decimal $bustoIni
	 *@param decimal $diafragmaIni
	 *@param decimal $brazoIni
	 *@param decimal $cinturaIni
	 *@param decimal $abdomenIni
	 *@param decimal $caderaIni
	 *@param decimal $musloIni
	*@return true or false
	**/
	function updateExploracionInicial($idHistorialMedico, $pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, $abdomenIni, $caderaIni, $musloIni){
		if($stmt = $this->driver->prepare('SELECT IDHistorialMedico FROM ExploracionInicial WHERE IDHistorialMedico=?')){
		
			if(!$stmt->bind_param('i',$idHistorialMedico))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDHistorialMedico']!=''){
				$this->pesoIni 		= $this->driver->real_escape_string($pesoIni);
				$this->bustoIni 	= $this->driver->real_escape_string($bustoIni);
				$this->diafragmaIni = $this->driver->real_escape_string($diafragmaIni);
				$this->brazoIni 	= $this->driver->real_escape_string($brazoIni);
				$this->cinturaIni 	= $this->driver->real_escape_string($cinturaIni);
				$this->abdomenIni 	= $this->driver->real_escape_string($abdomenIni);
				$this->caderaIni 	= $this->driver->real_escape_string($caderaIni);
				$this->musloIni 	= $this->driver->real_escape_string($musloIni);
				
				$stmt = $this->driver->prepare("UPDATE ExploracionInicial SET PesoInicial=?,BustoInicial=?,DiafragmaInicial=?,BrazoInicial=?,CinturaInicial=?,
										AbdomenInicial=?,CaderaInicial=?,MusloInicial=? WHERE IDHistorialMedico=?");

				if(!$stmt->bind_param('ddddddddi',$this->pesoIni,$this->bustoIni,$this->diafragmaIni,$this->brazoIni,$this->cinturaIni,$this->abdomenIni,
													$this->caderaIni,$this->musloIni,$idHistorialMedico)){
					return false;
				}
				if (!$stmt->execute()) {
					return false;
				}

				if($this->driver->error){
					return false;
				}
				return true;
			}
		}
		else
			return false;
	}

	/**
	* Consulta las Exploraciones Iniciales registrados en el sistema
	*@param int $offset
	*@param int $idHistorialMedico
	* @return array or false
	**/
	function listsExploracionInicial($offset = -1,$idHistorialMedico = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM ExploracionInicial WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idHistorialMedico>-1){
				$stmt = $this->driver->prepare('SELECT * FROM ExploracionInicial WHERE IDHistorialMedico=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM ExploracionInicial WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idHistorialMedico>-1){
				if(!$stmt->bind_param('i',$idHistorialMedico))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				if(empty($rows))
					return VACIO;
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}

	/**
	 *@param decimal $pesoFin
	 *@param decimal $bustoFin
	 *@param decimal $diafragmaFin
	 *@param decimal $brazoFin
	 *@param decimal $cinturaFin
	 *@param decimal $abdomenFin
	 *@param decimal $caderaFin
	 *@param decimal $musloFin
	 *Inserta los datos finales de la exploracion de un cliente
	 *@return true
	**/
	function createExploracionFinal($idHistorialMedico, $pesoFin, $bustoFin, $diafragmaFin, $brazoFin, $cinturaFin, $abdomenFin, $caderaFin, $musloFin){
		$this->pesoFin 		= $pesoFin;
		$this->bustoFin 	= $bustoFin;
		$this->diafragmaFin = $diafragmaFin;
		$this->brazoFin 	= $brazoFin;
		$this->cinturaFin 	= $cinturaFin;
		$this->abdomenFin 	= $abdomenFin;
		$this->caderaFin 	= $caderaFin;
		$this->musloFin 	= $musloFin;

		$stmt = $this->driver->prepare("INSERT INTO ExploracionFinal (IDHistorialMedico,PesoFinal,BustoFinal,DiafragmaFinal,BrazoFinal,CinturaFinal,
										AbdomenFinal,CaderaFinal,MusloFinal) VALUES (?,?,?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('idddddddd',$idHistorialMedico, $this->pesoFin,$this->bustoFin,$this->diafragmaFin,$this->brazoFin,$this->cinturaFin,$this->abdomenFin,
			$this->caderaFin,$this->musloFin))
			return false;
		if (!$stmt->execute()) 
			return false;
		if($this->driver->error)
			return false;
		
		return true;
	}

	/**
	*Actualiza la información de la Exploración Final
	*@param decimal $pesoFin
	 *@param decimal $bustoFin
	 *@param decimal $diafragmaFin
	 *@param decimal $brazoFin
	 *@param decimal $cinturaFin
	 *@param decimal $abdomenFin
	 *@param decimal $caderaFin
	 *@param decimal $musloFin
	*@return true or false
	**/
	function updateExploracionFinal($idHistorialMedico, $pesoFin, $bustoFin, $diafragmaFin, $brazoFin, $cinturaFin, $abdomenFin, $caderaFin, $musloFin){
		if($stmt = $this->driver->prepare('SELECT IDHistorialMedico FROM ExploracionFinal WHERE IDHistorialMedico=?')){
		
			if(!$stmt->bind_param('i',$idHistorialMedico))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDHistorialMedico']!=''){
				$this->pesoFin 		= $this->driver->real_escape_string($pesoFin);
				$this->bustoFin 	= $this->driver->real_escape_string($bustoFin);
				$this->diafragmaFin = $this->driver->real_escape_string($diafragmaFin);
				$this->brazoFin 	= $this->driver->real_escape_string($brazoFin);
				$this->cinturaFin 	= $this->driver->real_escape_string($cinturaFin);
				$this->abdomenFin 	= $this->driver->real_escape_string($abdomenFin);
				$this->caderaFin 	= $this->driver->real_escape_string($caderaFin);
				$this->musloFin 	= $this->driver->real_escape_string($musloFin);
				
				$stmt = $this->driver->prepare("UPDATE ExploracionFinal SET PesoFinal=?,BustoFinal=?,DiafragmaFinal=?,BrazoFinal=?,CinturaFinal=?,
										AbdomenFinal=?,CaderaFinal=?,MusloFinal=? WHERE IDHistorialMedico=?");

				if(!$stmt->bind_param('ddddddddi',$this->pesoFin,$this->bustoFin,$this->diafragmaFin,$this->brazoFin,$this->cinturaFin,$this->abdomenFin,
													$this->caderaFin,$this->musloFin,$idHistorialMedico)){
					return false;
				}
				if (!$stmt->execute()) {
					return false;
				}

				if($this->driver->error){
					return false;
				}
				return true;
			}
		}
		else
			return false;
	}

	/**
	* Consulta las Exploraciones Finales registrados en el sistema
	*@param int $offset
	*@param int $idHistorialMedico
	* @return array or false
	**/
	function listsExploracionFinal($offset = -1,$idHistorialMedico = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM ExploracionFinal WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idHistorialMedico>-1){
				$stmt = $this->driver->prepare('SELECT * FROM ExploracionFinal WHERE IDHistorialMedico=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM ExploracionFinal WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idHistorialMedico>-1){
				if(!$stmt->bind_param('i',$idHistorialMedico))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				if(empty($rows))
					return VACIO;
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}


	/**
	 *@param int $idHistorialMedico
	 *@param string $motivoConsulta
	 *@param string $tiempoProblema
	 *@param string $relacionaCon
	 *@param string $tratamientoAnterior
	 *@param string $metProbados
	 *@param string $resAnteriores
	 *Crea un nuevo registro de Ficha Clinica
	 *@return true
	 */
	function createFichaClinica($idHistorialMedico, $motivoConsulta, $tiempoProblema, $relacionaCon, $tratamientoAnterior, $metProbados, $resAnteriores){
		$this->motivoConsulta		= $this->driver->real_escape_string($motivoConsulta);
		$this->tiempoProblema		= $this->driver->real_escape_string($tiempoProblema);
		$this->relacionaCon 		= $this->driver->real_escape_string($relacionaCon);
		$this->tratamientoAnterior 	= $this->driver->real_escape_string($tratamientoAnterior);
		$this->metProbados 			= $this->driver->real_escape_string($metProbados);
		$this->resAnteriores 		= $this->driver->real_escape_string($resAnteriores);
		
		$stmt = $this->driver->prepare("INSERT INTO FichaClinica (IDHistorialMedico,MotivoConsulta, TiempoProblema, RelacionaCon, TratamientoAnterior, 
																	MetodosProbados, ResultadosAnteriores) 
										VALUES(?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('issssss',$idHistorialMedico, $this->motivoConsulta, $this->tiempoProblema, $this->relacionaCon, $this->tratamientoAnterior, 
										$this->metProbados, $this->resAnteriores)){
			return false;
		}
		if (!$stmt->execute()) {
			return false;
		}

		if($this->driver->error){
			return false;
		}

		return true;
	}

	/**
	*Actualiza la información de la Ficha Clínica
	*@param int $idHistorialMedico
	*@param string $motivoConsulta
	*@param string $tiempoProblema
	*@param string $relacionaCon
	*@param string $tratamientoAnterior
	*@param string $metProbados
	*@param string $resAnteriores
	*@return true or false
	**/
	function updateFichaClinica($idHistorialMedico, $motivoConsulta, $tiempoProblema, $relacionaCon, $tratamientoAnterior, $metProbados, $resAnteriores){
		if($stmt = $this->driver->prepare('SELECT IDHistorialMedico FROM FichaClinica WHERE IDHistorialMedico=?')){
		
			if(!$stmt->bind_param('i',$idHistorialMedico))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDHistorialMedico']!=''){
				$this->motivoConsulta		= $this->driver->real_escape_string($motivoConsulta);
				$this->tiempoProblema		= $this->driver->real_escape_string($tiempoProblema);
				$this->relacionaCon 		= $this->driver->real_escape_string($relacionaCon);
				$this->tratamientoAnterior 	= $this->driver->real_escape_string($tratamientoAnterior);
				$this->metProbados 			= $this->driver->real_escape_string($metProbados);
				$this->resAnteriores 		= $this->driver->real_escape_string($resAnteriores);
				
				$stmt = $this->driver->prepare("UPDATE FichaClinica SET MotivoConsulta=?, TiempoProblema=?, RelacionaCon=?, TratamientoAnterior=?, 
																	MetodosProbados=?, ResultadosAnteriores=? WHERE IDHistorialMedico=?");

				if(!$stmt->bind_param('ssssssi',$this->motivoConsulta, $this->tiempoProblema, $this->relacionaCon, $this->tratamientoAnterior, 
										$this->metProbados, $this->resAnteriores,$idHistorialMedico)){
					return false;
				}
				if (!$stmt->execute()) {
					return false;
				}

				if($this->driver->error){
					return false;
				}
				return true;
			}
		}
		else
			return false;
	}

	/**
	* Consulta las Fichas Clínicas registrados en el sistema
	*@param int $offset
	*@param int $idHistorialMedico
	* @return array or false
	**/
	function listsFichaClinica($offset = -1,$idHistorialMedico = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM FichaClinica WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idHistorialMedico>-1){
				$stmt = $this->driver->prepare('SELECT * FROM FichaClinica WHERE IDHistorialMedico=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM FichaClinica WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idHistorialMedico>-1){
				if(!$stmt->bind_param('i',$idHistorialMedico))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				if(empty($rows))
					return VACIO;
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}


	/**
	*@param string $fumar
	*@param string $ejercicio
	*@param string $usarFaja
	*@param string $suenio
	*@param string $tomaSol
	*@param string $bloqueador
	*@param string $hidroquinona
	*Crea un nuevo registro de habito
	 *@return true
	 */
	function createHabito($idHistorialMedico, $fumar, $ejercicio, $usarFaja, $suenio, $tomaSol, $bloqueador, $hidroquinona){
		$this->fumar 		= $this->driver->real_escape_string($fumar);
		$this->ejercicio 	= $this->driver->real_escape_string($ejercicio);
		$this->usarFaja 	= $this->driver->real_escape_string($usarFaja);
		$this->suenio 		= $this->driver->real_escape_string($suenio);
		$this->tomaSol 		= $this->driver->real_escape_string($tomaSol);
		$this->bloqueador 	= $this->driver->real_escape_string($bloqueador);
		$this->hidroquinona = $this->driver->real_escape_string($hidroquinona);
		
		$stmt = $this->driver->prepare("INSERT INTO Habito (IDHistorialMedico, Fumar, Ejercicio, UsarFaja, Suenio, TomaSol, Bloqueador, Hidroquinona) 
										VALUES (?,?,?,?,?,?,?,?)");
		//echo $this->driver->error;
		//die();
		if(!$stmt->bind_param('isssssss',$idHistorialMedico, $this->fumar, $this->ejercicio, $this->usarFaja, $this->suenio, $this->tomaSol, $this->bloqueador, $this->hidroquinona)){
			return false;
		}
		if (!$stmt->execute()) {
			return false;
		}

		if($this->driver->error){
			return false;
		}

		return true;
	}

	/**
	*Actualiza la información de Habito
	*@param int $idHistorialMedico
	*@param string $fumar
	 *@param string $ejercicio
	 *@param string $usarFaja
	 *@param string $suenio
	 *@param string $tomaSol
	 *@param string $bloqueador
	 *@param string $hidroquinona
	*@return true or false
	**/
	function updateHabito($idHistorialMedico, $fumar, $ejercicio, $usarFaja, $suenio, $tomaSol, $bloqueador, $hidroquinona){
		if($stmt = $this->driver->prepare('SELECT IDHistorialMedico FROM Habito WHERE IDHistorialMedico=?')){
		
			if(!$stmt->bind_param('i',$idHistorialMedico))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDHistorialMedico']!=''){
				$this->fumar 		= $this->driver->real_escape_string($fumar);
				$this->ejercicio 	= $this->driver->real_escape_string($ejercicio);
				$this->usarFaja 	= $this->driver->real_escape_string($usarFaja);
				$this->suenio 		= $this->driver->real_escape_string($suenio);
				$this->tomaSol 		= $this->driver->real_escape_string($tomaSol);
				$this->bloqueador 	= $this->driver->real_escape_string($bloqueador);
				$this->hidroquinona = $this->driver->real_escape_string($hidroquinona);
				
				$stmt = $this->driver->prepare("UPDATE Habito SET Fumar=?, Ejercicio=?, UsarFaja=?, Suenio=?, TomaSol=?, Bloqueador=?, 
												Hidroquinona=? WHERE IDHistorialMedico=?");

				if(!$stmt->bind_param('sssssssi',$this->fumar, $this->ejercicio, $this->usarFaja, $this->suenio, $this->tomaSol, $this->bloqueador, $this->hidroquinona,$idHistorialMedico)){
					return false;
				}
				if (!$stmt->execute()) {
					return false;
				}

				if($this->driver->error){
					return false;
				}
				return true;
			}
		}
		else
			return false;
	}

	/**
	* Consulta los Habitos registrados en el sistema
	*@param int $offset
	*@param int $idHistorialMedico
	* @return array or false
	**/
	function listsHabito($offset = -1,$idHistorialMedico = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM Habito WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idHistorialMedico>-1){
				$stmt = $this->driver->prepare('SELECT * FROM Habito WHERE IDHistorialMedico=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM Habito WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idHistorialMedico>-1){
				if(!$stmt->bind_param('i',$idHistorialMedico))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				if(empty($rows))
					return VACIO;
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}


	/**
	 *@param int $idHistorialMedico
	 *@param string $diabetes
	 *@param string $obesisdad
	 *@param string $depresion
	 *@param string $estres
	 *@param string $sobrepeso
	 *@param string $estrenimiento
	 *@param string $colitis
	 *@param string $retencionLiquidos
	 *@param string $transtornoMes
	 *@param string $cuidadoCorporal
	 *@param string $embarazo
	 *Crea un nuevo registro de Padecimiento
	 *@return true
	 */
	function createPadecimiento($idHistorialMedico, $diabetes, $obesisdad, $depresion, $estres, $sobrepeso, $estrenimiento, $colitis,
					$retencionLiquidos, $transtornoMes, $cuidadoCorporal, $embarazo){
		$this->diabetes 		 = $this->driver->real_escape_string($diabetes);
		$this->obesisdad  		 = $this->driver->real_escape_string($obesisdad);
		$this->depresion 		 = $this->driver->real_escape_string($depresion);
		$this->estres  			 = $this->driver->real_escape_string($estres);
		$this->sobrepeso 		 = $this->driver->real_escape_string($sobrepeso);
		$this->estrenimiento	 = $this->driver->real_escape_string($estrenimiento);
		$this->colitis 			 = $this->driver->real_escape_string($colitis);
		$this->retencionLiquidos = $this->driver->real_escape_string($retencionLiquidos);
		$this->transtornoMes 	 = $this->driver->real_escape_string($transtornoMes);
		$this->cuidadoCorporal   = $this->driver->real_escape_string($cuidadoCorporal);
		$this->embarazo   		 = $embarazo;
		
		$stmt = $this->driver->prepare("INSERT INTO Padecimiento (IDHistorialMedico,Diabetes, Obesisdad, Depresion, Estres, Sobrepeso, Estrenimiento,
																Colitis, RetencionLiquidos, TranstornosMenstruales, CuidadosCorporales, Embarazo) 
										VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
		//echo $this->driver->error;
		//die();
		if(!$stmt->bind_param('issssssssssi',$idHistorialMedico, $this->diabetes,$this->obesisdad,$this->depresion,$this->estres,$this->sobrepeso,$this->estrenimiento,
											$this->colitis,$this->retencionLiquidos,$this->transtornoMes,$this->cuidadoCorporal,$this->embarazo)){
			return false;
		}
		if (!$stmt->execute()) {
			return false;
		}

		if($this->driver->error){
			return false;
		}

		return true;
	}

	/**
	*Actualiza la información de Padecimiento
	*@param int $idHistorialMedico
	*@param string $diabetes
	*@param string $obesisdad
	*@param string $depresion
	*@param string $estres
	*@param string $sobrepeso
	*@param string $estrenimiento
	*@param string $colitis
	*@param string $retencionLiquidos
	*@param string $transtornoMes
	*@param string $cuidadoCorporal
	*@param string $embarazo
	*@return true or false
	**/
	function updatePadecimiento($idHistorialMedico, $diabetes, $obesisdad, $depresion, $estres, $sobrepeso, $estrenimiento, $colitis,
					$retencionLiquidos, $transtornoMes, $cuidadoCorporal, $embarazo){
		if($stmt = $this->driver->prepare('SELECT IDHistorialMedico FROM Padecimiento WHERE IDHistorialMedico=?')){
		
			if(!$stmt->bind_param('i',$idHistorialMedico))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDHistorialMedico']!=''){
				$this->diabetes 		 = $this->driver->real_escape_string($diabetes);
				$this->obesisdad  		 = $this->driver->real_escape_string($obesisdad);
				$this->depresion 		 = $this->driver->real_escape_string($depresion);
				$this->estres  			 = $this->driver->real_escape_string($estres);
				$this->sobrepeso 		 = $this->driver->real_escape_string($sobrepeso);
				$this->estrenimiento	 = $this->driver->real_escape_string($estrenimiento);
				$this->colitis 			 = $this->driver->real_escape_string($colitis);
				$this->retencionLiquidos = $this->driver->real_escape_string($retencionLiquidos);
				$this->transtornoMes 	 = $this->driver->real_escape_string($transtornoMes);
				$this->cuidadoCorporal   = $this->driver->real_escape_string($cuidadoCorporal);
				$this->embarazo   		 = $embarazo;
				
				$stmt = $this->driver->prepare("UPDATE Padecimiento SET Diabetes=?, Obesisdad=?, Depresion=?, Estres=?, Sobrepeso=?, Estrenimiento=?,
																Colitis=?, RetencionLiquidos=?, TranstornosMenstruales=?, CuidadosCorporales=?, Embarazo=? WHERE IDHistorialMedico=?");

				if(!$stmt->bind_param('ssssssssssdi',$this->diabetes,$this->obesisdad,$this->depresion,$this->estres,$this->sobrepeso,$this->estrenimiento,
											$this->colitis,$this->retencionLiquidos,$this->transtornoMes,$this->cuidadoCorporal,$this->embarazo,$idHistorialMedico)){
					return false;
				}
				if (!$stmt->execute()) {
					return false;
				}

				if($this->driver->error){
					return false;
				}
				return true;
			}
		}
		else
			return false;
	}

	/**
	* Consulta los Padecimientos registrados en el sistema
	*@param int $offset
	*@param int $idHistorialMedico
	* @return array or false
	**/
	function listsPadecimiento($offset = -1,$idHistorialMedico = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM Padecimiento WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idHistorialMedico>-1){
				$stmt = $this->driver->prepare('SELECT * FROM Padecimiento WHERE IDHistorialMedico=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM Padecimiento WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idHistorialMedico>-1){
				if(!$stmt->bind_param('i',$idHistorialMedico))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				if(empty($rows))
					return VACIO;
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}


	/**
	 *@param int $idHistorialMedico
	 *@param string $fina
	 *@param string $gruesa
	 *@param string $deshidratada
	 *@param string $flacida
	 *@param string $seca
	 *@param string $mixta
	 *@param string $grasa
	 *@param string $acneica
	 *@param string $manchas
	 *@param string $cicatrices
	 *@param string $poroAbierto
	 *@param string $ojeras
	 *@param string $lunares
	 *@param string $pecas
	 *@param string $puntosNegros
	 *@param string $verrugas
	 *@param string $arrugas
	 *@param string $brilloFacial
	 *@param string $pielAsfixiada
	 *@param string $despigmentacion
	 *Crea un nuevo
	 *@return true
	 */
	function createPiel($idHistorialMedico, $fina,$gruesa,$deshidratada,$flacida,$seca,$mixta,$grasa,$acneica,$manchas,
					$cicatrices,$poroAbierto,$ojeras,$lunares,$pecas,$puntosNegros,$verrugas,$arrugas,
					$brilloFacial,$pielAsfixiada,$despigmentacion){
		$this->fina 			= $this->driver->real_escape_string($fina);
		$this->gruesa 			= $this->driver->real_escape_string($gruesa);
		$this->deshidratada 	= $this->driver->real_escape_string($deshidratada);
		$this->flacida 			= $this->driver->real_escape_string($flacida);
		$this->seca 			= $this->driver->real_escape_string($seca);
		$this->mixta 			= $this->driver->real_escape_string($mixta);
		$this->grasa 			= $this->driver->real_escape_string($grasa);
		$this->acneica 			= $this->driver->real_escape_string($acneica);
		$this->manchas 			= $this->driver->real_escape_string($manchas);
		$this->cicatrices 		= $this->driver->real_escape_string($cicatrices);
		$this->poroAbierto 		= $this->driver->real_escape_string($poroAbierto);
		$this->ojeras 			= $this->driver->real_escape_string($ojeras);
		$this->lunares 			= $this->driver->real_escape_string($lunares);
		$this->pecas 			= $this->driver->real_escape_string($pecas);
		$this->puntosNegros 	= $this->driver->real_escape_string($puntosNegros);
		$this->verrugas 		= $this->driver->real_escape_string($verrugas);
		$this->arrugas 			= $this->driver->real_escape_string($arrugas);
		$this->brilloFacial 	= $this->driver->real_escape_string($brilloFacial);
		$this->pielAsfixiada 	= $this->driver->real_escape_string($pielAsfixiada);
		$this->despigmentacion 	= $this->driver->real_escape_string($despigmentacion);
		
		$stmt = $this->driver->prepare("INSERT INTO Piel (IDHistorialMedico,Fina,Gruesa,Deshidratada,Flacida,Seca,Mixta,Grasa,Acneica,Manchas,Cicatrices,PoroAbierto,
														Ojeras,Lunares,Pecas,PuntosNegros,Verrugas,Arrugas,BrilloFacial,PielAsfixiada,Despigmentacion) 
										VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('issssssssssssssssssss',$idHistorialMedico, $this->fina,$this->gruesa,$this->deshidratada,$this->flacida,$this->seca,$this->mixta,$this->grasa,
													$this->acneica,$this->manchas,$this->cicatrices,$this->poroAbierto,$this->ojeras,$this->lunares,
													$this->pecas,$this->puntosNegros,$this->verrugas,$this->verrugas,$this->brilloFacial,
													$this->pielAsfixiada,$this->despigmentacion)){
			return false;
		}
		if (!$stmt->execute()) {
			return false;
		}

		if($this->driver->error){
			return false;
		}

		return true;
	}

	/**
	*Actualiza la información de Piel
	*@param int $idHistorialMedico
	*@param string $fina
	*@param string $gruesa
	*@param string $deshidratada
	*@param string $flacida
	*@param string $seca
	*@param string $mixta
	*@param string $grasa
	*@param string $acneica
	*@param string $manchas
	*@param string $cicatrices
	*@param string $poroAbierto
	*@param string $ojeras
	*@param string $lunares
	*@param string $pecas
	*@param string $puntosNegros
	*@param string $verrugas
	*@param string $arrugas
	*@param string $brilloFacial
	*@param string $pielAsfixiada
	*@param string $despigmentacion
	*@return true or false
	**/
	function updatePiel($idHistorialMedico, $fina,$gruesa,$deshidratada,$flacida,$seca,$mixta,$grasa,$acneica,$manchas,
					$cicatrices,$poroAbierto,$ojeras,$lunares,$pecas,$puntosNegros,$verrugas,$arrugas,
					$brilloFacial,$pielAsfixiada,$despigmentacion){
		if($stmt = $this->driver->prepare('SELECT IDHistorialMedico FROM Piel WHERE IDHistorialMedico=?')){
		
			if(!$stmt->bind_param('i',$idHistorialMedico))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDHistorialMedico']!=''){
				$this->fina 			= $this->driver->real_escape_string($fina);
				$this->gruesa 			= $this->driver->real_escape_string($gruesa);
				$this->deshidratada 	= $this->driver->real_escape_string($deshidratada);
				$this->flacida 			= $this->driver->real_escape_string($flacida);
				$this->seca 			= $this->driver->real_escape_string($seca);
				$this->mixta 			= $this->driver->real_escape_string($mixta);
				$this->grasa 			= $this->driver->real_escape_string($grasa);
				$this->acneica 			= $this->driver->real_escape_string($acneica);
				$this->manchas 			= $this->driver->real_escape_string($manchas);
				$this->cicatrices 		= $this->driver->real_escape_string($cicatrices);
				$this->poroAbierto 		= $this->driver->real_escape_string($poroAbierto);
				$this->ojeras 			= $this->driver->real_escape_string($ojeras);
				$this->lunares 			= $this->driver->real_escape_string($lunares);
				$this->pecas 			= $this->driver->real_escape_string($pecas);
				$this->puntosNegros 	= $this->driver->real_escape_string($puntosNegros);
				$this->verrugas 		= $this->driver->real_escape_string($verrugas);
				$this->arrugas 			= $this->driver->real_escape_string($arrugas);
				$this->brilloFacial 	= $this->driver->real_escape_string($brilloFacial);
				$this->pielAsfixiada 	= $this->driver->real_escape_string($pielAsfixiada);
				$this->despigmentacion 	= $this->driver->real_escape_string($despigmentacion);
				
				$stmt = $this->driver->prepare("UPDATE Piel SET Fina=?,Gruesa=?,Deshidratada=?,Flacida=?,Seca=?,Mixta=?,Grasa=?,Acneica=?,Manchas=?,Cicatrices=?,PoroAbierto=?,
														Ojeras=?,Lunares=?,Pecas=?,PuntosNegros=?,Verrugas=?,Arrugas=?,BrilloFacial=?,PielAsfixiada=?,Despigmentacion=? WHERE IDHistorialMedico=?");

				if(!$stmt->bind_param('ssssssssssssssssssssi',$this->fina,$this->gruesa,$this->deshidratada,$this->flacida,$this->seca,$this->mixta,$this->grasa,
													$this->acneica,$this->manchas,$this->cicatrices,$this->poroAbierto,$this->ojeras,$this->lunares,
													$this->pecas,$this->puntosNegros,$this->verrugas,$this->verrugas,$this->brilloFacial,
													$this->pielAsfixiada,$this->despigmentacion,$idHistorialMedico)){
					return false;
				}
				if (!$stmt->execute()) {
					return false;
				}

				if($this->driver->error){
					return false;
				}
				return true;
			}
		}
		else
			return false;
	}

	/**
	* Consulta los Piels registrados en el sistema
	*@param int $offset
	*@param int $idHistorialMedico
	* @return array or false
	**/
	function listsPiel($offset = -1,$idHistorialMedico = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM Piel WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idHistorialMedico>-1){
				$stmt = $this->driver->prepare('SELECT * FROM Piel WHERE IDHistorialMedico=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM Piel WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idHistorialMedico>-1){
				if(!$stmt->bind_param('i',$idHistorialMedico))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				if(empty($rows))
					return VACIO;
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}


	/**
	 *@param int $idHistorialMedico
	 *@param string $fibrosa
	 *@param string $edematosa
	 *@param string $flacida
	 *@param string $dura
	 *@param string $mixta
	 *@param string $dolorosa
	 *Crea un nuevo
	 *@return true
	 */
	function createTipoCelulitis($idHistorialMedico, $fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa){
		$this->fibrosa 	 = $this->driver->real_escape_string($fibrosa);
		$this->edematosa = $this->driver->real_escape_string($edematosa);
		$this->flacida   = $this->driver->real_escape_string($flacida);
		$this->dura		 = $this->driver->real_escape_string($dura);
		$this->mixta 	 = $this->driver->real_escape_string($mixta);
		$this->dolorosa  = $this->driver->real_escape_string($dolorosa);
		
		$stmt = $this->driver->prepare("INSERT INTO TipoCelulitis (IDHistorialMedico,Fibrosa, Edematosa, Flacida, Dura, Mixta, Dolorosa) 
										VALUES(?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('issssss',$idHistorialMedico, $this->fibrosa, $this->edematosa, $this->flacida, $this->dura, $this->mixta, $this->dolorosa)){
			return false;
		}
		if (!$stmt->execute()) {
			return false;
		}
		
		if($this->driver->error){
			return false;
		}

		return true;
	}

	/**
	*Actualiza la información de TipoCelulitis
	*@param int $idHistorialMedico
	*@param string $fibrosa
	*@param string $edematosa
	*@param string $flacida
	*@param string $dura
	*@param string $mixta
	*@param string $dolorosa
	*@return true or false
	**/
	function updateTipoCelulitis($idHistorialMedico, $fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa){
		if($stmt = $this->driver->prepare('SELECT IDHistorialMedico FROM TipoCelulitis WHERE IDHistorialMedico=?')){
		
			if(!$stmt->bind_param('i',$idHistorialMedico))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDHistorialMedico']!=''){
				$this->fibrosa 	 = $this->driver->real_escape_string($fibrosa);
				$this->edematosa = $this->driver->real_escape_string($edematosa);
				$this->flacida   = $this->driver->real_escape_string($flacida);
				$this->dura		 = $this->driver->real_escape_string($dura);
				$this->mixta 	 = $this->driver->real_escape_string($mixta);
				$this->dolorosa  = $this->driver->real_escape_string($dolorosa);
				
				$stmt = $this->driver->prepare("UPDATE TipoCelulitis SET Fibrosa=?, Edematosa=?, Flacida=?, Dura=?, Mixta=?, Dolorosa=? WHERE IDHistorialMedico=?");

				if(!$stmt->bind_param('ssssssi',$this->fibrosa, $this->edematosa, $this->flacida, $this->dura, $this->mixta, $this->dolorosa,$idHistorialMedico)){
					return false;
				}
				if (!$stmt->execute()) {
					return false;
				}

				if($this->driver->error){
					return false;
				}
				return true;
			}
		}
		else
			return false;
	}

	/**
	* Consulta los TipoCelulitis registrados en el sistema
	*@param int $offset
	*@param int $idHistorialMedico
	* @return array or false
	**/
	function listsTipoCelulitis($offset = -1,$idHistorialMedico = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM TipoCelulitis WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idHistorialMedico>-1){
				$stmt = $this->driver->prepare('SELECT * FROM TipoCelulitis WHERE IDHistorialMedico=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM TipoCelulitis WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idHistorialMedico>-1){
				if(!$stmt->bind_param('i',$idHistorialMedico))
					return false;
			}
			if(!$stmt->execute())
				return false;

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);
				if(empty($rows))
					return VACIO;
				return $rows;
			}else
				return VACIO;

		}else
			return false;
			
		return false;
	}
}
?>