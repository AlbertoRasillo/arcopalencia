
<?php
	include("conectar.php");
	$precio_total=0;
	echo"<table id='tabla_cesta'>";
	echo"<tr id='cabecera_cesta'>";
		echo"<th colspan='6'>Cesta</th>";
	echo"</tr>";
	/*Utilizamos un nueva variable para la cesta con los datos de la sesion donde almacenamos
	el id del producto y la cantidad despues utilizamos esa variable para mostrarlo en pantalla
	no utilizamos $_SESSION para solo mostrar los datos del carro. La variable $patron nos permite
	identificar dentro de la $_SESSION los productos del carro y posteriormete guardar en $pro_cesta*/
	$patron = '/^idpro/';
	foreach ($_SESSION as $key => $value) {
		if (preg_match($patron, $key)==true){
			$pro_cesta[$key]=$value;
		}
	}
	if (isset($pro_cesta)) {
	foreach ($pro_cesta as $key => $value) {
	//eliminamos del key el string id para obtener el id_producto
	$id_pro=str_replace("idpro", "", $key);
	$pro_nom=mysql_query("select nombre,precio from producto inner join 
		vende on producto.id_producto=vende.id_producto where producto.id_producto='$id_pro' and fecha_fin is null");
	$res=mysql_fetch_assoc($pro_nom);
	echo"<tr>";
	echo "<td>$value</td>";
	echo "<td>x</td>";
	echo "<td>$res[nombre]</td>";
	$precio_total=$res['precio']*$value+$precio_total;	
	$precio_prod=$value*$res['precio'];
	echo "<td>$precio_prod</td>";
	echo "<td>€</td>";
	echo "<td><a href='eliminar_cesta.php?$key'><img src='img/eliminar.png' alt='Eliminar' id='eliminar'/></a></td>";
	}
	echo"</tr>";
	echo"<td colspan='3'>Total:</td>";
	echo "<td>$precio_total</td>";
	echo "<td>€</td>";
	if ($precio_total!=0) {
		echo "<tr><td colspan='6'><a href='proceso_pedido.php'><img src='img/cesta1.png'>Tramitar pedido</a></td></tr>";
	}
	echo"</table>";
	}
	
	
 ?>
 