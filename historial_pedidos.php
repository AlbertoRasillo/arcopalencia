<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/estilo_socio.css">
	<?php include("comprobar_acceso.php") ?>
	<title></title>
</head>
<body>
	<?php include("conectar.php") ?>
<div id="contenedor">
	<header id="cabecera_pri">
		<nav id="menu_pri">
		<?php 
		include("menu_principal.php"); 
		?>
		</nav>
	</header>
	<?php
		/*-sistema de paginación para mostrar por paginas los pedidos-*/
		$tamano_pagina=10; 
		if(isset($_GET['pagina'])){
		$pagina=$_GET['pagina'];
		}
		if (!isset($pagina)) {
			$inicio=0;
			$pagina=1;
		}else{
			$inicio=($pagina-1)*$tamano_pagina;
		}
		//se puede cambiar el fomato de la fecha con date_format(fecha,'%d-%m-%Y') as fecha
		$fechas=mysqli_query($con,"select date_format(fecha,'%d-%m-%Y %T') as fecha1,fecha,id_cabecera_pedido from cabecera_pedido where id_socio=$_SESSION[id_usuario]
			group by fecha order by fecha DESC limit $inicio,$tamano_pagina");
		$registros=mysqli_query($con,"select count(id_cabecera_pedido) as registros from cabecera_pedido where id_socio=$_SESSION[id_usuario]");
		$registros=mysqli_fetch_array($registros,MYSQLI_ASSOC);
	 ?>
		<section id="lis_fec">
			<article>
				<table id="tabla_his_fec" border="1">
					<tr><th>Fechas de pedidos</th></tr>
				<?php 
				while ( $fila = mysqli_fetch_array($fechas,MYSQLI_ASSOC)) {
					echo"<tr>";
						echo"<td><a href='?id_fecha=$fila[fecha]&pagina=$pagina'>".$fila['fecha1']."</a></td>";
					echo"</tr>";
				}	
				 ?>	
			    </table>
			    <?php 
			    //muestro los distintos índices de las páginas, si es que hay varias páginas 
				$total_paginas=round($registros['registros']/$tamano_pagina);
				if ($total_paginas > 1){ 
				   	for ($i=1;$i<=$total_paginas;$i++){ 
				      	 if ($pagina == $i) 
				         	 //si muestro el índice de la página actual, no coloco enlace 
				         	 echo $pagina . " "; 
				      	 else 
				         	 //si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página
				         	 echo "<a href=?pagina=$i>".$i.	"</a> "; 
				   	} 
				}
			     ?>
			</article>
		</section>
		<?php if (isset($_GET['id_pedido_realizado'])): ?>
			<section>
				<article id="pedido_realizado">
					<?php 
					$id_pedido=$_GET['id_pedido_realizado'];
					echo "<p><h3> Gracias, has realizado tu pedido. Imprime el albarán!</h3></p>";
					echo "<h4>Número de pedido: $id_pedido</h4>";
					 ?>
				</article>
			</section>	
		<?php endif ?>
		
		<section id="ver_ped">
			<?php
			if (isset($_GET['id_fecha'])) {
				$id_fecha=$_GET['id_fecha'];
				$fecha_pedido=mysqli_query($con,"select producto.nombre as pro_nom, p.cantidad as pro_can, v.precio as pro_pre, productor.nombre as prod_nom, productor.apellidos as prod_ape from cabecera_pedido c, socio s, pedido p, vende v,
				producto, productor where c.id_socio=s.id_socio and c.id_cabecera_pedido=p.id_cabecera_pedido and p.id_vende=v.id_vende and v.id_producto=producto.id_producto
				and v.id_productor=productor.id_productor and c.fecha='$id_fecha' and s.id_socio=$_SESSION[id_usuario]");
				$total_pro=0;
				echo"<table id='tabla_his_ped' border='1'>";
					echo "<tr>";
						echo "<th>Producto</th>";
						echo "<th>Cantidad</th>";
						echo "<th>Precio</th>";
						echo "<th>Productor</th>";
					echo "</tr>";
					while ($fila=mysqli_fetch_array($fecha_pedido,MYSQLI_ASSOC)) {
					echo"<tr>";
						echo"<td>$fila[pro_nom]</td>";
						echo"<td>$fila[pro_can]</td>";
						echo"<td>$fila[pro_pre] €</td>";
						echo"<td>$fila[prod_nom] $fila[prod_ape]</td>";
					echo"</tr>";
					//guarda en el array $pedido los datos del pedido para crear PDF
					$pedido[]=$fila;
					$total_pro=$fila['pro_can']*$fila['pro_pre']+$total_pro;
					}
					echo"<tr>";
						echo"<td></td>";
						echo"<td>Subtotal:</td>";
						echo"<td>$total_pro €</td>";
						echo"<td></td>";
					echo"</tr>";
				echo"</table>";
				//consulta para obtener el nombre socio y la fecha de pedido para crear PDF
				$fecha_socio=mysqli_query($con,"select nombre, apellidos, DATE_FORMAT(fecha,'%d-%m-%Y %T') as fecha, id_cabecera_pedido from socio inner join cabecera_pedido on socio.id_socio=cabecera_pedido.id_socio
											where socio.id_socio=$_SESSION[id_usuario] and cabecera_pedido.fecha='$id_fecha' group by fecha");
				//almacenamos los datos en el array $fecha_socio_ped
				while ($fila=mysqli_fetch_array($fecha_socio,MYSQLI_ASSOC)) {
					$fecha_socio_ped=$fila;
				}
				//Utilizamos serialize para convertir el array en binario para que se pueda enviar por 
				// metodo GET
				$fecha_socio_ped=serialize($fecha_socio_ped);
				$pedido=serialize($pedido);
				$total_pro=serialize($total_pro);
				echo"<a href='fpdf/tabla_pedido.php?pedido=$pedido&&fecha_socio_ped=$fecha_socio_ped&&total_pro=$total_pro' target='_blank'>Guardar en <img src='img/logo-pdf.gif' alt='pdf' /></a>";
			}
			mysqli_close($con);
			 ?>
		</section>
			 <div id="push"></div>
	<aside id="">
		
	</aside>
	<footer id="pie"><?php include('pie.php') ?></footer>
</div>
</body>
</html>