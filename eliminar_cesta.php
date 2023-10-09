<?php
//Elimina productos del carro
session_start();
$id_pro=$_GET;
foreach ($id_pro as $key => $value) {
    unset($_SESSION[$key]);
}
header("location: buscar_producto.php");
?>
