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
		if (isset($_GET['tema']) and isset($_GET['noticia'])) {
			$query="insert into tablon (fecha,tema,noticia,admin_id_admin) values
			(Now(),'$_GET[tema]','$_GET[noticia]','1')";
			mysql_query($query);
		if ($query==0) {
			echo "Noticia guardada $query";;
		}else{echo "Error en registro noticia " .mysql_error($con)."<br />";}

		}
		mysql_close();
	 ?>
	 <h3 align="center">Ficha Noticia</h3>
	 <form action="" method="GET">
		 <table align="center" border="0">
		 	<tr><td>Tema: </td></tr>
		 	<tr>
		 		<td align="right"><input type="text" name="tema" size="52"/></td><br />
		 	</tr>
		 	<tr><td>Noticia: </td></tr>
		 	<tr>
		 		<td align="right"> <textarea name="noticia" cols="40" rows="7"></textarea></td>
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

