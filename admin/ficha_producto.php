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
        if (isset($_GET['nombre'])or isset($_GET['precio'])) {
            $query="insert into producto (nombre,categoria,medida,descripcion) values
            ('$_GET[nombre_producto]','$_GET[categoria]','$_GET[medida]','$_GET[descripcion]')";
            mysqli_query($con,$query);
            $query2="insert into vende (id_producto,id_productor,precio,fecha) values (LAST_INSERT_ID(),'$_GET[id_productor]',
            '$_GET[precio]',Now())";
            mysqli_query($con,$query2);
        if ($query) {
            echo "Producto guardado $query";;
        }else{echo "error";}

        }

     ?>
      <h3 align="center">Ficha Producto</h3>
    <form action="" method="GET">
         <table align="center">
             <tr>
                 <td align="right">Nombre Producto: <input type="text" name="nombre_producto" /></td>
                 <td align="right">Categoría:  <select name="categoria">
                                                 <option>Aceites</option>
                                                 <option>Carnes</option>
                                                 <option>Cosmetica</option>
                                                 <option>Dulces</option>
                                                 <option>Endulzantes</option>
                                                 <option>Frutas</option>
                                                 <option>Granos</option>
                                                 <option>Harinas</option>
                                                 <option>Huevos</option>
                                                 <option>Lacteos</option>
                                                <option>Legumbres</option>
                                                <option>Limpieza</option>
                                                <option>Pan</option>
                                                <option>Pasta</option>
                                                <option>Verduras</option>
                                            </select></td>
             </tr>
             <tr>
                 <td align="right">Precio: <input type="text" name="precio" /></td>
                 <td align="right">Medida: <select name="medida">
                                                <option>Unidad</option>
                                                <option>Kg</option>
                                                <option>Litro</option>
                                                <option>Docena</option>
                                            </select></td>
             </tr>
             <tr>
                 <td>Descripción:<br /> <textarea name="descripcion" id="" cols="30" rows="5"></textarea></td>
                 <td>
                     Productor:<select name="id_productor" id="id_productor">
                     <?php
                         $idproductor=mysqli_query($con,"select nombre,apellidos,id_productor from productor order by nombre,apellidos DESC");
                         if($idproductor==true){
                        while ($celda = mysqli_fetch_array($idproductor,MYSQLI_ASSOC)) {
                         echo"<option value=$celda[id_productor]>".$celda['nombre']." ".$celda['apellidos']."</option>";
                     } }?>

                     </select>
                 </td>
             </tr>
            <tr><td><input type="submit" value="Enviar" /></td></tr>
         </table>
        </form>
            </article>
        </section>
    <aside id="menu_col">

    </aside>
    <footer id="pie"><?php include("../pie.php"); ?></footer>
</div>
</body>
</html>

