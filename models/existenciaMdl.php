<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Existencias de los productos
	*/
class ExistenciaMdl extends BaseMdl{
	private $idProducto;
	private $precioUnitario;
	private $cantidad;
	
	/**
	 *@param integer $idProducto
	 *@param decimal $precioUnitario
	 *@param decimal $cantidad
	 *Crea un registro de existencia de un determinado producto-servicio
	 *@return true
	 */
	function create($idProducto, $precioUnitario, $cantidad){
		$this->idProducto		= $idProducto;
		$this->precioUnitario	= $precioUnitario;
		$this->cantidad			= $cantidad;
		
		$stmt = $this->driver->prepare("INSERT INTO Existencia (IDProductoServicio,PrecioUnitario,Cantidad) 
										VALUES(?,?,?,?)");
		if(!$stmt->bind_param('idd',$this->idProducto,$this->precioUnitario,$this->cantidad)){
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
	* Consulta a las Existencias de productos ya registrados
	*@param int $offset
	*@param int $idExistencia
	* @return array or false
	**/
	
	function lists($offset = -1,$idExistencia = -1, $constrain = '1 = 1'){
		$rows = array();
		if($offset>-1){
			$stmt = $this->driver->prepare('SELECT * FROM V_Existencia WHERE '.$constrain.' LIMIT ?,?');
		}else{
			if($idExistencia>-1){
				$stmt = $this->driver->prepare('SELECT * FROM V_Existencia WHERE IDExistencia=?');
			}else{
				$stmt = $this->driver->prepare('SELECT * FROM V_Existencia WHERE '.$constrain);
			}
		}
		if($stmt){
			if($offset>-1){
				$amountRows = 10;
				$offset*=10;
				if(!$stmt->bind_param('ii',$offset,$amountRows))
					return false;
			}else if($idExistencia>-1){
				if(!$stmt->bind_param('i',$idExistencia))
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