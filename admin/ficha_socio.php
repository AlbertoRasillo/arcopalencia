<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../css/estilo_admin2.css">
	<title></title>
	<?php include("comprobar_acceso.php") ?>
</head>
<body>
<div id="contenedor">
	<header id="cabecera_pri">
	<nav id="menu_pri">
		<?php 
		include("menu_admin.php"); 
		?>
	</nav>
	</header>
		<section id="seccion_pri">
			<article>
		<?php
		include("../conectar.php");
		if (isset($_GET['nombre']) or isset($_GET['apellidos'])) {
			$query="insert into socio (nombre,apellidos,email1,telefono,password) values
			('$_GET[nombre]','$_GET[apellidos]','$_GET[email1]','$_GET[telefono]','$_GET[pass]')";
			mysqli_query($con,$query);
		if ($query==0) {
			echo "usuario guardado $query";;
		}else{echo "Error en registro socio " .mysqli_error($con)."<br />";}

		}
		mysqli_close($con);
	 ?>
	 <h3 align="center">Ficha Socio</h3>
	 <form action="" method="GET">
		 <table align="center">
		 	<tr>
		 		<td align="right">Nombre: <input type="text" name="nombre" /></td>
		 		<td align="right">Apellidos: <input type="text" name="apellidos" /></td>
		 	</tr>
		 	<tr>
		 		<td align="right">E-mail: <input type="text" name="email1" /></td>
		 		<td align="right">Teléfono: <input type="text" name="telefono" /></td>
		 	</tr>
		 	<tr>
		 		<td align="right">Password: <input type="password" name="pass" /></td>
		 	</tr>
		 	<tr>
		 		<td align="center"><input type="submit" value="Enviar" /></td>
		 	</tr>
		 </table>
	 </form>
			</article>
		</section>
	<aside id="menu_col">
		
	</aside>
	<footer id="pie"><?php include("../pie.php"); ?></footer>
</div>
</body>
</html>

