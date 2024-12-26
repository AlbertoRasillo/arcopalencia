<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Language" content="es">
    <meta name="language" content="es">
    <link rel="stylesheet" href="css/estilo_socio.css">
    <?php
    include("comprobar_acceso.php");
    include("comprobar_fecha.php");
    ?>

    <title></title>
</head>
<body>
    <div id="contenedor">
    <header id="cabecera_pro">
        <nav id="menu_pri">
        <?php
        include("menu_principal.php");
         ?>
        </nav>
    </header>
    <nav id="menu_cat">
    <?php
    include("menu_categorias.php")
    ?>
    </nav>
    <section id="seccion_pro">
    <?php
        include("conectar.php");
        $fila=mysqli_query($con,"SELECT p.id_producto AS id_pro, p.categoria, p.nombre AS pro_nom, p.medida, p.descripcion,
                 a.precio, pr.nombre AS prod_nom, pr.apellidos AS prod_ape
            FROM vende AS a
            JOIN (
                SELECT id_productor, id_producto, MAX(fecha) AS max_fecha
                FROM vende
                GROUP BY id_productor, id_producto
            ) AS max_fecha_vende
            ON a.id_productor = max_fecha_vende.id_productor
            AND a.id_producto = max_fecha_vende.id_producto
            JOIN productor AS pr
            ON a.id_productor = pr.id_productor
            JOIN producto AS p
            ON a.id_producto = p.id_producto
            WHERE p.estado = 'activado' AND a.fecha = max_fecha_vende.max_fecha AND a.fecha_fin IS NULL;
            ");

        if (isset($_GET['categoria'])) {
            $cat=$_GET['categoria'];
            $fila=mysqli_query($con,"SELECT p.id_producto AS id_pro, p.categoria, p.nombre AS pro_nom, p.medida, p.descripcion,
                   a.precio, pr.nombre AS prod_nom, pr.apellidos AS prod_ape
            FROM vende AS a
            JOIN (
                SELECT id_productor, id_producto, MAX(fecha) AS max_fecha
                FROM vende
                GROUP BY id_productor, id_producto
            ) AS max_fecha_vende
            ON a.id_productor = max_fecha_vende.id_productor
            AND a.id_producto = max_fecha_vende.id_producto
            JOIN productor AS pr
            ON a.id_productor = pr.id_productor
            JOIN producto AS p
            ON a.id_producto = p.id_producto
            WHERE p.categoria = '$cat' AND p.estado = 'activado' AND a.fecha_fin IS NULL;
            ");
        }
     ?>
     <article>
                  <?php
                      if ($horariopedido==0){
             echo "<article id='fuerahorarioped'>
             <p><h3>PEDIDO FUERA DE HORARIO</h3></p>
             </article>";
             }
          ?>
     <table id="tabla_pro" border="0" align="center">
         <tr>
             <th>Nombre</th>
             <th>Productor</th>
             <th>Precio</th>
             <th>Medida</th>
             <th>Descripción</th>
            <th>Cantidad</th>
         </tr>
         <form action="" mehod="GET">
             Nombre: <input type="text" name="criterio" />
             <input type="submit" value="Buscar"/>
         </form>
         <?php
         echo "<form action='proceso_cesta.php' method='GET'>";
         if (!isset($_GET['criterio'])) {
             while ($celda = mysqli_fetch_array($fila,MYSQLI_ASSOC)) {
                 echo"<tr>";
                         echo"<td>".$celda['pro_nom']."</td>";
                         echo"<td>".$celda['prod_nom']." ".$celda['prod_ape']."</td>";
                         echo"<td>".$celda['precio']."€"."</td>";
                         echo"<td>".$celda['medida']."</td>";
                         echo"<td>".$celda['descripcion']."</td>";
                         /*se añade id al campo id_pro para que se pueda almacenar en la key de $_SESSION,
                        tiene que empezar por un texto*/
                         echo"<td><select name='idpro$celda[id_pro]' id='idpro$celda[id_pro]'>";
                         if ($celda['medida']=='Kg') {
                             for ($i=0; $i <= 9 ; $i = $i + 0.5)
                                 {
                                     echo "<option value='$i'>$i</option>";
                                 }
                         }else{
                             for ($i=0; $i <= 9 ; $i++)
                                 {
                                     echo "<option value='$i'>$i</option>";
                                 }
                         }
                         echo"</select></td>";
                 echo"</tr>";

         }
         }elseif (isset($_GET['criterio'])) {
         $criterio=$_GET['criterio'];
         $buscar=mysqli_query($con,"SELECT p.id_producto AS id_pro, p.categoria, p.nombre AS pro_nom, p.medida, p.descripcion,
                   a.precio, pr.nombre AS prod_nom, pr.apellidos AS prod_ape
            FROM vende AS a
            JOIN (
                SELECT id_productor, id_producto, MAX(fecha) AS max_fecha
                FROM vende
                WHERE fecha_fin IS NULL
                GROUP BY id_productor, id_producto
            ) AS max_fecha_vende
            ON a.id_productor = max_fecha_vende.id_productor
            AND a.id_producto = max_fecha_vende.id_producto
            JOIN productor AS pr
            ON a.id_productor = pr.id_productor
            JOIN producto AS p
            ON a.id_producto = p.id_producto
            WHERE p.estado = 'activado'
            AND p.nombre LIKE '%$criterio%'
            AND a.fecha = max_fecha_vende.max_fecha
            GROUP BY a.id_producto, a.id_productor;
            ");
                while ($celda = mysqli_fetch_array($buscar,MYSQLI_ASSOC)) {
             echo"<tr>";
                         echo"<td>".$celda['pro_nom']."</td>";
                         echo"<td>".$celda['prod_nom']."</td>";
                         echo"<td>".$celda['precio']."</td>";
                         echo"<td>".$celda['medida']."</td>";
                         echo"<td>".$celda['descripcion']."</td>";
                         /*se añade id al campo id_pro para que se pueda almacenar en la key de $_SESSION,
                        tiene que empezar por un texto*/
                         echo"<td><select name='idpro$celda[id_pro]' id='idpro$celda[id_pro]'>";
                         if ($celda['medida']=='Kg') {
                             for ($i=0; $i <= 9 ; $i = $i + 0.5)
                                 {
                                     echo "<option value='$i'>$i</option>";
                                 }
                         }else{
                             for ($i=0; $i <= 9 ; $i++)
                                 {
                                     echo "<option value='$i'>$i</option>";
                                 }
                         }
                         echo"</select></td>";
                 echo"</tr>";
             }
         }
         if ($horariopedido==1) {
             echo "<tr><td><input type='submit' value='Añadir a la cesta'/></td></tr>";
         }
         echo"</form>";
         mysqli_close($con);
          ?>

     </table>
     </article>
     <footer id="pie"><?php include('pie.php') ?></footer>
     </section>
     <aside id="menu_cesta">
     <?php include("cesta.php") ?>
    </aside>
     </div>
</body>
</html>
