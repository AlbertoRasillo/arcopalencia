<?php 
	if (isset($_POST['pass']) and isset($_POST['nombre'])) {
	include("conectar.php");
	$nombre=$_POST['nombre'];
	$nombre=mysqli_real_escape_string($con,$nombre);
	$pass=$_POST['pass'];
	$pass=mysqli_real_escape_string($con,$pass);
	$rol=$_POST['rol'];
	require_once('recaptcha-php/recaptchalib.php');
    $privatekey = "6Lcdx-ISAAAAALuYeJcIs2E9BaNH-s_nZNNt7MBv";
	if (isset($_POST["recaptcha_challenge_field"]) and isset($_POST["recaptcha_response_field"])) {
		$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
		if ($rol=="socio") {
		$comprobar=mysqli_query($con,"select id_socio from socio where email1='$nombre' and password='$pass' and estado='activado'");
		$resul=mysqli_fetch_array($comprobar,MYSQLI_ASSOC);
		if ($resul==true and $resp->is_valid) {
			foreach ($resul as $id_usuario => $v_id_usuario) {
				session_start();
				$_SESSION['id_usuario']=$v_id_usuario;
				$_SESSION['rol']="socio";
			}
			header("location: index.php");
		}else{
			header("location: login.php");
			session_start();
			$_SESSION['conta']=1+$_SESSION['conta'];
		}
	}
	if($rol=="productor"){
		$comprobar=mysqli_query($con,"select id_productor from productor where email='$nombre' and password='$pass' and estado='activado'");
		$resul=mysqli_fetch_array($comprobar,MYSQLI_ASSOC);
		if ($resul==true and $resp->is_valid) {
			foreach ($resul as $id_productor => $v_id_productor) {
				session_start();
				$_SESSION['id_productor']=$v_id_productor;
				$_SESSION['rol']="productor";
			}
			header("location: productor/index.php");
		}else{
			header("location: login.php");
			session_start();
			$_SESSION['conta']=1+$_SESSION['conta'];
		}
	}
	if($rol=="administrador"){
		$comprobar=mysqli_query($con,"select id_admin from admin where email='$nombre' and password='$pass'");
		$resul=mysqli_fetch_array($comprobar,MYSQLI_ASSOC);
		if ($resul==true and $resp->is_valid) {
			foreach ($resul as $id_admin => $v_id_admin) {
				session_start();
				$_SESSION['id_admin']=$v_id_admin;
				$_SESSION['rol']="administrador";
			}
			header("location: admin/index.php");
		}else{
			header("location: login.php");
			session_start();
			$_SESSION['conta']=1+$_SESSION['conta'];
		}
	}

	}else{
		if ($rol=="socio") {
		$comprobar=mysqli_query($con,"select id_socio from socio where email1='$nombre' and password='$pass' and estado='activado'");
		$resul=mysqli_fetch_array($comprobar,MYSQLI_ASSOC);
		if ($resul==true ) {
			foreach ($resul as $id_usuario => $v_id_usuario) {
				session_start();
				$_SESSION['id_usuario']=$v_id_usuario;
				$_SESSION['rol']="socio";
			}
			header("location: index.php");
		}else{
			header("location: login.php");
			session_start();
			$_SESSION['conta']=1+$_SESSION['conta'];
		}
	}
	if($rol=="productor"){
		$comprobar=mysqli_query($con,"select id_productor from productor where email='$nombre' and password='$pass' and estado='activado'");
		$resul=mysqli_fetch_array($comprobar,MYSQLI_ASSOC);
		if ($resul==true) {
			foreach ($resul as $id_productor => $v_id_productor) {
				session_start();
				$_SESSION['id_productor']=$v_id_productor;
				$_SESSION['rol']="productor";
			}
			header("location: productor/index.php");
		}else{
			header("location: login.php");
			session_start();
			$_SESSION['conta']=1+$_SESSION['conta'];
		}
	}
	if($rol=="administrador"){
		$comprobar=mysqli_query($con,"select id_admin from admin where email='$nombre' and password='$pass'");
		$resul=mysqli_fetch_array($comprobar,MYSQLI_ASSOC);
			if ($resul==true) {
				foreach ($resul as $id_admin => $v_id_admin) {
					session_start();
					$_SESSION['id_admin']=$v_id_admin;
					$_SESSION['rol']="administrador";
				}
				header("location: admin/index.php");
			}else{
				header("location: login.php");
				session_start();
				$_SESSION['conta']=1+$_SESSION['conta'];
			}
		}


	}
	
	
	}
	

	
 ?>