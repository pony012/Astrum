<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo Piel, que son datos del cliente
	*/
class PielMdl extends BaseMdl{
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
	function create($idHistorialMedico, $fina,$gruesa,$deshidratada,$flacida,$seca,$mixta,$grasa,$acneica,$manchas,
					$cicatrices,$poroAbierto,$ojeras,$lunares,$pecas,$puntosNegros,$verrugas,$arrugas,
					$brilloFacial,$pielAsfixiada,$despigmentacion){
		$this->fina 			= $this->driver->real_escape_string($fina);
		$this->gruesa 			= $this->driver->real_escape_string($gruesa);
		$this->deshidratada 	= $this->driver->real_escape_string($deshidratada);
		$this->flacida 			= $this->driver->real_escape_string($flacida);
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
		
		$stmt = $this->driver->prepare("INSERT INTO Piel (IDHistorialMedico,Fina,Gruesa,Deshidratada,Flacida,Mixta,Grasa,Acneica,Manchas,Cicatrices,PoroAbierto,
														Ojeras,Lunares,Pecas,PuntosNegros,Verrugas,Arrugas,BrilloFacial,PielAsfixiada,Despigmentacion) 
										VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		if(!$stmt->bind_param('isssssssssssssssssss',$idHistorialMedico, $this->fina,$this->gruesa,$this->deshidratada,$this->flacida,$this->mixta,$this->grasa,
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
	*@param int $idPiel
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
	function update($idPiel,$idHistorialMedico, $fina,$gruesa,$deshidratada,$flacida,$seca,$mixta,$grasa,$acneica,$manchas,
					$cicatrices,$poroAbierto,$ojeras,$lunares,$pecas,$puntosNegros,$verrugas,$arrugas,
					$brilloFacial,$pielAsfixiada,$despigmentacion){
		if($stmt = $this->driver->prepare('SELECT IDPiel FROM Piel WHERE IDPiel=?')){
		
			if(!$stmt->bind_param('i',$idPiel))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDPiel']!=''){
				$this->fina 			= $this->driver->real_escape_string($fina);
				$this->gruesa 			= $this->driver->real_escape_string($gruesa);
				$this->deshidratada 	= $this->driver->real_escape_string($deshidratada);
				$this->flacida 			= $this->driver->real_escape_string($flacida);
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
				
				$stmt = $this->driver->prepare("UPDATE Piel SET IDHistorialMedico=?,Fina=?,Gruesa=?,Deshidratada=?,Flacida=?,Mixta=?,Grasa=?,Acneica=?,Manchas=?,Cicatrices=?,PoroAbierto=?,
														Ojeras=?,Lunares=?,Pecas=?,PuntosNegros=?,Verrugas=?,Arrugas=?,BrilloFacial=?,PielAsfixiada=?,Despigmentacion=? WHERE IDPiel=?");

				if(!$stmt->bind_param('isssssssssssssssssssi',$idHistorialMedico, $this->fina,$this->gruesa,$this->deshidratada,$this->flacida,$this->mixta,$this->grasa,
													$this->acneica,$this->manchas,$this->cicatrices,$this->poroAbierto,$this->ojeras,$this->lunares,
													$this->pecas,$this->puntosNegros,$this->verrugas,$this->verrugas,$this->brilloFacial,
													$this->pielAsfixiada,$this->despigmentacion,$idPiel)){
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
	*@param int $idPiel
	* @return array or false
	**/
	function lists($offset = -1,$idPiel = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM Piel WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idPiel>-1){
				$stmt = $this->driver->prepare('SELECT * FROM Piel WHERE IDPiel=?');
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
			}else if($idPiel>-1){
				if(!$stmt->bind_param('i',$idPiel))
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
