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
        if (isset($_GET['nombre'])or isset($_GET['apellidos'])) {
            $query="insert into productor (nombre,apellidos,email,telefono,direccion,password) values
            ('$_GET[nombre]','$_GET[apellidos]','$_GET[email]','$_GET[telefono]','$_GET[direccion]','$_GET[pass]')";
            mysqli_query($con,$query);
        if ($query) {
            echo "productor guardado $query";;
        }else{echo "error";}

        }
        mysqli_close($con);
     ?>
     <h3 align="center">Ficha Productor</h3>
     <form action="" method="GET">
         <table align="center">
             <tr>
                 <td align="right">Nombre: <input type="text" name="nombre" /></td>
                 <td align="right">Apellidos: <input type="text" name="apellidos" /></td>
             </tr>
             <tr>
                 <td align="right">E-mail: <input type="text" name="email" /></td>
                 <td align="right">Teléfono: <input type="text" name="telefono" /></td>
             </tr>
             <tr>
                 <td align="right">Dirección: <input type="text" name="direccion" /></td>
                 <td align="right">Password: <input type="password" name="pass" /></td>
             </tr>
             <tr>
                 <td align="center"><input type="submit" value="Enviar" /></td>
             </tr>
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

