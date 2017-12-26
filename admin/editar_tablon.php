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
		if (isset($_GET['tema']) or isset($_GET['noticia'])) {
			$query="update tablon set tema='$_GET[tema]',noticia='$_GET[noticia]' where id_noticia='$_GET[id_noticia]'";
			mysql_query($query);
		if ($query==0) {
			echo "noticia guardada $query";;
		}else{echo "Error en registro noticia " .mysql_error($con)."<br />";}

		}
		if (isset($_GET['id_noticia'])) {
			$editarnoticia=mysql_query("select tema,noticia from tablon where id_noticia='$_GET[id_noticia]'");
			$editarnoticia=mysql_fetch_assoc($editarnoticia);
		}
		mysql_close();
	 ?>
	 <?php if (isset($_GET['id_noticia'])){ ?>
	 <h3 align="center">Editar Ficha Noticia</h3>
	  <form action="" method="GET">
		 <table align="center">
		 	<tr><td>Tema: </td></tr>
		 	<tr>
		 		<td align="right"><input type="text" name="tema" size="52" value="<?php echo"$editarnoticia[tema]" ?>"/></td>
		 	</tr>
		 	<tr><td>Noticia: </td></tr>
		 	<tr>
		 		<td align="right"><textarea name="noticia" cols="40" rows="7" ><?php echo"$editarnoticia[noticia]" ?></textarea></td>
		 	</tr>
		 	<tr>
		 		<input type="hidden" name="id_noticia" value="<?php echo"$_GET[id_noticia]" ?>">
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

