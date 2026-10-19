<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Language" content="es">
    <meta name="language" content="es">
    <link rel="stylesheet" href="../css/estilo_productor.css">
    <title>Mis Productos</title>
    <?php include("comprobar_acceso.php"); ?>
</head>
<body>
<div id="contenedor">
    <header id="cabecera_pri">
        <nav id="menu_pri">
            <?php include("menu_principal.php"); ?>
        </nav>
    </header>
    <section id="seccion_pri">
        <article>
            <?php
            include("../conectar.php");

            // Obtener ID del productor desde la sesión
            $id_productor = $_SESSION['id_productor'];

            // Filtro por Estado
            if (isset($_GET['estado'])) {
                $estado = $_GET['estado'];
                $_SESSION['estado'] = $estado;
            } elseif (isset($_SESSION['estado'])) {
                $estado = $_SESSION['estado'];
            } else {
                $estado = "activado";
            }

            // Criterio de Búsqueda
            if (isset($_GET['criterio'])) {
                $criterio = $_GET['criterio'];
                $_SESSION['criterio'] = $criterio;
            } elseif (isset($_SESSION['criterio'])) {
                $criterio = $_SESSION['criterio'];
            } else {
                $criterio = "";
            }

            // Preparar filtro SQL para búsqueda por nombre
            $where_criterio = "";
            if (!empty($criterio)) {
                $criterio_escapado = mysqli_real_escape_string($con, $criterio);
                $where_criterio = " AND po.nombre LIKE '%" . $criterio_escapado . "%'";
            }

            $estado_escapado = mysqli_real_escape_string($con, $estado);

            // Consulta filtrada estrictamente por el id_productor de la sesión
            $sql = "SELECT
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
                        WHERE b.fecha_fin IS NULL
                        GROUP BY b.id_productor, b.id_producto
                    ) AS max_fecha_subquery ON a.id_productor = max_fecha_subquery.id_productor
                        AND a.id_producto = max_fecha_subquery.id_producto
                    WHERE a.fecha = max_fecha_subquery.max_fecha
                        AND a.fecha_fin IS NULL
                        AND pr.id_productor = '$id_productor'
                        AND po.estado = '$estado_escapado'
                        $where_criterio
                    ORDER BY po.nombre ASC";

            $resultado = mysqli_query($con, $sql);
            ?>

            <!-- Formulario de Búsqueda -->
            <form action="productos.php" method="GET">
                Nombre: <input type="text" name="criterio" value="<?php echo htmlspecialchars($criterio); ?>" />
                <select name="estado">
                    <option value="activado" <?php echo ($estado == "activado") ? "selected" : ""; ?>>activado</option>
                    <option value="desactivado" <?php echo ($estado == "desactivado") ? "selected" : ""; ?>>desactivado</option>
                </select>
                <input type="submit" value="Buscar" />
            </form>

            <br>

            <!-- Tabla de Productos (sin columna de Editar) -->
            <table id="tabla">
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Medida</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                </tr>
                <?php
                if ($resultado && mysqli_num_rows($resultado) > 0) {
                    while ($celda = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($celda['nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($celda['categoria']) . "</td>";
                        echo "<td>" . htmlspecialchars($celda['precio']) . "</td>";
                        echo "<td>" . htmlspecialchars($celda['medida']) . "</td>";
                        echo "<td>" . htmlspecialchars($celda['descripcion']) . "</td>";
                        
                        // Botón para cambiar estado (activar/desactivar)
                        if ($celda['estado'] == 'activado') {
                            echo "<td><a href='estado_ficha.php?id_producto=" . $celda['id_producto'] . "&estado=desactivar&criterio=" . urlencode($criterio) . "'><img src='../img/activar.png' alt='Desactivar'></a></td>";
                        } else {
                            echo "<td><a href='estado_ficha.php?id_producto=" . $celda['id_producto'] . "&estado=activar&criterio=" . urlencode($criterio) . "'><img src='../img/desactivar.png' alt='Activar'></a></td>";
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No se encontraron productos.</td></tr>";
                }

                mysqli_close($con);
                ?>
            </table>
        </article>
    </section>
    <aside id="menu_col"></aside>
    <footer id="pie"><?php include('../pie.php'); ?></footer>
</div>
</body>
</html>
