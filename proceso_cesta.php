<?php
	/*
	Este codigo se encarga de procesar y añadir a la cesta los productos y las
	cantidades
	*/
	$cesta = $_GET; 
	
	session_start();
	include("conectar.php");
	//Elimina los productos que tienen cantidad 0 
	foreach ($cesta as $key => $value) {
			if ($value==0) {
				unset($cesta[$key]);
			}
		}
	/*-Si se añade productos con valor 0 se redirecciona pagina productos-*/
	if ($cesta==Array()) {
			header("location: buscar_producto.php");
	}
	/*
	Añade los productos al array $_SESSION, si ya existe el array lo añade
	al existente los productos y las cantidades y si no existe el array lo crea 
	y añade los productos y sus cantidades
	*/
	foreach ($cesta as $key => $value) {
		if (isset($_SESSION[$key])) {
			$_SESSION[$key]=$value+$_SESSION[$key];
			//print_r($_SESSION);	
			header("location: buscar_producto.php");
		}else{
			$_SESSION[$key]=$value;
			//print_r($_SESSION);
			header("location: buscar_producto.php");
		}
		
	}

 ?>	