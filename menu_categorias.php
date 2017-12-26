<?php 

	include("conectar.php");
	$categoria=mysql_query("select distinct(categoria) from producto");
	echo "<ul>";
	echo "<li>CATEGORIAS</li>";
	echo "<li><a href='buscar_producto.php'>Todos los Productos</a></li>";
	while ($menu = mysql_fetch_array($categoria)) {
		echo "<li><a href='buscar_producto.php?categoria=$menu[categoria]'>$menu[categoria]</a></li>";
	}
	echo " </ul>";

	mysql_close();
 ?>
 


 	