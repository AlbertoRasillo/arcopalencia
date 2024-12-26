<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Language" content="es">
    <meta name="language" content="es">
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
        $fila=mysqli_query($con,"select * from socio order by nombre ASC");
     ?>
     <table id="tabla" border="0">
         <tr>
             <th>Nombre</th>
             <th>Apellidos</th>
             <th>e-mail</th>
             <th>Teléfono</th>
             <th>Estado</th>
             <th>Editar ficha</th>
         </tr>
         <form action="" mehod="GET">
             Nombre: <input type="text" name="criterio" />
             <input type="submit" value="Buscar"/>
         </form>
         <a href="ficha_socio.php"><img id="anadir" src="../img/anadir.png" alt="add">Añadir Socio</a>
         <?php
         if (!isset($_GET['criterio'])) {
             while ($celda = mysqli_fetch_array($fila,MYSQLI_ASSOC)) {
                 echo"<tr>";
                         echo"<td>".$celda['nombre']."</td>";
                         echo"<td>".$celda['apellidos']."</td>";
                         echo"<td>".$celda['email1']."</td>";
                         echo"<td>".$celda['telefono']."</td>";
                         if($celda['estado']=='activado'){
                             echo"<td><a href='estado_ficha.php?id_socio=$celda[id_socio]&estado=desactivar'><img src='../img/activar.png'></a></td>";}
                             else{echo"<td><a href='estado_ficha.php?id_socio=$celda[id_socio]&estado=activar'><img src='../img/desactivar.png'></a></td>";}
                         echo"<td><a href='editar_socio.php?id_socio=$celda[id_socio]'><img src='../img/editar.gif'></a></td>";
                 echo"</tr>";
         }
         }elseif (isset($_GET['criterio'])) {
         $criterio=$_GET['criterio'];
         $buscar=mysqli_query($con,"select * from socio where nombre like
        '%$criterio%' order by nombre");
                 while ($celda = mysqli_fetch_array($buscar,MYSQLI_ASSOC)) {
             echo"<tr>";
                     echo"<td>".$celda['nombre']."</td>";
                    echo"<td>".$celda['apellidos']."</td>";
                     echo"<td>".$celda['email1']."</td>";
                     echo"<td>".$celda['telefono']."</td>";
                     echo"<td><a href='editar_socio.php?id_socio=$celda[id_socio]'><img src='../img/editar.gif'></a></td>";
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
