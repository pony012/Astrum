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
	function create($fina,$gruesa,$deshidratada,$flacida,$seca,$mixta,$grasa,$acneica,$manchas,
					$cicatrices,$poroAbierto,$ojeras,$lunares,$pecas,$puntosNegros,$verrugas,$arrugas,
					$brilloFacial,$pielAsfixiada,$despigmentacion){
		$this->fina = $fina;
		$this->gruesa = $gruesa;
		$this->deshidratada = $deshidratada;
		$this->flacida = $flacida;
		$this->mixta = $mixta;
		$this->grasa = $grasa;
		$this->acneica = $acneica;
		$this->manchas = $manchas;
		$this->cicatrices = $cicatrices;
		$this->poroAbierto = $poroAbierto;
		$this->ojeras = $ojeras;
		$this->lunares = $lunares;
		$this->pecas = $pecas;
		$this->puntosNegros = $puntosNegros;
		$this->verrugas = $verrugas;
		$this->verrugas = $arrugas;
		$this->verrugas = $brilloFacial;
		$this->verrugas = $pielAsfixiada;
		$this->verrugas = $despigmentacion;
		
		return true;
	}
}
?>