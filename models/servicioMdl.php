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
}
?>