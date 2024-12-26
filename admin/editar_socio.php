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
        if (isset($_GET['nombre']) or isset($_GET['apellidos'])) {
            $query="update socio set nombre='$_GET[nombre]',apellidos='$_GET[apellidos]',email1='$_GET[email1]',telefono='$_GET[telefono]',password='$_GET[pass]' where id_socio='$_GET[id_socio]'";
            mysqli_query($con,$query);
        if ($query==0) {
            echo "usuario guardado $query";;
        }else{echo "Error en registro socio " .mysqli_error($con)."<br />";}

        }
        if (isset($_GET['id_socio'])) {
            $editarsocio=mysqli_query($con,"select nombre,apellidos,email1,telefono,password from socio where id_socio='$_GET[id_socio]'");
            $editarsocio = mysqli_fetch_array($editarsocio,MYSQLI_ASSOC);
        }
        mysqli_close($con);
     ?>
     <?php if (isset($_GET['id_socio'])){ ?>
      <form action="" method="GET">
         <table align="center">
             <tr>
                 <td align="right">Nombre: <input type="text" name="nombre" value="<?php echo"$editarsocio[nombre]" ?>"/></td>
                 <td align="right">Apellidos: <input type="text" name="apellidos" value="<?php echo"$editarsocio[apellidos]" ?>"/></td>
             </tr>
             <tr>
                 <td align="right">E-mail: <input type="text" name="email1" value="<?php echo"$editarsocio[email1]" ?>"/></td>
                 <td align="right">Teléfono: <input type="text" name="telefono" value="<?php echo"$editarsocio[telefono]" ?>"/></td>
             </tr>
             <tr>
                 <td align="right">Password: <input type="password" name="pass" value="<?php echo"$editarsocio[password]" ?>"/></td>
             </tr>
             <tr>
                 <input type="hidden" name="id_socio" value="<?php echo"$_GET[id_socio]" ?>">
                 <td align="center"><input type="submit" value="Enviar" /></td>
             </tr>
         </table>
     </form>
     <?php } ?>
            </article>
        </section>
    <aside id="menu_col">

    </aside>
    <footer id="pie"><?php include("../pie.php"); ?></footer>
</div>
</body>
</html>

