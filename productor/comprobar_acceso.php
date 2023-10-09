<?php
    session_start();
    if (!isset($_SESSION['id_productor']) and $_SESSION['rol']!="productor") {
        header("location: ../login.php");
    }
 ?>
