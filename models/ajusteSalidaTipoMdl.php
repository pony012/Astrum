<?php

require_once 'models/baseMdl.php';
	/**
	* Modelo de los Tipos de Ajuste de Salida
	*/
class AjusteSalidaTipoMdl extends BaseMdl{
	private $tipo;
	private $exclusivoSistema;
	private $descripcion;
	
	/**
	 *@param string $tipo
	 *@param string $exclusivoSistema
	 *@param string $descripcion
	 *Crea un nuevo tipo de movimiento de almacen
	 *@return true
	 */
	function create($tipo, $exclusivoSistema, $descripcion){
		$this->tipo = $tipo;
		$this->exclusivoSistema = $exclusivoSistema;
		$this->descripcion	= $descripcion;
		
		return true;
	}
}
?>