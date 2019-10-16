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
		if (isset($_GET['id_producto'])) {
			
			$editarproducto=mysqli_query($con,"select a.id_vende as id_vende,p.categoria as categoria,p.medida as medida,p.descripcion as descripcion,
					p.estado as estado,p.id_producto as id_producto,pr.id_productor as id_productor,pr.nombre,p.nombre as nombre,a.precio, a.fecha
    				from vende as a, productor pr, producto p
    				where fecha=(
					    select max(fecha) from vende as b
					    where a.id_productor=b.id_productor
					    and a.id_producto=b.id_producto
					    and pr.id_productor=b.id_productor
						and p.id_producto=b.id_producto) and p.id_producto='$_GET[id_producto]' and fecha_fin is null group by a.id_producto,a.id_productor");
			$editarproducto = mysqli_fetch_array($editarproducto,MYSQLI_ASSOC);
			print_r($editarproducto);
		}
		if (isset($_GET['nombre']) or isset($_GET['precio'])) {
			
			if ($editarproducto['precio']!=$_GET['precio'] AND $editarproducto['id_productor']!=$_GET['id_productor']) {
				echo "precio y productor";
				$fin_producto=mysqli_query($con,"update vende set fecha_fin=Now() where id_vende='$editarproducto[id_vende]'");
				$actualizar_producto="insert into vende (id_producto,id_productor,precio,fecha) values ($editarproducto[id_producto],
					$_GET[id_productor],$_GET[precio],Now())"; 
				mysqli_query($con,$actualizar_producto);
				$actualiza_ficha="update producto set
				nombre='$_GET[nombre_producto]',categoria='$_GET[categoria]',medida='$_GET[medida]',descripcion='$_GET[descripcion]'
				where id_producto='$_GET[id_producto]'";
				mysqli_query($con,$actualiza_ficha);
			}
			elseif ($editarproducto['id_productor']!=$_GET['id_productor']) {
				echo "productor";
				$fin_producto1=mysqli_query($con,"update vende set fecha_fin=Now() where id_vende='$editarproducto[id_vende]'");
				$actualizar_producto1="insert into vende (id_producto,id_productor,precio,fecha) values ($editarproducto[id_producto],
					'$_GET[id_productor]',$editarproducto[precio],Now())";
				mysqli_query($con,$actualizar_producto1);
				$actualiza_ficha1="update producto set
				nombre='$_GET[nombre_producto]',categoria='$_GET[categoria]',medida='$_GET[medida]',descripcion='$_GET[descripcion]'
				where id_producto='$_GET[id_producto]'";
				mysqli_query($con,$actualiza_ficha1);
			}
			elseif ($editarproducto['precio']!=$_GET['precio']) {
				echo"precio";
				$fin_producto2=mysqli_query($con,"update vende set fecha_fin=Now() where id_vende='$editarproducto[id_vende]'");
				$actualizar_producto2="insert into vende (id_producto,id_productor,precio,fecha) values ('$_GET[id_producto]','$_GET[id_productor]',
				'$_GET[precio]',Now())";
				mysqli_query($con,$actualizar_producto2);
				$actualiza_ficha2="update producto set
				nombre='$_GET[nombre_producto]',categoria='$_GET[categoria]',medida='$_GET[medida]',descripcion='$_GET[descripcion]'
				where id_producto='$_GET[id_producto]'";
				mysqli_query($con,$actualiza_ficha2);
			}else{
				$actualiza_ficha3="update producto set
				nombre='$_GET[nombre_producto]',categoria='$_GET[categoria]',medida='$_GET[medida]',descripcion='$_GET[descripcion]'
				where id_producto='$_GET[id_producto]'";
				mysqli_query($con,$actualiza_ficha3);
			}
		
		}
		
	 ?>
	  <?php if (isset($_GET['id_producto'])){ ?>
	<form action="" method="GET">
		 <table align="center">
		 	<tr>
		 		<td align="right">Nombre Producto: <input type="text" name="nombre_producto" value="<?php echo"$editarproducto[nombre]" ?>"/></td>	
		 		<td align="right">Categoría:  <select name="categoria" value="<?php echo"$editarproducto[categoria]" ?>">
												<option <?php if ($editarproducto['categoria']=='Aceites') {echo'selected="selected"';} ?>>Aceites</option>
												<option <?php if ($editarproducto['categoria']=='Carnes') {echo'selected="selected"';} ?>>Carnes</option>
												<option <?php if ($editarproducto['categoria']=='Cosmetica') {echo'selected="selected"';} ?>>Cosmetica</option>
												<option <?php if ($editarproducto['categoria']=='Dulces') {echo'selected="selected"';} ?>>Dulces</option>
												<option <?php if ($editarproducto['categoria']=='Endulzantes') {echo'selected="selected"';} ?>>Endulzantes</option>
												<option <?php if ($editarproducto['categoria']=='Frutas') {echo'selected="selected"';} ?>>Frutas</option>
												<option <?php if ($editarproducto['categoria']=='Granos') {echo'selected="selected"';} ?>>Granos</option>
												<option <?php if ($editarproducto['categoria']=='Harinas') {echo'selected="selected"';} ?>>Harinas</option>
												<option <?php if ($editarproducto['categoria']=='Huevos') {echo'selected="selected"';} ?>>Huevos</option>
												<option <?php if ($editarproducto['categoria']=='Lacteos') {echo'selected="selected"';} ?>>Lacteos</option>
												<option <?php if ($editarproducto['categoria']=='Legumbres') {echo'selected="selected"';} ?>>Legumbres</option>
												<option <?php if ($editarproducto['categoria']=='Limpieza') {echo'selected="selected"';} ?>>Limpieza</option>
												<option <?php if ($editarproducto['categoria']=='Pan') {echo'selected="selected"';} ?>>Pan</option>
												<option <?php if ($editarproducto['categoria']=='Pasta') {echo'selected="selected"';} ?>>Pasta</option>
												<option <?php if ($editarproducto['categoria']=='Verduras') {echo'selected="selected"';} ?>>Verduras</option>
											</select></td>
		 	</tr>
		 	<tr>
		 		<td align="right">Precio: <input type="text" name="precio" value="<?php echo"$editarproducto[precio]" ?>"/></td>
		 		<td align="right">Medida: <select name="medida">
												<option <?php if ($editarproducto['medida']=='Unidad') {echo'selected="selected"';} ?>>Unidad</option>
												<option <?php if ($editarproducto['medida']=='Kg') {echo"selected='selected'";} ?>>Kg</option>
												<option <?php if ($editarproducto['medida']=='Litro') {echo"selected='selected'";} ?>>Litro</option>
												<option <?php if ($editarproducto['medida']=='Docena') {echo"selected='selected'";} ?>>Docena</option>
											</select></td>
		 	</tr>
		 	<tr>
		 		<td>Descripción:<br /> <textarea name="descripcion" id="" cols="30" rows="5" ><?php echo"$editarproducto[descripcion]" ?></textarea></td>
		 		<td>
		 			<select name="id_productor" id="id_productor">
		 			<?php 
		 				$idproductor=mysqli_query($con,"select distinct(id_productor) as id_productor,nombre,apellidos from productor");
		 				if($idproductor==true){
							
						while ($celda = mysqli_fetch_array($idproductor,MYSQLI_ASSOC)) {
		 				if ($editarproducto['id_productor']==$celda['id_productor']) {
		 					echo"<option selected='selected' value=$celda[id_productor]>".$celda['nombre']." ".$celda['apellidos']."</option>";
		 				}else{
		 					echo"<option value=$celda[id_productor]>".$celda['nombre']." ".$celda['apellidos']."</option>";
		 				}
		 				
		 			} }?>
		 				
		 			</select>
		 		</td>
		 	</tr>
		 	<input type="hidden" name="id_producto" value="<?php echo"$_GET[id_producto]" ?>">
			<tr><td><input type="submit" value="Enviar" /></td></tr>
		 </table>
	 </form>
	 <?php } 	mysqli_close($con); ?>

			</article>
		</section>
	<aside id="menu_col">
		
	</aside>
	<footer id="pie"><?php include("../pie.php"); ?></footer>
</div>
</body>
</html>

