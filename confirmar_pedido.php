<?php
	
	session_start();
	/*-Establecemos la hora local-*/
	setlocale(LC_TIME, "es_ES");
	date_default_timezone_set('Europe/Madrid');
	include("conectar.php");
	/*-Asignamos una variable para id_socio almacenada en la session actual-*/
	$id_socio=$_SESSION['id_usuario'];
	/*-Obtenemos de la session los id de los productos y lo alamcenamos en el array $pro_cesta-*/
	$patron = '/^idpro/';
	foreach ($_SESSION as $key => $value) {
		if (preg_match($patron, $key)==true){
			$pro_cesta[$key]=$value;
		}
	}
	/*-Insertamos los datos de la cabecera de pedido-*/
		$cabecer_pedido=mysqli_query($con,"insert into cabecera_pedido (id_socio,fecha) values ($id_socio,Now())");
		$id_cabecera=mysqli_query($con,"select LAST_INSERT_ID() from cabecera_pedido");
		$id_cabecera=mysqli_fetch_array($id_cabecera,MYSQLI_ASSOC);
		$id_cabecera=$id_cabecera['LAST_INSERT_ID()'];
	/*-Eliminamos en la key del array $pro_cesta el string idpro y despues ejecutamos el insert 
	por cada producto de la cesta, finalmente mostramos si hay error en el insert y
	eliminamos el id producto de la session-*/
	foreach ($pro_cesta as $key => $cantidad) {
		$id_pro=str_replace("idpro", "", $key);
	/*-Consultamos el precio de los productos para almacenarlo en la tabla de pedidos ya que los precios
	pueden variar en el tiempo y tiene que reflejarse el precio con el que se realizó la compra-*/
		$precio_producto=mysqli_query($con,"select id_vende from vende 
			where id_producto='$id_pro' and fecha_fin is null");
		$precio_prod=mysqli_fetch_array($precio_producto,MYSQLI_ASSOC);
			$id_vende=$precio_prod['id_vende'];
			$insert_pedido=mysqli_query($con,"insert into pedido (cantidad,id_cabecera_pedido,id_vende)
	values ($cantidad,$id_cabecera,$id_vende)");	
		if ($insert_pedido==0) {
			echo "Error en la compra " .mysqli_error($con)."<br />";
			//print_r($precio_producto);
		}//else{header("location: index.php");}
		unset($_SESSION[$key]);
		if ($insert_pedido==0) {
			echo "Error en la compra " .mysqli_error($con)."<br />";
			print_r($precio_producto);
		}else{
			header("location: historial_pedidos.php?id_pedido_realizado=$id_cabecera");
		}
		unset($_SESSION[$key]);
	}
	

 ?>