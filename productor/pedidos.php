<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../jquery/themes/base/jquery.ui.all.css">
	<script src="../jquery/jquery-1.9.1.js"></script>
	<script src="../jquery/ui/jquery.ui.core.js"></script>
	<script src="../jquery/ui/jquery.ui.widget.js"></script>
	<script src="../jquery/ui/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="../css/estilo_productor.css">
	<?php include("comprobar_acceso.php") ?>
	<?php include("../conectar.php") ?>	
	<script>
	$(function() {
		$( "#fecha_inicio" ).datepicker({dateFormat: "yy-mm-dd"});
		$( "#fecha_fin" ).datepicker({dateFormat: "yy-mm-dd"});
	});
	// Traducción al español calendario datepicker
	$(function($){
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        weekHeader: 'Sm',
        firstDay: 1,

	    };
	    $.datepicker.setDefaults($.datepicker.regional['es']);
	});
	</script>

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
			<form method="GET">
				Fecha inicio:<input type="text" name="fecha_inicio" autocomplete="off" id="fecha_inicio">
				Fecha Fin:<input type="text" name="fecha_fin" autocomplete="off" id="fecha_fin">
				<input type="submit" value="Buscar">
			</form>
			</article>
			<article>
			<?php if (isset($_GET['fecha_inicio'])and isset($_GET['fecha_fin'])){
				$fecha_inicio=$_GET['fecha_inicio'];
				$fecha_fin=$_GET['fecha_fin'];
				$id_productor=$_SESSION['id_productor'];
				if ($fecha_inicio<=$fecha_fin) {
									$pedidos=mysqli_query($con,"select s.id_socio as id_socio,c.id_cabecera_pedido,v.id_productor,s.nombre as nombre, s.apellidos,DATE_FORMAT(c.fecha,'%d-%m-%Y %T') as fecha,p.cantidad,v.precio,pr.nombre as producto
				    from socio s,cabecera_pedido c,pedido p,vende v,producto pr
				    where s.id_socio=c.id_socio and c.id_cabecera_pedido=p.id_cabecera_pedido and
				    p.id_vende=v.id_vende and pr.id_producto=v.id_producto and v.id_productor='$id_productor' and c.fecha between '$fecha_inicio' and '$fecha_fin' + INTERVAL 1 DAY order by c.id_cabecera_pedido DESC");
				$total=mysqli_query($con,"select sum(p.cantidad) as sum_cant,pr.nombre as prod_nom 
				    from socio s,cabecera_pedido c,pedido p,vende v,producto pr
				    where s.id_socio=c.id_socio and c.id_cabecera_pedido=p.id_cabecera_pedido and
				    p.id_vende=v.id_vende and pr.id_producto=v.id_producto and v.id_productor='$id_productor' and c.fecha between '$fecha_inicio' and '$fecha_fin' + INTERVAL 1 DAY group by pr.id_producto");
				echo"<table id='tabla_ped'>";
				echo"<tr>";
					echo"<td>Socio</td>";
					echo"<td>Producto</td>";
					echo"<td>Cantidad</td>";
					echo"<td>Precio</td>";
					echo"<td>Fecha</td>";
					echo"<td>Nº Pedido</td>";
				echo"</tr>";
				while ($fila = mysqli_fetch_assoc($pedidos)){
				echo"<tr>";
					echo"<td>$fila[nombre] $fila[apellidos]</td>";
					echo"<td>$fila[producto]</td>";
					echo"<td>$fila[cantidad]</td>";
					echo"<td>$fila[precio]</td>";
					echo"<td>$fila[fecha]</td>";
					echo"<td>$fila[id_cabecera_pedido]</td>";
				echo"</tr>";
					}
				echo"</table>";
				echo "<br />";
				echo"<table id='tabla_ped_tot'>";
				echo"<th>TOTALES</th>";
				echo"<tr>";
					echo"<td>Producto</td>";
					echo"<td>Cantidad</td>";
				echo"</tr>";
				while ($fila1 = mysqli_fetch_assoc($total)){
				echo"<tr>";
					echo"<td>$fila1[prod_nom]</td>";
					echo"<td>$fila1[sum_cant]</td>";
				echo"</tr>";
				}
				echo"</table>";
				}else{echo"<span id='error_fecha'>Introduce correctamente las fechas!</span>";}

				}
			?>
		 </article>
		</section>
	<aside id="menu_col">
		
	</aside>
	<footer id="pie"><?php include('../pie.php') ?></footer>
</div>
</body>
</html>