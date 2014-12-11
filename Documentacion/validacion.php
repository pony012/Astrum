<?php 
	class Validacion{
		//funcion para un contador de visitas con archivos
		public static function conVisitas(){
			//declaramos la ruta del archivo
			$archivo="visitas.txt";
			//declaramos un contador inicializado en 0
			$contador=0;
			//verificamos si el archivo existe
			if(is_file($archivo)){
				//abrimos el archivo en modo lectura
				$abre=fopen($archivo,"r");
				//obtenemos el contador actual
				$contador=fgets($abre,"4093");
			}
			//incrementamos el contador
			$contador++;
			//abrimos el archivo en modo escritura
			$abre=fopen($archivo,"w");
			//escribimos el contador en el archivo
			fwrite($abre,$contador);
			//cerramos el archivo
			fclose($abre);
		}
		
		//funcion para validar campos
		public static function validarCadena($cadena){
			//verificamos si es un arreglo
			if(is_string($cadena)){
				//saco el tamaño en caracteres del valor
				$tamaño=strlen($cadena);
				//verificamos que exista, que no este vacio, que si tamaño sea menor o igual a 200
				//que no contenga caracteres de escape, quitamos barras y escapamos comillas y quitamos tags
				if(!(isset($cadena) && $cadena!="" && $tamaño<=200 && $tamaño==strlen($cadena=trim($cadena))
				&& $tamaño==strlen($cadena=stripslashes($cadena)) && $tamaño==strlen($cadena=addslashes($cadena)) &&
				$tamaño==strlen($cadena=strip_tags($cadena)))){
					//regresamos false en caso de que la cadena cumpla la validacion
					return false;
				}
			}
			//todo resulto perfecto
			return true;
		}
		
		//funcion para validar correos
		public static function validaCorreo($correo){
			//lo evaluamos con un filtro para saber si esta bien estructurado
			if(isset($correo) && filter_var($correo,FILTER_VALIDATE_EMAIL)){
				return true;
			}else{
				return false;
			}
		}
	}
?>