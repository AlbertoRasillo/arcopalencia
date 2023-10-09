<?php

    include("conectar.php");
    $categoria=mysqli_query($con,"select distinct(categoria) from producto");
    echo "<ul>";
    echo "<li>CATEGORIAS</li>";
    echo "<li><a href='buscar_producto.php'>Todos los Productos</a></li>";
    while ($menu = mysqli_fetch_array($categoria,MYSQLI_ASSOC)) {
        echo "<li><a href='buscar_producto.php?categoria=$menu[categoria]'>$menu[categoria]</a></li>";
    }
    echo " </ul>";

    mysqli_close($con);
 ?>




