<?php 
	include("../conectar.php");
	if (isset($_GET['id_producto'])) {
			$id_producto=$_GET['id_producto'];
		$estado=$_GET['estado'];
		if ($estado=="activar") {
			$prod_esta_acti="update producto set estado='activado' where id_producto='$id_producto'";
			mysqli_query($con,$prod_esta_acti);
			$pro_esta_acti="update productor inner join vende on productor.id_productor=vende.id_productor set estado='activado' where vende.id_producto='$id_producto'";
			mysqli_query($con,$pro_esta_acti);
			header("location: productos.php");
		}elseif($estado=="desactivar"){
			$prod_esta_desa="update producto set estado='desactivado' where id_producto='$id_producto'";
			mysqli_query($con,$prod_esta_desa);
			header("location: productos.php");
		}else{header("location: productos.php");}
	}
	if (isset($_GET['id_socio'])) {
			$id_socio=$_GET['id_socio'];
		$estado=$_GET['estado'];
		if ($estado=="activar") {
			$soc_esta_acti="update socio set estado='activado' where id_socio='$id_socio'";
			mysqli_query($con,$soc_esta_acti);
			header("location: socios.php");
		}elseif($estado=="desactivar"){
			$soc_esta_desa="update socio set estado='desactivado' where id_socio='$id_socio'";
			mysqli_query($con,$soc_esta_desa);
			header("location: socios.php");
		}else{header("location: socios.php");}
	}
	if (isset($_GET['id_productor'])) {
			$id_productor=$_GET['id_productor'];
		$estado=$_GET['estado'];
		if ($estado=="activar") {
			$pro_esta_acti="update productor set estado='activado' where id_productor='$id_productor'";
			mysqli_query($con,$pro_esta_acti);
			header("location: productores.php");
		}elseif($estado=="desactivar"){
			$pro_esta_desa="update productor set estado='desactivado' where id_productor='$id_productor'";
			mysqli_query($con,$pro_esta_desa);
			$prod_esta_desa="update producto inner join vende on producto.id_producto=vende.id_producto set estado='desactivado' where vende.id_productor='$id_productor'";
			mysqli_query($con,$prod_esta_desa);
			header("location: productores.php");
		}else{header("location: productores.php");}
	}
 ?>