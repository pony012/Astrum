<?php
	echo 'Es necesario iniciar sesion en el sistema <br>';
	echo '<form action="?ctrl=login" method="POST">';
	echo '<label for="u">Nombre</label>';
	echo '<input type="text" placeholder="Ingresa un nombre" id="u" name="u">';
	echo '<label for="p">Pass</label>';
	echo '<input type="password" placeholder="Ingresa un password" id="p" name="p">';
	echo '<input type="submit" value="Click para iniciar sesion">';
	echo '</form><br>';
?>