<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo HistorialMedico del cliente
	*/
class HistorialMedicoMdl extends BaseMdl{
	private $idCliente;
	private $fechaRegistro;
	private $idServicio;
	private $observaciones;
	
	/**
	 *@param integer $idCliente
	 *@param date $fechaRegistro
	 *@param integer $idServicio
	 *@param string $observaciones
	 *Crea un nuevo historial medico de un cliente
	 *@return true
	 */
	function create($idCliente, $fechaRegistro, $idServicio, $observaciones, 
					$pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, $abdomenIni, $caderaIni, $musloIni,
					$pesoFin, $bustoFin, $diafragmaFin, $brazoFin, $cinturaFin, $abdomenFin, $caderaFin, $musloFin,
					$motivoConsulta, $tiempoProblema, $relacionaCon, $tratamientoAnterior, $metProbados, $resAnteriores,
					$poca,$regularAg,$mucha,$buena,$regularAl,$mala,
					$peellingQuim,$laser,$dermobrasion,$retinA,$renova,$racutan,
					$adapaleno,$acidoGlicolico,$alfaHidroiacidos,$exfolianteGranuloso,
					$acidoLactico,$vitaminaA,$blanqueadorAclarador, $fumar, $ejercicio, $usarFaja, $suenio, $tomaSol, $bloqueador, $hidroquinona,
					$diabetes, $obesisdad, $depresion, $estres, $sobrepeso, $estrenimiento, $colitis,
				    $retencionLiquidos, $transtornoMes, $cuidadoCorporal, $embarazo,
					$fina,$gruesa,$deshidratada,$flacida,$seca,$mixta,$grasa,$acneica,$manchas,
					$cicatrices,$poroAbierto,$ojeras,$lunares,$pecas,$puntosNegros,$verrugas,$arrugas,
					$brilloFacial,$pielAsfixiada,$despigmentacion, $fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa){
		$this->idCliente 		= $idCliente;
		$this->fechaRegistro	= $fechaRegistro;
		$this->idServicio		= $idServicio;
		$this->observaciones	= $this->driver->real_escape_string($observaciones);

		$this->driver->autocommit(false);
		$this->driver->begin_transaction();
		
		$stmt = $this->driver->prepare("INSERT INTO HistorialMedico (IDCliente, FechaRegistro, IDServicio, Observaciones) 
										VALUES(?,?,?,?)");
		if(!$stmt->bind_param('isis',$this->idCliente,$this->fechaRegistro,$this->idServicio,$this->observaciones)){
			$this->driver->rollback();
			die('Error al insertar en la base de datos');
		}
		if (!$stmt->execute()) {
			$this->driver->rollback();
			die('Error al insertar en la base de datos');
		}

		if($this->driver->error){
			$this->driver->rollback();
			return false;
		}

		$lastId = $this->driver->insert_id;

		if(!$this->exploracionInicialMdl->create($lastId, $pesoIni, $bustoIni, $diafragmaIni, $brazoIni, $cinturaIni, $abdomenIni, $caderaIni, $musloIni))
			$this->driver->rollback();	
		//verificar en que momento hay que llamar a esta funcion	
		/*if(!$this->exploracionFinalMdl->create($lastId, $pesoFin, $bustoFin, $diafragmaFin, $brazoFin, $cinturaFin, $abdomenFin, $caderaFin, $musloFin))
			$this->driver->rollback();*/
		if(!$this->fichaClinicaMdl->create($lastId, $motivoConsulta, $tiempoProblema, $relacionaCon, $tratamientoAnterior, $metProbados, $resAnteriores))
			$this->driver->rollback();
		if(!$this->aguaAlDiaMdl->create($lastId, $poca,$regularAg,$mucha))
			$this->driver->rollback();
		if(!$this->alimentacionMdl->create($lastId, $buena,$regularAl,$mala))
			$this->driver->rollback();
		if(!$this->exfoliacionMdl->create($lastId, $peellingQuim,$laser,$dermobrasion,$retinA,$renova,$racutan,
									$adapaleno,$acidoGlicolico,$alfaHidroiacidos,$exfolianteGranuloso,
									$acidoLactico,$vitaminaA,$blanqueadorAclarador))
			$this->driver->rollback();
		if(!$this->habitoMdl->create($lastId, $fumar, $ejercicio, $usarFaja, $suenio, $tomaSol, $bloqueador, $hidroquinona))
			$this->driver->rollback();
		if(!$this->padecimientoMdl->create($lastId, $diabetes, $obesisdad, $depresion, $estres, $sobrepeso, $estrenimiento, $colitis,
									   $retencionLiquidos, $transtornoMes, $cuidadoCorporal, $embarazo))
			$this->driver->rollback();
		if(!$this->pielMdl->create($lastId, $fina,$gruesa,$deshidratada,$flacida,$seca,$mixta,$grasa,$acneica,$manchas,
								$cicatrices,$poroAbierto,$ojeras,$lunares,$pecas,$puntosNegros,$verrugas,$arrugas,
								$brilloFacial,$pielAsfixiada,$despigmentacion))
			$this->driver->rollback();
		if(!$this->tipoCelulitisMdl->create($lastId, $fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa))
			$this->driver->rollback();

		$this->driver->commit();
		$this->driver->autocommit(true);
		return true;
	}
	
	/**
	* Consulta todos los Historiales Medicos registrados
	* @return array or false
	**/
	function lists($constraint = '1 = 1'){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_HistorialMedico WHERE ?')){
		
			if(!$stmt->bind_param('s',$constraint))
				die('Error Al Consultar');

			if(!$stmt->execute())
				die('Error Al Consultar');

			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0){

				while($result = $mySqliResult->fetch_assoc())
					array_push($rows, $result);

				return $rows;
			}else
				die('No hay Resultados!!!');

		}else
			die('Error Al Consultar');
			
		return false;
	}

	function __construct(){
		require_once 'models/exploracionInicialMdl.php';
		require_once 'models/exploracionFinalMdl.php';
		require_once 'models/fichaClinicaMdl.php';
		require_once 'models/aguaAlDiaMdl.php';
		require_once 'models/alimentacionMdl.php';
		require_once 'models/exfoliacionMdl.php';
		require_once 'models/habitoMdl.php';
		require_once 'models/padecimientoMdl.php';
		require_once 'models/pielMdl.php';
		require_once 'models/tipoCelulitisMdl.php';

		$this->exploracionInicialMdl   = new ExploracionInicialMdl();
		$this->exploracionFinalMdl   = new ExploracionFinalMdl();
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