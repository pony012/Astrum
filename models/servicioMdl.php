<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de Servicio
	*/
class ServicioMdl extends BaseMdl{
	private $idServicioTipo;
	private $servicio;
	private $precioUnitario;
	private $foto;
	private $descripcion;
	
	/**
	 *@param integer $idServicioTipo
	 *@param string $servicio
	 *@param decimal $precioUnitario
	 *@param string $foto
	 *@param string $descripcion
	 *Crea un nuevo servicio
	 *@return true
	 */
	function create($idServicioTipo, $servicio, $precioUnitario, $foto = NULL, $descripcion = NULL){
		$this->idServicioTipo = $idServicioTipo;
		$this->servicio	= $servicio;
		$this->precioUnitario	= $precioUnitario;
		$this->foto	= $foto;
		$this->descripcion	= $descripcion;
		
		return true;
	}
	
	/**
	* Consulta todos los servicios registrados
	* @return array or false
	**/
	function lists($constraint = '1 = 1'){
		$rows = array();

		if($stmt = $this->driver->prepare('SELECT * FROM V_Servicio WHERE ?')){
		
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