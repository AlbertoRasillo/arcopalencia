<?php 
	session_start();
	if (!isset($_SESSION['id_usuario']) and $_SESSION['rol']!="socio") {
		header("location: login.php");
	}
 ?>