<?php 
	session_start();
	if (!isset($_SESSION['id_admin']) and $_SESSION['rol']!="administrador") {
		header("location: ../login.php");
	}
 ?>