<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Existencias de los productos
	*/
class ExistenciaMdl extends BaseMdl{
	private $fechaReferencia;
	private $idProducto;
	private $precioUnitario;
	private $cantidad;
	
	/**
	 *@param string $fechaReferencia
	 *@param integer $idProducto
	 *@param decimal $precioUnitario
	 *@param decimal $cantidad
	 *Crea un registro de existencia de un determinado producto-servicio
	 *@return true
	 */
	function create($fechaReferencia, $idProducto, $precioUnitario, $cantidad){
		$this->fechaReferencia	= $this->driver->real_escape_string($fechaReferencia);
		$this->idProducto		= $idProducto;
		$this->precioUnitario	= $precioUnitario;
		$this->cantidad			= $cantidad;
		
		$stmt = $this->driver->prepare("INSERT INTO Existencia (FechaReferencia,IDProductoServicio,PrecioUnitario,Cantidad) 
										VALUES(?,?,?,?)");
		if(!$stmt->bind_param('sidd',$this->fechaReferencia,$this->idProducto,$this->precioUnitario,$this->cantidad)){
			die('Error al insertar en la base de datos');
		}
		if (!$stmt->execute()) {
			die('Error al insertar en la base de datos');
		}

		if($this->driver->error){
			return false;
		}
		
		return true;
	}
	
	/**
	* Consulta a las Existencias de productos ya registrados
	* @return array or false
	**/
	function lists($constraint = '1 = 1'){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_Existencia WHERE ?')){
		
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
}
?>