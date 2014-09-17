<?php

require_once 'models/baseMdl.php';
	/**
	* Modelo de los Tipos de Ajustes de Entrada
	*/
class AjusteEntradaTipoMdl extends BaseMdl{
	private $tipo;
	private $exclusivoSistema;
	private $descripcion;
	
	/**
	 *@param string $tipo
	 *@param string $exclusivoSistema
	 *@param string $descripcion
	 *Crea un nuevo tipo de ajuste de entrada
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