<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../css/estilo_productor.css">
	<?php include("comprobar_acceso.php") ?>	
	<title></title>
</head>
<body>
<div id="contenedor">
	<header id="cabecera_pri">
		<nav id="menu_pri">
		<?php 
		include("menu_principal.php");
		 ?>
		</nav>
	</header>
		<section id="seccion_pri">
			<article>
			<?php 
		include("../conectar.php");	
		$fila=mysqli_query($con,"select date_format(fecha,'%d-%m-%Y %T') as fecha,tema,noticia,id_noticia from tablon order by fecha DESC");		
	 ?>
	 <table id="tablon">
	 	<tr>
	 		<th>Fecha</th>
	 		<th>Tema</th>
	 		<th>Mensaje</th>
	 	</tr>
	 	<form action="" mehod="GET">
	 		Nombre: <input type="text" name="criterio" />
	 		<input type="submit" value="Buscar"/>
	 	</form>
	 	<?php 
	 	if (!isset($_GET['criterio'])) {
	 		while ($celda = mysqli_fetch_array($fila,MYSQLI_ASSOC)) {
			 	echo"<tr>";	
			 			echo"<td>".$celda['fecha']."</td>";
			 			echo"<td>".$celda['tema']."</td>";
			 			echo"<td>".$celda['noticia']."</td>";	
			 	echo"</tr>";
	 	}
	 	}elseif (isset($_GET['criterio'])) {
	 	$criterio=$_GET['criterio'];
	 	$buscar=mysqli_query($con,"select * from socio where nombre like 
		'%$criterio%' order by nombre");
		 		while ($celda = mysqli_fetch_array($buscar,MYSQLI_ASSOC)) {
		 	echo"<tr>";
		 			echo"<td>".$celda['nombre']."</td>";
					echo"<td>".$celda['apellidos']."</td>";
				 	echo"<td>".$celda['email1']."</td>";
				 	echo"<td>".$celda['email2']."</td>";
				 	echo"<td>".$celda['telefono']."</td>";
		  	echo"</tr>";
		 	}
	 	}
	 	
	 	mysqli_close($con);
	 	 ?>
	 </table>
			</article>
		</section>
	<aside id="menu_col">
		
	</aside>
	<footer id="pie"><?php include('../pie.php') ?></footer>
</div>
</body>
</html>