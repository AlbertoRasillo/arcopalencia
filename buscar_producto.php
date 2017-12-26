<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/estilo_socio.css">
	<?php 
	include("comprobar_acceso.php");
	include("comprobar_fecha.php");
	?>

	<title></title>
</head>
<body>
	<div id="contenedor">
	<header id="cabecera_pro">
		<nav id="menu_pri">
		<?php 
		include("menu_principal.php");
		 ?>
		</nav>
	</header>
	<nav id="menu_cat">
	<?php 
	include("menu_categorias.php") 
	?>
	</nav>
	<section id="seccion_pro">
	<?php 
		include("conectar.php");		
		$fila=mysql_query("select p.id_producto as id_pro,categoria,p.nombre as pro_nom,p.medida,p.descripcion,
			a.precio,pr.nombre as prod_nom,pr.apellidos as prod_ape
		 	from vende as a, productor pr, producto p
			where fecha=(
		    select max(fecha) from vende as b
		    where a.id_productor=b.id_productor
		    and a.id_producto=b.id_producto
		    and pr.id_productor=b.id_productor
		    and p.id_producto=b.id_producto) and p.estado='activado' and fecha_fin is NULL group by a.id_producto,a.id_productor");	

		if (isset($_GET['categoria'])) {
			$cat=$_GET['categoria'];
			$fila=mysql_query("select p.id_producto as id_pro,categoria,p.nombre as pro_nom,p.medida,p.descripcion,
			a.precio,pr.nombre as prod_nom,pr.apellidos as prod_ape
		 	from vende as a, productor pr, producto p
			where fecha=(
		    select max(fecha) from vende as b
		    where a.id_productor=b.id_productor
		    and a.id_producto=b.id_producto
		    and pr.id_productor=b.id_productor
		    and p.id_producto=b.id_producto) and categoria='$cat' and p.estado='activado' and fecha_fin is NULL group by a.id_producto,a.id_productor");
		}
	 ?>
	 <article>
	 		 	<?php 
	 			 	if ($horariopedido==0){
	 		echo "<article id='fuerahorarioped'>
	 		<p><h3>PEDIDO FUERA DE HORARIO</h3></p>
	 		</article>";
	 		}
	 	 ?>
	 <table id="tabla_pro" border="0" align="center">
	 	<tr>
	 		<th>Nombre</th>
	 		<th>Productor</th>
	 		<th>Precio</th>
	 		<th>Medida</th>
	 		<th>Descripción</th>
			<th>Cantidad</th>
	 	</tr>
	 	<form action="" mehod="GET">
	 		Nombre: <input type="text" name="criterio" />
	 		<input type="submit" value="Buscar"/>
	 	</form>
	 	<?php 
	 	echo "<form action='proceso_cesta.php' method='GET'>";
	 	if (!isset($_GET['criterio'])) {
	 		while ($celda = mysql_fetch_array($fila)) {
			 	echo"<tr>";	
			 			echo"<td>".$celda['pro_nom']."</td>";
			 			echo"<td>".$celda['prod_nom']." ".$celda['prod_ape']."</td>";
			 			echo"<td>".$celda['precio']."€"."</td>";
			 			echo"<td>".$celda['medida']."</td>";
			 			echo"<td>".$celda['descripcion']."</td>";
			 			/*se añade id al campo id_pro para que se pueda almacenar en la key de $_SESSION,
						tiene que empezar por un texto*/
				 		echo"<td><select name='idpro$celda[id_pro]' id='idpro$celda[id_pro]'>";
				 		if ($celda['medida']=='Kg') {
				 			for ($i=0; $i <= 9 ; $i = $i + 0.5) 
						 		{ 
						 			echo "<option value='$i'>$i</option>";
						 		}
				 		}else{
				 			for ($i=0; $i <= 9 ; $i++) 
					 			{ 
					 				echo "<option value='$i'>$i</option>";
					 			}
				 		}
				 		echo"</select></td>"; 		
			 	echo"</tr>";

	 	}
	 	}elseif (isset($_GET['criterio'])) {
	 	$criterio=$_GET['criterio'];
	 	$buscar=mysql_query("select p.id_producto as id_pro,categoria,p.nombre as pro_nom,p.medida,p.descripcion,
			a.precio,pr.nombre as prod_nom,pr.apellidos as prod_ape
		 	from vende as a, productor pr, producto p
			where fecha=(
		    select max(fecha) from vende as b
		    where a.id_productor=b.id_productor
		    and a.id_producto=b.id_producto
		    and pr.id_productor=b.id_productor
		    and p.id_producto=b.id_producto) and p.estado='activado' and fecha_fin is NULL and p.nombre like '%$criterio%' group by a.id_producto,a.id_productor");
		 		while ($celda = mysql_fetch_array($buscar)) {
		 	echo"<tr>";	
			 			echo"<td>".$celda['pro_nom']."</td>";
			 			echo"<td>".$celda['prod_nom']."</td>";
			 			echo"<td>".$celda['precio']."</td>";
			 			echo"<td>".$celda['medida']."</td>";
			 			echo"<td>".$celda['descripcion']."</td>"; 
				 		/*se añade id al campo id_pro para que se pueda almacenar en la key de $_SESSION,
						tiene que empezar por un texto*/
				 		echo"<td><select name='idpro$celda[id_pro]' id='idpro$celda[id_pro]'>";
				 		if ($celda['medida']=='Kg') {
				 			for ($i=0; $i <= 9 ; $i = $i + 0.5) 
						 		{ 
						 			echo "<option value='$i'>$i</option>";
						 		}
				 		}else{
				 			for ($i=0; $i <= 9 ; $i++) 
					 			{ 
					 				echo "<option value='$i'>$i</option>";
					 			}
				 		}
				 		echo"</select></td>"; 		
			 	echo"</tr>";
		 	}
	 	}
	 	if ($horariopedido==1) {
	 		echo "<tr><td><input type='submit' value='Añadir a la cesta'/></td></tr>";
	 	}
	 	echo"</form>";
	 	mysql_close();
	 	 ?>

	 </table>
	 </article>
	 <footer id="pie"><?php include('pie.php') ?></footer>
	 </section>
	 <aside id="menu_cesta">
	 <?php include("cesta.php") ?>
	</aside>
	 </div>
</body>
</html>