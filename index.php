<?php
	define("__MAX_TABLAS__", 10);
	define("__MAX_MULTIPLICADOR__", 12);
	$numeroTablas = (!isset($_GET['nTablas'])||$_GET['nTablas']==NULL)?__MAX_TABLAS__:$_GET['nTablas'];
	$inicioTablas = (!isset($_GET['iTablas'])||$_GET['iTablas']==NULL)?1:$_GET['iTablas'];
	$numeroMult = (!isset($_GET['nMult'])||$_GET['nMult']==NULL)?__MAX_MULTIPLICADOR__:$_GET['nMult'];

	function multiplicacion($numeroTablas, $numeroMult, $inicioTablas){
		for($i = 0; $i < $numeroTablas; $i++){
			for ($j=1; $j <= $numeroMult; $j++) { 
				echo ($i+$inicioTablas),'*',$j,'=',($i+$inicioTablas)*$j,'<br>';
			}
			echo '<br>';
		}
	}

	multiplicacion($numeroTablas, $numeroMult, $inicioTablas);
?>