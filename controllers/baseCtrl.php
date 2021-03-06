<?php

	/**
	* Controlador Base
	* Clase base para los controladores que serán creados en la aplicación
	* @version 0.1
	*/
	class BaseCtrl
	{
		/** Donde se guardará el modelo */
		protected $model;
		protected $twig;
		protected $loader;
		protected $session;
		protected $api;
		
		/**
		*	Inicia una sesion y retorna true si se inició, false si ya existía una activa
		*	En caso de que el usuario esté en la base de datos, se guardará en la sesión el nombre del usuario
		*	y su tipo.
		*	Los tipos de usuario son:
		*	{1=>Admin, 2=>Terapeuta, 3=>Empleado}
		*	@param string $user
		*	@param string $pass
		*	@return bool
		*/
		public static function startSession($user, $pass){
			if (BaseCtrl::isLoged()){
				echo '<meta http-equiv="refresh" content="0; url=../">';
				return true;
			}
			if (empty($user) || empty($pass)){
				echo '<meta http-equiv="refresh" content="0; url=../">';
				return false;
			}
			require_once 'models/baseMdl.php';

			$userMdl = new BaseMdl();

			$_user	= $userMdl->driver->real_escape_string($user);
			$_pass	= $userMdl->driver->real_escape_string($pass);

			$stmt = $userMdl->driver->prepare("SELECT * FROM Empleado WHERE Usuario = ?");
			if(!$stmt->bind_param('s',$_user)){
				//No se pudo bindear el nombre, error en la base de datos
			}else if (!$stmt->execute()) {
				//No se pudo ejecutar, error en la base de datos
			}else{
				$result = $stmt->get_result();
				if($result->field_count > 0){
					$result = $result->fetch_array();
					if(strcmp($result['Contrasena'],$pass)==0){
						//md5(md5("1234")."astrum1234".md5("astr"))
						//b956f5207a5f0bfa514292171f1c285f
						$_SESSION['user'] = $user;
						//$_SESSION['pass'] = $pass;
						$_SESSION['type'] = $result['IDCargo'];
						$_SESSION['IDEmpleado'] = $result['IDEmpleado'];
						echo '<meta http-equiv="refresh" content="0; url=../">';
						return true;
					}else{
						//Cargar vista de fallo de contraseña
						echo '<meta http-equiv="refresh" content="0; url=../">';
					}
				}else{
					//No se encontró usuario con ese nombre :(
					echo '<meta http-equiv="refresh" content="0; url=../">';
				}
			}
			echo '<meta http-equiv="refresh" content="0; url=../">';
			return false;
		}

		/**
		*	Destruye una sesion
		*/
		public static function killSession(){
			session_start();

			session_unset();
			session_destroy();
			
			setcookie(session_name(), '', time()-3600);

			die('<meta http-equiv="refresh" content="0; url=./">');
		}

		/**
		*	Verifica si hay una sesion activa
		*/
		public static function isLoged(){
			return isset($_SESSION['user']);
		}

		/**
		*	Retorna el id del cargo que está logueado
		*/
		public static function getType(){
			return $_SESSION['type'];
		}
		/**
		*	Retorna true si el usuario tiene permisos de administrador
		*/
		public static function isAdmin(){
			if(BaseCtrl::isLoged()){
				return BaseCtrl::getType()==1;
			}
			return false;
		}
		/**
		*	Retorna true si el usuario tiene permisos de terapeuta
		*/
		public static function isTerapeuta(){
			if(BaseCtrl::isLoged()){
				return (BaseCtrl::isAdmin() || BaseCtrl::getType()==2);
			}
			return false;
		}
		/**
		*	Retorna true si el usuario tiene permisos de empleado
		*/
		public static function isEmpleado(){
			if(BaseCtrl::isLoged()){
				return (BaseCtrl::isTerapeuta() || BaseCtrl::getType()==3);
			}
			return false;
		}

		/** 
		 *	Valida que una cadena sea un número, retorna la cadena si lo es, en caso de no serlo returna una cadena vacía
		 *	@param string $data
		 *	@return string $data
		 */
		public static function validateNumber($data){
			if(is_numeric($data))
				return $data;
			return "";
		}

		/**
		 *	Valida que una cadena esté limpia, si es así la retorna, en caso de no estarlo, retornará una cadena vacía
		 *	@param string $data
		 *	@return string $data
		 */
		public static function validateText($data){
			//verificamos si es un arreglo
			if(is_string($data)){
				//saco el tamaño en caracteres del valor
				$tamaño=strlen($data);
				//verificamos que exista, que no este vacio, que si tamaño sea menor o igual a 200
				//que no contenga caracteres de escape, quitamos barras y escapamos comillas y quitamos tags
				if(!(
					isset($data) && 
					$data!="" && 
					$tamaño<=200 && 
					$tamaño==strlen($data=trim($data)) && 
					$tamaño==strlen($data=stripslashes($data)) && 
					$tamaño==strlen($data=addslashes($data)) &&
					$tamaño==strlen($data=strip_tags($data))
					)
				){
					//regresamos cadena vacía en caso de que la cadena no cumpla la validacion
					return "";
				}
			}
			//todo resultó perfecto
			return $data;
		}
		
		/**
		*	Valida que la cadena de texto sea un correo válido, retorna la cadena sin espacios al inicio o al final si lo es, en caso de no serlo returna una cadena vacía
		*	@param string $data
		*	@return string $data
		*/
		public static function validateEmail($data){
			$data = trim($data);
			$regex = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
			if(preg_match($regex, $data))
				return $data;
			return "";
		}

		/**
		*	Valida que la cadena de texto sea un teléfono, retorna la cadena sin espacios al inicio o al final si lo es, en caso de no serlo returna una cadena vacía
		*	@param string $data
		*	@return string $data	
		*/
		public static function validatePhone($data){
			$data = trim($data);
			$regex = "/^(\+\d{1,4}[- ])?(\d+([ -])*)+$/";
			if(preg_match($regex, $data))
				return $data;
			return "";
		}

		/**
		*	Valida que la cadena de texto sea un nombre válido, retorna la cadena sin espacios al inicio o al final si lo es, en caso de no serlo returna una cadena vacía
		*	@param string $data
		*	@return string $data	
		*/
		public static function validateName($data){
			$data = trim($data);
			if(strcmp(substr($data,-1)," ")!=0)
				$data.=' ';
			$regex = "/^([a-zA-ZáéíóúÁÉÍÓÚ]+ ?){1,5}$/";
			if(preg_match($regex, $data))
				return $data;
			return "";
		}
		/**
		*	Valida que la cadena de texto sea una fecha válida, retorna la cadena sin espacios al inicio o al final si lo es, en caso de no serlo returna una cadena vacía
		*	@param string $data
		*	@return string $data	
		*/
		public static function validateDate($data){
			$data = trim($data);
			$d = DateTime::createFromFormat('Y-m-d', $data);
    		return ($d && $d->format('Y-m-d') == $data)?$data:"";
		}

		public static function validateDateHour($data){
			$data = trim($data);
			$d = DateTime::createFromFormat('Y-m-d H:i:s', $data);
    		return ($d && $d->format('Y-m-d H:i:s') == $data)?$data:"";
		}
		
		/**
		* TODO
		* DOCS
		*/
		public static function validateNumericArray($data){
			$result = array();
			
			foreach($data as $key=>$value){
				if( strlen(BaseCtrl::validateNumber($value)) == 0 ){
					array_push($result, $key);
				}
			}
			return $result;
		}


		/**
		*	Envia un correo al email especificado
		*	@param string $correo
		* 	@param string $asunto
		*	@param string $body
		* 	@param array $remplazos
		*	@return bool 
		*/
		public static function enviarCorreo($correo,$asunto,$body,$remplazos){
			/*Lo primero es añadir al script la clase phpmailer desde la ubicación en que esté*/
			require_once 'PHPMailer/PHPMailerAutoload.php';

			//Crear una instancia de PHPMailer
			$mail = new PHPMailer;
			//Definir que vamos a usar SMTP
			$mail->isSMTP();
			//Esto es para activar el modo depuración. En entorno de pruebas lo mejor es 2, en producción siempre 0
			// 0 = off (producción)
			// 1 = client messages
			// 2 = client and server messages
			$mail->SMTPDebug = 0;
			//Ahora definimos gmail como servidor que aloja nuestro SMTP
			$mail->Host = "smtp.gmail.com";
			//El puerto será el 587 ya que usamos encriptación TLS
			$mail->Port = 587;
			//Definmos la seguridad como TLS
			$mail->SMTPSecure = 'tls';
			//Tenemos que usar gmail autenticados, así que esto a TRUE
			$mail->SMTPAuth = true;
			//Definimos la cuenta que vamos a usar. Dirección completa de la misma
			$mail->Username = "spadamaris.test@gmail.com";
			//Introducimos nuestra contraseña de gmail
			$mail->Password = "spadamaris.test11";
			//Definimos el remitente (dirección y, opcionalmente, nombre)
			$mail->setFrom('spadamaris.test@gmail.com', 'SpaDamaris');	
			$mail->addAddress($correo);

			$mail->Subject = 'SpaDamaris: '.$asunto;
			$lineas = file(getcwd().$body);
			$mensaje = '';
			foreach ($lineas as $value) {
				$mensaje.=strtr($value,$remplazos);
			}
			$mail->msgHTML($mensaje);
			
			
			if (!$mail->send()) {
			    return false;
			} else {
			    return true;
			}
		}

		public static function loadIndex(){
			require_once 'config.cf';
			//require_once 'views/header.php';
			$session = array(
				'isLoged'=>BaseCtrl::isLoged(),
				'user'=>isset($_SESSION['user'])?$_SESSION['user']:NULL,
				'IDEmpleado' => isset($_SESSION['IDEmpleado'])?$_SESSION['IDEmpleado']:NULL,
				'isAdmin' => BaseCtrl::isAdmin(),
				'isTerapeuta' => BaseCtrl::isTerapeuta(),
				'isEmpleado' => BaseCtrl::isEmpleado(),
				'cargo'=>BaseCtrl::isAdmin()?'Admin':(BaseCtrl::isTerapeuta()?'Terapeuta':'Empleado'),
				'controller'=>'index',
				'document_root' => __DOCUMENT_ROOT__
			);

			require_once 'Twig/Autoloader.php';
			Twig_Autoloader::register();

			$loader = new Twig_Loader_Filesystem('views/');
			$twig = new Twig_Environment($loader, array(
			    //'cache' => '/cache',
			));

			$template = $twig->loadTemplate('index.html');
			echo $template->render(array('session'=>$session));
		}

		public static function loadLogin(){
			require_once 'config.cf';
			if(BaseCtrl::isLoged())
				die('<meta http-equiv="refresh" content="0; url=./">');
			$session = array(
				'isLoged'=>BaseCtrl::isLoged(),
				'user'=>isset($_SESSION['user'])?$_SESSION['user']:NULL,
				'IDEmpleado' => isset($_SESSION['IDEmpleado'])?$_SESSION['IDEmpleado']:NULL,
				'isAdmin' => BaseCtrl::isAdmin(),
				'isTerapeuta' => BaseCtrl::isTerapeuta(),
				'isEmpleado' => BaseCtrl::isEmpleado(),
				'cargo'=>BaseCtrl::isAdmin()?'Admin':(BaseCtrl::isTerapeuta()?'Terapeuta':'Empleado'),
				'controller'=>'loginB',
				'document_root' => __DOCUMENT_ROOT__
			);

			require_once 'Twig/Autoloader.php';
			Twig_Autoloader::register();

			$loader = new Twig_Loader_Filesystem('views/');
			$twig = new Twig_Environment($loader, array(
			    //'cache' => '/cache',
			));

			$template = $twig->loadTemplate('loginB.html');
			echo $template->render(array('session'=>$session));
		}

		private function utf8_encode_deep(&$input) {
		    if (is_string($input)) {
		        $input = utf8_encode($input);
		    } else if (is_array($input)) {
		        foreach ($input as &$value) {
		            $this->utf8_encode_deep($value);
		        }

		        unset($value);
		    } else if (is_object($input)) {
		        $vars = array_keys(get_object_vars($input));

		        foreach ($vars as $var) {
		            $this->utf8_encode_deep($input->$var);
		        }
		    }
		}

		public function json_encode($value){
			$this->utf8_encode_deep($value);
			return json_encode($value);
		}

		/**
		* Construye un controlador Base
		* Manda a llamar el header y
		* el inicio de sesión o la bienvenida en caso de que esté logueado
		*/
		function __construct(){
			require_once 'config.cf';
			require_once 'systemStatus.php';
			require_once 'PHPExcel_1.8.0_doc/Classes/PHPExcel.php';
			//require_once 'views/header.php';
			$this->session = array(
				'isLoged'=>BaseCtrl::isLoged(),
				'user'=>isset($_SESSION['user'])?$_SESSION['user']:NULL,
				'IDEmpleado' => isset($_SESSION['IDEmpleado'])?$_SESSION['IDEmpleado']:NULL,
				'isAdmin' => BaseCtrl::isAdmin(),
				'isTerapeuta' => BaseCtrl::isTerapeuta(),
				'isEmpleado' => BaseCtrl::isEmpleado(),
				'cargo'=>BaseCtrl::isAdmin()?'Admin':(BaseCtrl::isTerapeuta()?'Terapeuta':'Empleado'),
				'controller'=>isset($_GET['ctrl'])?$_GET['ctrl']:'index',
				'action'=>'',
				'document_root' => __DOCUMENT_ROOT__
			);

			require_once 'Twig/Autoloader.php';
			Twig_Autoloader::register();

			$this->loader = new Twig_Loader_Filesystem('views/');
			$this->twig = new Twig_Environment($this->loader, array(
			    //'cache' => '/cache',
			));
			$this->api = isset($_GET['api'])?$_GET['api']:0;

			if($this->api){
				header('Content-Type: application/json; charset=utf-8');
			}
		}

		public static function noPermisos(){
			$template = $this->twig->loadTemplate('noPermisos.html');
			$template->render(array('session'=>$this->session));
		}
	}
?>
