<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/estilo_socio.css">
	<title></title>
	<?php include("comprobar_acceso.php") ?>
</head>
<body>
	<?php include("conectar.php");?>
<div id="contenedor">
	<header id="cabecera_pro_ped">
		<h2>Procesar pedido</h2>
	</header>
	<nav id="menu_pro_ped">
		<?php 
		include("menu_principal.php"); 
		session_start();
		?>
	</nav>
		<section id="seccion_pro_ped">
			<article>
				<table id="tabla_pro_ped">
					<tr>
						<th>Producto</th>
						<th>Cantidad</th>
						<th>Precio</th>
						<th>Descripción</th>
						<th>Productor</th>
					</tr>
				<?php 
				$patron = '/^idpro/';
				foreach ($_SESSION as $key => $value) {
					if (preg_match($patron, $key)==true){
						$pro_cesta[$key]=$value;
					}
				}
				$precio_total=0;
				if (isset($pro_cesta)) {
					foreach ($pro_cesta as $key => $value) {
					$id_pro=str_replace("idpro", "", $key);
					
					$cesta=mysql_query("select producto.descripcion as pro_des,producto.nombre as pro_nom,precio,productor.nombre as prod_nom,productor.apellidos as prod_ape from 
						producto inner join vende on producto.id_producto=vende.id_producto inner join productor
						on vende.id_productor=productor.id_productor where producto.id_producto='$id_pro' and fecha_fin is null");
					$cesta=mysql_fetch_assoc($cesta);
					echo"<tr>";
						echo"<td>$cesta[pro_nom]</td>";
						echo"<td>$value</td>";
						echo"<td>$cesta[precio]€</td>";
						echo"<td>$cesta[pro_des]</td>";
						echo"<td>$cesta[prod_nom] $cesta[prod_ape]</td>";
					echo"</tr>";
					$precio_total=$cesta['precio']*$value+$precio_total;
					}
				}
				mysql_close();
				 ?>
					<tr>
						<td colspan="2"><input type="button" onClick="document.location = 'confirmar_pedido.php'" value="Confirmar pedido"></td>
						<td colspan="3">Subtotal: <?php echo $precio_total ?>€</td>
					</tr>
				</table>
			</article>
		</section>
	<footer id="pie"><?php include('pie.php') ?></footer>
</div>
</body>
</html>