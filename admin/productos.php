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
	 
	 	$fila=mysql_query("select po.categoria as categoria,po.medida as medida,po.descripcion as descripcion,
	 	po.estado as estado,po.id_producto as id_producto,
	 	pr.nombre as pro_nom, po.nombre as nombre, a.precio as precio, a.fecha
		from producto po, vende a, productor pr 
		where fecha=(
		    select max(fecha) from vende as b
		    where a.id_productor=b.id_productor
		    and a.id_producto=b.id_producto
		    and pr.id_productor=b.id_productor
		    and po.id_producto=b.id_producto) and fecha_fin is NULL group by a.id_producto,a.id_productor order by po.nombre,pr.nombre DESC");

	 ?>
	 <table id="tabla">
	 	<tr>
	 		<th>Nombre</th>
	 		<th>Productor</th>
	 		<th>Categoría</th>
	 		<th>Precio</th>
	 		<th>Medida</th>
	 		<th>Descripción</th>
	 		<th>Estado</th>
	 		<th>Editar ficha</th>
	 	</tr>

	 	<form action="" mehod="GET">
	 		Nombre: <input type="text" name="criterio" />
	 		<input type="submit" value="Buscar"/>
	 	</form>
	 	<a href="ficha_producto.php"><img id="anadir" src="../img/anadir.png" alt="add">Añadir Producto</a>
	 	<?php 
	 	if (!isset($_GET['criterio'])) {
	 		while ($celda = mysql_fetch_array($fila)) {
			 	echo"<tr>";	
			 			echo"<td>".$celda['nombre']."</td>";
			 			echo"<td>".$celda['pro_nom']."</td>";
			 			echo"<td>".$celda['categoria']."</td>";
			 			echo"<td>".$celda['precio']."</td>";
			 			echo"<td>".$celda['medida']."</td>";
			 			echo"<td>".$celda['descripcion']."</td>";
			 			if($celda['estado']=='activado'){
			 				echo"<td><a href='estado_ficha.php?id_producto=$celda[id_producto]&estado=desactivar'><img src='../img/activar.png'></a></td>";}
			 				else{echo"<td><a href='estado_ficha.php?id_producto=$celda[id_producto]&estado=activar'><img src='../img/desactivar.png'></a></td>";} 		
						echo"<td><a href='editar_producto.php?id_producto=$celda[id_producto]'><img src='../img/editar.gif'></a></td>";	
			 	echo"</tr>";
			 			
	 	}
	 	}elseif (isset($_GET['criterio'])) {
	 	$criterio=$_GET['criterio'];
	 	$buscar=mysql_query("select po.categoria as categoria,po.medida as medida,po.descripcion as descripcion,
	 	po.estado as estado,po.id_producto as id_producto,
	 	pr.nombre as pro_nom, po.nombre as nombre, a.precio as precio, a.fecha
		from producto po, vende a, productor pr 
		where fecha=(
		    select max(fecha) from vende as b
		    where a.id_productor=b.id_productor
		    and a.id_producto=b.id_producto
		    and pr.id_productor=b.id_productor
		    and po.id_producto=b.id_producto) and fecha_fin is NULL and po.nombre like 
		'%$criterio%' group by a.id_producto,a.id_productor");
		 		while ($celda = mysql_fetch_array($buscar)) {
			 	echo"<tr>";	
			 			echo"<td>".$celda['nombre']."</td>";
			 			echo"<td>".$celda['pro_nom']."</td>";
			 			echo"<td>".$celda['categoria']."</td>";
			 			echo"<td>".$celda['precio']."</td>";
			 			echo"<td>".$celda['medida']."</td>";
			 			echo"<td>".$celda['descripcion']."</td>";
			 			if($celda['estado']=='activado'){
			 				echo"<td><a href='estado_ficha.php?id_producto=$celda[id_producto]&estado=desactivar'><img src='../img/activar.png'></a></td>";}
			 				else{echo"<td><a href='estado_ficha.php?id_producto=$celda[id_producto]&estado=activar'><img src='../img/desactivar.png'></a></td>";} 		
						echo"<td><a href='editar_producto.php?id_producto=$celda[id_producto]'><img src='../img/editar.gif'></a></td>";	
			 	echo"</tr>";
		 	}
	 	}
	 	
	 	mysql_close();
	 	 ?>
	 </table>
			</article>
		</section>
	<aside id="menu_col">
		
	</aside>
	<footer id="pie"><?php include("../pie.php"); ?></footer>
</div>
</body>
</html>
