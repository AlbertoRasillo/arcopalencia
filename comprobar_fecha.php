<?php
	setlocale(LC_TIME, "es_ES");
	date_default_timezone_set('Europe/Madrid');
	//echo strftime("%A");
	//echo date("H:i:s");
	/* %w represntación númerica 0 domingo 6 sabado */
	$horariopedido=1;
	$fecha_actual = strftime("%w");
	$hora_actual = date("His");
	$horafinal = 221000; 
	$horafinal_lun = 120000;
	if ($fecha_actual=="4" or $fecha_actual=="5" 
		or $fecha_actual=="6" or $fecha_actual=="0" or $fecha_actual=="1") {
			/* Quitar comentarios si queremos que el horario pedido termine el domingo a las 22.00
			if ($fecha_actual=="0" and $hora_actual<=$horafinal) {
			}
			if ($fecha_actual=="0" and $hora_actual>=$horafinal) {
				$horariopedido=0;
			}
			*/
			/* Horario pedido termina el lunes a las 12.00 */
			if ($fecha_actual=="1" and $hora_actual<=$horafinal_lun) {
			}
			if ($fecha_actual=="1" and $hora_actual>=$horafinal_lun) {
				$horariopedido=0;
			}
	}else{ 
			$horariopedido=0;
		}
?>