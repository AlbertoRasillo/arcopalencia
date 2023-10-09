<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/estilo_admin2.css">
    <title></title>
    <?php include("comprobar_acceso.php") ?>
</head>
<body>
<div id="contenedor">
    <header id="cabecera_pri">
    <nav id="menu_pri">
        <?php
        include("menu_admin.php");
        ?>
    </nav>
    </header>
        <section id="seccion_pri">
            <article>

    <?php
        include("../conectar.php");
        // Comprueba si se ha enviado un nuevo estado en la URL
        if (isset($_GET['estado'])) {
            $estado = $_GET['estado'];
            $_SESSION['estado'] = $estado; // Almacena el estado en la variable de sesión
        } elseif (isset($_SESSION['estado'])) {
            $estado = $_SESSION['estado']; // Utiliza el estado almacenado en la variable de sesión
        } else {
            $estado = "activado"; // Valor predeterminado si no se ha especificado ningún estado
        }
        // Comprueba si se ha enviado un nuevo criterio de búsqueda en la URL
        if (isset($_GET['criterio'])) {
            $criterio = $_GET['criterio'];
            $_SESSION['criterio'] = $criterio; // Almacena el criterio de búsqueda en la variable de sesión
        } elseif (isset($_SESSION['criterio'])) {
            $criterio = $_SESSION['criterio']; // Utiliza el criterio de búsqueda almacenado en la variable de sesión
        } else {
            $criterio = ""; // Valor predeterminado si no se ha especificado ningún criterio de búsqueda
        }
         $fila=mysqli_query($con,"SELECT
                po.categoria AS categoria,
                po.medida AS medida,
                po.descripcion AS descripcion,
                po.estado AS estado,
                po.id_producto AS id_producto,
                pr.nombre AS pro_nom,
                po.nombre AS nombre,
                a.precio AS precio,
                a.fecha
            FROM producto po
            INNER JOIN vende a ON po.id_producto = a.id_producto
            INNER JOIN productor pr ON a.id_productor = pr.id_productor
            LEFT JOIN (
                SELECT
                b.id_productor,
                b.id_producto,
                MAX(b.fecha) AS max_fecha
                FROM vende AS b
                GROUP BY b.id_productor, b.id_producto
            ) AS max_fecha_subquery ON a.id_productor = max_fecha_subquery.id_productor
                AND a.id_producto = max_fecha_subquery.id_producto
            WHERE a.fecha = max_fecha_subquery.max_fecha
                AND a.fecha_fin IS NULL
                AND po.estado = '".$estado."'
            ORDER BY po.nombre, pr.nombre DESC;
            ");
     ?>
     <table id="tabla">
         <tr>
             <th>Nombre</th>
             <th>Productor</th>
             <th>Categoría</th>
             <th>Precio</th>
             <th>Medida</th>
             <th>Descripción</th>
             <th>Estado</th>
             <th>Editar ficha</th>
         </tr>
        <form action="" method="GET">
            Nombre: <input type="text" name="criterio" value="<?php echo $criterio; ?>" />
            <select name="estado">
            <option value="activado" <?php echo ($estado == "activado") ? "selected" : ""; ?>>activado</option>
            <option value="desactivado" <?php echo ($estado == "desactivado") ? "selected" : ""; ?>>desactivado</option>
            </select>
            <input type="submit" value="Buscar" />
        </form>
         <a href="ficha_producto.php"><img id="anadir" src="../img/anadir.png" alt="add">Añadir Producto</a>
         <?php
         if (!isset($_GET['criterio'])) {
             while ($celda = mysqli_fetch_array($fila,MYSQLI_ASSOC)) {
                 echo"<tr>";
                         echo"<td>".$celda['nombre']."</td>";
                         echo"<td>".$celda['pro_nom']."</td>";
                         echo"<td>".$celda['categoria']."</td>";
                         echo"<td>".$celda['precio']."</td>";
                         echo"<td>".$celda['medida']."</td>";
                         echo"<td>".$celda['descripcion']."</td>";
                         if($celda['estado']=='activado'){
                             echo"<td><a href='estado_ficha.php?id_producto=$celda[id_producto]&estado=desactivar'><img src='../img/activar.png'></a></td>";}
                             else{echo"<td><a href='estado_ficha.php?id_producto=$celda[id_producto]&estado=activar'><img src='../img/desactivar.png'></a></td>";}
                        echo"<td><a href='editar_producto.php?id_producto=$celda[id_producto]'><img src='../img/editar.gif'></a></td>";
                 echo"</tr>";
         }
         }elseif (isset($_GET['criterio'])) {
         $criterio=$_GET['criterio'];
         $buscar=mysqli_query($con,"SELECT
                po.categoria AS categoria,
                po.medida AS medida,
                po.descripcion AS descripcion,
                po.estado AS estado,
                po.id_producto AS id_producto,
                pr.nombre AS pro_nom,
                po.nombre AS nombre,
                a.precio AS precio,
                a.fecha
            FROM producto po
            INNER JOIN vende a ON po.id_producto = a.id_producto
            INNER JOIN productor pr ON a.id_productor = pr.id_productor
            LEFT JOIN (
                SELECT
                b.id_productor,
                b.id_producto,
                MAX(b.fecha) AS max_fecha
                FROM vende AS b
                INNER JOIN producto po_sub ON po_sub.id_producto = b.id_producto
                WHERE b.fecha_fin IS NULL
                GROUP BY b.id_productor, b.id_producto
            ) AS max_fecha_subquery ON a.id_productor = max_fecha_subquery.id_productor
                AND a.id_producto = max_fecha_subquery.id_producto
            WHERE po.nombre LIKE '%$criterio%' AND po.estado = '".$estado."'
                AND a.fecha = max_fecha_subquery.max_fecha;
            ");
                 while ($celda = mysqli_fetch_array($buscar,MYSQLI_ASSOC)) {
                 echo"<tr>";
                         echo"<td>".$celda['nombre']."</td>";
                         echo"<td>".$celda['pro_nom']."</td>";
                         echo"<td>".$celda['categoria']."</td>";
                         echo"<td>".$celda['precio']."</td>";
                         echo"<td>".$celda['medida']."</td>";
                         echo"<td>".$celda['descripcion']."</td>";
                         if($celda['estado']=='activado'){
                             echo"<td><a href='estado_ficha.php?id_producto=$celda[id_producto]&estado=desactivar&criterio=$criterio'><img src='../img/activar.png'></a></td>";}
                             else{echo"<td><a href='estado_ficha.php?id_producto=$celda[id_producto]&estado=activar&criterio=$criterio'><img src='../img/desactivar.png'></a></td>";}
                        echo"<td><a href='editar_producto.php?id_producto=$celda[id_producto]'><img src='../img/editar.gif'></a></td>";
                 echo"</tr>";
             }
         }
         mysqli_close($con);
          ?>
     </table>
            </article>
        </section>
    <aside id="menu_col">

    </aside>
    <footer id="pie"><?php include("../pie.php"); ?></footer>
</div>
</body>
</html>
