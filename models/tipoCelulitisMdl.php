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
	 *@param string $fibrosa
	 *@param string $edematosa
	 *@param string $flacida
	 *@param string $dura
	 *@param string $mixta
	 *@param string $dolorosa
	 *Crea un nuevo
	 *@return true
	 */
	function create($fibrosa, $edematosa, $flacida, $dura, $mixta, $dolorosa){
		$this->fibrosa 	 = $fibrosa;
		$this->edematosa = $edematosa;
		$this->flacida   = $flacida;
		$this->dura		 = $dura;
		$this->mixta 	 = $mixta;
		$this->dolorosa  = $dolorosa;
		
		return true;
	}
}
?>