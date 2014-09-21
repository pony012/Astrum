<?php
require_once 'models/baseMdl.php';
	/**
	* Clase para el modelo de FichaClinica del cliente
	*/
class FichaClinicaMdl extends BaseMdl{
	private $motivoConsulta;
	private $tiempoProblema;
	private $relacionaCon;
	private $tratamientoAnterior;
	private $metProbados;
	private $resAnteriores;
	
	/**
	 *@param string $motivoConsulta
	 *@param string $tiempoProblema
	 *@param string $relacionaCon
	 *@param string $tratamientoAnterior
	 *@param string $metProbados
	 *@param string $resAnteriores
	 *Crea un nuevo
	 *@return true
	 */
	function create($motivoConsulta, $tiempoProblema, $relacionaCon, $tratamientoAnterior, $metProbados, $resAnteriores){
		$this->motivoConsulta = $motivoConsulta;
		$this->tiempoProblema = $tiempoProblema;
		$this->relacionaCon = $relacionaCon;
		$this->tratamientoAnterior = $tratamientoAnterior;
		$this->metProbados = $metProbados;
		$this->resAnteriores = $resAnteriores;
		
		return true;
	}
}
?>