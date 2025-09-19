<?php
    setlocale(LC_TIME, "es_ES");
    date_default_timezone_set('Europe/Madrid');
    //echo strftime("%A");
    //echo date("H:i:s");
    /* %w represntación númerica 0 domingo 6 sabado */
    $horariopedido=1;
    $fecha_actual = strftime("%w");
    $hora_actual = date("His");
    $horafinal_vie = 120000; // Viernes hasta las 12:00 PM

    if ($fecha_actual == "2" || $fecha_actual == "3" || $fecha_actual == "4") {
        // Martes, miércoles, jueves -> pedidos habilitados todo el día
        $horariopedido = 1;
    } elseif ($fecha_actual == "5") {
        // Viernes -> hasta las 12:00 PM
        if ($hora_actual <= $horafinal_vie) {
            $horariopedido = 1;
        } else {
            $horariopedido = 0;
        }
    } else {
        // Sábado, domingo, lunes -> pedidos deshabilitados
        $horariopedido = 0;
    }
?>
