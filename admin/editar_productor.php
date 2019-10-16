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
			$query="update productor set nombre='$_GET[nombre]',apellidos='$_GET[apellidos]',email='$_GET[email]',telefono='$_GET[telefono]',direccion='$_GET[direccion]',password='$_GET[pass]' where id_productor='$_GET[id_productor]'";
			mysqli_query($con,$query);
		if ($query==0) {
			echo "usuario guardado $query";;
		}else{echo "Error en registro socio " .mysqli_error($con)."<br />";}

		}
		if (isset($_GET['id_productor'])) {
			$editarproductor=mysqli_query($con,"select nombre,apellidos,email,telefono,direccion,password from productor where id_productor='$_GET[id_productor]'"); 
			$editarproductor = mysqli_fetch_array($editarproductor,MYSQLI_ASSOC);
		}
		mysqli_close($con);
	 ?>
	 <?php if (isset($_GET['id_productor'])){ ?>
	  <form action="" method="GET">
		 <table align="center">
		 	<tr>
		 		<td align="right">Nombre: <input type="text" name="nombre" value="<?php echo"$editarproductor[nombre]" ?>"/></td>
		 		<td align="right">Apellidos: <input type="text" name="apellidos" value="<?php echo"$editarproductor[apellidos]" ?>"/></td>
		 	</tr>
		 	<tr>
		 		<td align="right">E-mail: <input type="text" name="email" value="<?php echo"$editarproductor[email]" ?>"/></td>
		 		<td align="right">Direccion: <input type="text" name="direccion" value="<?php echo"$editarproductor[direccion]" ?>"/></td>
		 	</tr>
		 	<tr>
		 		<td align="right">Teléfono: <input type="text" name="telefono" value="<?php echo"$editarproductor[telefono]" ?>"/></td>
		 		<td align="right">Password: <input type="password" name="pass" value="<?php echo"$editarproductor[password]" ?>"/></td>
		 	</tr>
		 	<tr>
		 		<input type="hidden" name="id_productor" value="<?php echo"$_GET[id_productor]" ?>">
		 		<td align="center"><input type="submit" value="Enviar" /></td>
		 	</tr>
		 </table>
	 </form>
	 <?php } ?>
			</article>
		</section>
	<aside id="menu_col">
		
	</aside>
	<footer id="pie"><?php include("../pie.php"); ?></footer>
</div>
</body>
</html>

