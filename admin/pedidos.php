<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../jquery/themes/base/jquery.ui.all.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script src="../jquery/jquery-1.9.1.js"></script>
    <script src="../jquery/ui/jquery.ui.core.js"></script>
    <script src="../jquery/ui/jquery.ui.widget.js"></script>
    <script src="../jquery/ui/jquery.ui.datepicker.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="../css/estilo_admin2.css">
    <?php include("comprobar_acceso.php") ?>
    <?php include("../conectar.php") ?>
    <script>
    $(function() {
        $( "#fecha_inicio" ).datepicker({dateFormat: "yy-mm-dd"});
        $( "#fecha_fin" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    // Traducción al español
    $(function($){
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        weekHeader: 'Sm',
        firstDay: 1,

        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
    });
    </script>

    <title></title>
</head>
<body>
<div id="contenedor">
    <header id="cabecera_pri">
        <nav id="menu_pri">
        <?php
        include("menu_admin.php");
                include("download_xls.php");
         ?>
        </nav>
    </header>
        <section id="seccion_pri">
            <article>
            <form method="GET">
                Fecha inicio: <input type="text" name="fecha_inicio" autocomplete="off" id="fecha_inicio">
                Fecha Fin: <input type="text" name="fecha_fin" autocomplete="off" id="fecha_fin">
                Productor: <select name="id_productor" id="id_productor">
                        <option value="vacio" selected="selected">Todos</option>
                     <?php
                         $idproductor=mysqli_query($con,"select distinct(id_productor),nombre,apellidos from productor");
                         if($idproductor==true){
                        while ($celda = mysqli_fetch_array($idproductor,MYSQLI_ASSOC)) {
                         echo"<option value=$celda[id_productor]>".$celda['nombre']." ".$celda['apellidos']."</option>";
                     } }?>
                 </select>
                 Nº pedido:<input type="text" name="num_pedido" id="num_pedido" value="0">
                <input type="submit" value="Buscar">
            </form>
                              <?php
                              if(array_key_exists('download', $_POST)) {
                                downloadXls();
                  }
                              ?>
                              <form method="post">
                              <input type="submit" name="download" class="button" value="DescargaXML" />
                              </form>
            </article>
            <article>
            <?php
                if (isset($_GET['fecha_inicio'])and isset($_GET['fecha_fin']) and $_GET['fecha_fin']!=null and $_GET['id_productor']=='vacio'){
                $fecha_inicio=$_GET['fecha_inicio'];
                $fecha_fin=$_GET['fecha_fin'];
                if ($fecha_inicio<=$fecha_fin) {
                    $pedidos=mysqli_query($con,"
                SELECT
                    s.id_socio AS id_socio,
                    c.id_cabecera_pedido,
                    v.id_productor,
                    s.nombre AS nombre,
                    s.apellidos,
                    DATE_FORMAT(c.fecha, '%d-%m-%Y %T') AS fecha,
                    p.cantidad,
                    v.precio,
                    pr.nombre AS producto
                FROM
                    socio AS s
                JOIN
                    cabecera_pedido AS c ON s.id_socio = c.id_socio
                JOIN
                    pedido AS p ON c.id_cabecera_pedido = p.id_cabecera_pedido
                JOIN
                    vende AS v ON p.id_vende = v.id_vende
                JOIN
                    producto AS pr ON pr.id_producto = v.id_producto
                WHERE
                    c.fecha BETWEEN '$fecha_inicio' AND DATE_ADD('$fecha_fin', INTERVAL 1 DAY)
                GROUP BY
                    c.id_cabecera_pedido,
                    pr.id_producto;
                ");
                    $total=mysqli_query($con,"
                SELECT
                    SUM(p.cantidad) AS sum_cant,
                    pr.nombre AS prod_nom
                FROM
                    socio AS s
                JOIN
                    cabecera_pedido AS c ON s.id_socio = c.id_socio
                JOIN
                    pedido AS p ON c.id_cabecera_pedido = p.id_cabecera_pedido
                JOIN
                    vende AS v ON p.id_vende = v.id_vende
                JOIN
                    producto AS pr ON pr.id_producto = v.id_producto
                WHERE
                    c.fecha BETWEEN '$fecha_inicio' AND DATE_ADD('$fecha_fin', INTERVAL 1 DAY)
                GROUP BY
                    pr.id_producto;
                ");
                echo"<table id='tabla' class='display'>";
                echo"<thead>";
                echo"<tr>";
                    echo"<th>Socio</th>";
                    echo"<th>Producto</th>";
                    echo"<th>Cantidad</th>";
                    echo"<th>Precio</th>";
                    echo"<th>Fecha</th>";
                    echo"<th>Nº Pedido</th>";
                    echo"<th>Precio total de pedido</th>";
                echo"</tr>";
                echo"</thead>";
                $total_pedido = 0;
                $pedido = NULL;
                while ($fila = mysqli_fetch_array($pedidos,MYSQLI_ASSOC)){
                echo"<tr>";
                    echo"<td>$fila[nombre] $fila[apellidos]</td>";
                    echo"<td>$fila[producto]</td>";
                    echo"<td>$fila[cantidad]</td>";
                    echo"<td>$fila[precio]</td>";
                    echo"<td>$fila[fecha]</td>";
                    echo"<td>$fila[id_cabecera_pedido]</td>";
                    if (is_null($pedido)==true){
                                           $pedido=$fila['id_cabecera_pedido'];
                                           $total_pedido = $fila['precio']*$fila['cantidad'];
                                           echo"<td>$total_pedido</td>";
                    }elseif ($pedido==$fila['id_cabecera_pedido']){
                                           $total_pedido += $fila['precio']*$fila['cantidad'];
                                           echo"<td>$total_pedido</td>";
                                        }elseif ($pedido!=$fila['id_cabecera_pedido']){
                                           $total_pedido = 0;
                       $total_pedido = $fila['precio']*$fila['cantidad'];
                                           $pedido=$fila['id_cabecera_pedido'];
                                           echo"<td>$total_pedido</td>";
                                        }
                echo"</tr>";
                    }
                echo"</table>";
                echo "<br />";
                echo"<table id='tabla_ped_tot'>";
                echo"<th>TOTALES</th>";
                echo"<tr>";
                    echo"<th>Producto</th>";
                    echo"<th>Cantidad</th>";
                echo"</tr>";
                while ($fila1 = mysqli_fetch_array($total,MYSQLI_ASSOC)){
                echo"<tr>";
                    echo"<td>$fila1[prod_nom]</td>";
                    echo"<td>$fila1[sum_cant]</td>";
                echo"</tr>";
                }
                echo"</table>";
                }else{echo"<span id='error_fecha'>Introduce correctamente las fechas!</span>";}

                }
                if (isset($_GET['fecha_inicio']) and isset($_GET['fecha_fin']) and $_GET['id_productor']!='vacio'){
                $fecha_inicio=$_GET['fecha_inicio'];
                $fecha_fin=$_GET['fecha_fin'];
                $id_productor=$_GET['id_productor'];
                if ($fecha_inicio<=$fecha_fin) {
                    $pedidos=mysqli_query($con,"
                SELECT
                    s.id_socio AS id_socio,
                    c.id_cabecera_pedido,
                    v.id_productor,
                    s.nombre AS nombre,
                    s.apellidos,
                    DATE_FORMAT(c.fecha, '%d-%m-%Y %T') AS fecha,
                    p.cantidad,
                    v.precio,
                    pr.nombre AS producto
                FROM
                    socio AS s
                JOIN
                    cabecera_pedido AS c ON s.id_socio = c.id_socio
                JOIN
                    pedido AS p ON c.id_cabecera_pedido = p.id_cabecera_pedido
                JOIN
                    vende AS v ON p.id_vende = v.id_vende
                JOIN
                    producto AS pr ON pr.id_producto = v.id_producto
                WHERE
                    v.id_productor = '$id_productor'
                    AND c.fecha BETWEEN '$fecha_inicio' AND DATE_ADD('$fecha_fin', INTERVAL 1 DAY);
                ");
                    $total=mysqli_query($con,"
                SELECT
                    SUM(p.cantidad) AS sum_cant,
                    pr.nombre AS prod_nom
                FROM
                    socio AS s
                JOIN
                    cabecera_pedido AS c ON s.id_socio = c.id_socio
                JOIN
                    pedido AS p ON c.id_cabecera_pedido = p.id_cabecera_pedido
                JOIN
                    vende AS v ON p.id_vende = v.id_vende
                JOIN
                    producto AS pr ON pr.id_producto = v.id_producto
                WHERE
                    v.id_productor = '$id_productor'
                    AND c.fecha BETWEEN '$fecha_inicio' AND DATE_ADD('$fecha_fin', INTERVAL 1 DAY)
                GROUP BY
                    pr.id_producto;
                ");
                echo"<table id='tabla'>";
                echo"<tr>";
                    echo"<th>Socio</th>";
                    echo"<th>Producto</th>";
                    echo"<th>Cantidad</th>";
                    echo"<th>Precio</th>";
                    echo"<th>Fecha</th>";
                    echo"<th>Nº Pedido</th>";
                    echo"<th>Precio total de pedido</th>";
                echo"</tr>";
                while ($fila = mysqli_fetch_array($pedidos,MYSQLI_ASSOC)){
                echo"<tr>";
                    echo"<td>$fila[nombre] $fila[apellidos]</td>";
                    echo"<td>$fila[producto]</td>";
                    echo"<td>$fila[cantidad]</td>";
                    echo"<td>$fila[precio]</td>";
                    echo"<td>$fila[fecha]</td>";
                    echo"<td>$fila[id_cabecera_pedido]</td>";
                    if (is_null($pedido)==true){
                                           $pedido=$fila['id_cabecera_pedido'];
                                           $total_pedido = $fila['precio']*$fila['cantidad'];
                                           echo"<td>$total_pedido</td>";
                    }elseif ($pedido==$fila['id_cabecera_pedido']){
                                           $total_pedido += $fila['precio']*$fila['cantidad'];
                                           echo"<td>$total_pedido</td>";
                                        }elseif ($pedido!=$fila['id_cabecera_pedido']){
                                           $total_pedido = 0;
                       $total_pedido = $fila['precio']*$fila['cantidad'];
                                           $pedido=$fila['id_cabecera_pedido'];
                                           echo"<td>$total_pedido</td>";
                                        }
                echo"</tr>";
                    }
                echo"</table>";
                echo "<br />";
                echo"<table id='tabla_ped_tot'>";
                echo"<th>TOTALES</th>";
                echo"<tr>";
                    echo"<th>Producto</th>";
                    echo"<th>Cantidad</th>";
                echo"</tr>";
                while ($fila1 = mysqli_fetch_array($total,MYSQLI_ASSOC)){
                echo"<tr>";
                    echo"<td>$fila1[prod_nom]</td>";
                    echo"<td>$fila1[sum_cant]</td>";
                echo"</tr>";
                }
                echo"</table>";
                }else{echo"<span id='error_fecha'>Introduce correctamente las fechas!</span>";}

                }
                if (isset($_GET['num_pedido']) and is_numeric($_GET['num_pedido']) and $_GET['num_pedido']!=0) {
                    $num_pedido=$_GET['num_pedido'];
                    $pedidos=mysqli_query($con,"
                SELECT
                    s.id_socio AS id_socio,
                    c.id_cabecera_pedido,
                    v.id_productor,
                    s.nombre AS nombre,
                    s.apellidos,
                    DATE_FORMAT(c.fecha, '%d-%m-%Y %T') AS fecha,
                    p.cantidad,
                    v.precio,
                    pr.nombre AS producto
                FROM
                    socio AS s
                JOIN
                    cabecera_pedido AS c ON s.id_socio = c.id_socio
                JOIN
                    pedido AS p ON c.id_cabecera_pedido = p.id_cabecera_pedido
                JOIN
                    vende AS v ON p.id_vende = v.id_vende
                JOIN
                    producto AS pr ON pr.id_producto = v.id_producto
                WHERE
                    c.id_cabecera_pedido = $num_pedido
                GROUP BY
                    pr.id_producto;
                ");
                    $total=mysqli_query($con,"
                SELECT
                    SUM(p.cantidad) AS sum_cant,
                    pr.nombre AS prod_nom
                FROM
                    socio AS s
                JOIN
                    cabecera_pedido AS c ON s.id_socio = c.id_socio
                JOIN
                    pedido AS p ON c.id_cabecera_pedido = p.id_cabecera_pedido
                JOIN
                    vende AS v ON p.id_vende = v.id_vende
                JOIN
                    producto AS pr ON pr.id_producto = v.id_producto
                WHERE
                    c.id_cabecera_pedido = $num_pedido
                GROUP BY
                    pr.id_producto;
                ");
                echo"<table id='tabla'>";
                echo"<tr>";
                    echo"<th>Socio</th>";
                    echo"<th>Producto</th>";
                    echo"<th>Cantidad</th>";
                    echo"<th>Precio</th>";
                    echo"<th>Fecha</th>";
                    echo"<th>Nº Pedido</th>";
                    echo"<th>Precio total de pedido</th>";
                echo"</tr>";
                while ($fila = mysqli_fetch_array($pedidos,MYSQLI_ASSOC)){
                echo"<tr>";
                    echo"<td>$fila[nombre] $fila[apellidos]</td>";
                    echo"<td>$fila[producto]</td>";
                    echo"<td>$fila[cantidad]</td>";
                    echo"<td>$fila[precio]</td>";
                    echo"<td>$fila[fecha]</td>";
                    echo"<td>$fila[id_cabecera_pedido]</td>";
                    if (is_null($pedido)==true){
                                           $pedido=$fila['id_cabecera_pedido'];
                                           $total_pedido = $fila['precio']*$fila['cantidad'];
                                           echo"<td>$total_pedido</td>";
                    }elseif ($pedido==$fila['id_cabecera_pedido']){
                                           $total_pedido += $fila['precio']*$fila['cantidad'];
                                           echo"<td>$total_pedido</td>";
                                        }elseif ($pedido!=$fila['id_cabecera_pedido']){
                                           $total_pedido = 0;
                       $total_pedido = $fila['precio']*$fila['cantidad'];
                                           $pedido=$fila['id_cabecera_pedido'];
                                           echo"<td>$total_pedido</td>";
                                        }
                echo"</tr>";
                    }
                echo"</table>";
                echo "<br />";
                echo"<table id='tabla_ped_tot'>";
                echo"<th>TOTALES</th>";
                echo"<tr>";
                    echo"<th>Producto</th>";
                    echo"<th>Cantidad</th>";
                echo"</tr>";
                while ($fila1 = mysqli_fetch_array($total,MYSQLI_ASSOC)){
                echo"<tr>";
                    echo"<td>$fila1[prod_nom]</td>";
                    echo"<td>$fila1[sum_cant]</td>";
                echo"</tr>";
                }
                echo"</table>";
                }

            ?>

         </article>
        </section>
    <aside id="menu_col">

    </aside>
    <footer id="pie"><?php include("../pie.php"); ?></footer>
</div>
    <script>
    $(document).ready(function () {
        $('#tabla').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ entradas por página",
                "zeroRecords": "No se encontraron registros",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "previous": "Anterior",
                    "next": "Siguiente",
                    "last": "Último"
                }
            }
        });
    });
    </script>
</body>
</html>
