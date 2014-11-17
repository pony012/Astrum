<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Tipos de Celulitis, que son datos del cliente
	*/
class TipoCelulitisMdl extends BaseMdl{
	private $fibrosa;
	private $edematosa;
	private $flacida;
	private $dura;
	private $mixta;
	private $dolorosa;
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
	function create($idHistorialMedico, $fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa){
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
	*@param int $idTipoCelulitis
	*@param int $idHistorialMedico
	*@param string $fibrosa
	*@param string $edematosa
	*@param string $flacida
	*@param string $dura
	*@param string $mixta
	*@param string $dolorosa
	*@return true or false
	**/
	function update($idTipoCelulitis,$idHistorialMedico, $fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa){
		if($stmt = $this->driver->prepare('SELECT IDTipoCelulitis FROM TipoCelulitis WHERE IDTipoCelulitis=?')){
		
			if(!$stmt->bind_param('i',$idTipoCelulitis))
				return false;
			
			if(!$stmt->execute())
				return false;
				
			$mySqliResult = $stmt->get_result();

			if($mySqliResult->field_count > 0 && $mySqliResult->fetch_assoc()['IDTipoCelulitis']!=''){
				$this->fibrosa 	 = $this->driver->real_escape_string($fibrosa);
				$this->edematosa = $this->driver->real_escape_string($edematosa);
				$this->flacida   = $this->driver->real_escape_string($flacida);
				$this->dura		 = $this->driver->real_escape_string($dura);
				$this->mixta 	 = $this->driver->real_escape_string($mixta);
				$this->dolorosa  = $this->driver->real_escape_string($dolorosa);
				
				$stmt = $this->driver->prepare("UPDATE TipoCelulitis SET IDHistorialMedico=?,Fibrosa=?, Edematosa=?, Flacida=?, Dura=?, Mixta=?, Dolorosa=? WHERE IDTipoCelulitis=?");

				if(!$stmt->bind_param('issssssi',$idHistorialMedico, $this->fibrosa, $this->edematosa, $this->flacida, $this->dura, $this->mixta, $this->dolorosa,$idTipoCelulitis)){
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
	*@param int $idTipoCelulitis
	* @return array or false
	**/
	function lists($offset = -1,$idTipoCelulitis = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM TipoCelulitis WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idTipoCelulitis>-1){
				$stmt = $this->driver->prepare('SELECT * FROM TipoCelulitis WHERE IDTipoCelulitis=?');
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
			}else if($idTipoCelulitis>-1){
				if(!$stmt->bind_param('i',$idTipoCelulitis))
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