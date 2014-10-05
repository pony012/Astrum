<?php
	echo 'Bienvenido ',$_SESSION['user'],'<br>';
	var_dump($_SESSION);
	echo '<br><a href="?ctrl=logout">Cerrar Sesion</a><br>';
?>