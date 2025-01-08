<?PHP
  function cleanData(&$str)
    {
     $str = preg_replace("/\t/", "\\t", $str);
     $str = preg_replace("/\r?\n/", "\\n", $str);
     if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
  if (array_key_exists('download', $_POST)) {
      downloadXls();
  }
  function downloadXls()
    {
    // Verificamos si hemos recibido datos en base64
    if (isset($_POST['table_data'])) {
        // Decodificamos el contenido base64
        $decodedData = base64_decode($_POST['table_data']);

        // Archivo para la descarga
        $filename = "arcopalencia_" . date('YmdHis') . ".xls";

        // Cabeceras para la descarga de archivo XLS
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");

        // Enviamos el contenido decodificado
        echo $decodedData;
    } else {
        echo "No se recibió contenido de las tablas.";
    }

    exit;
    }
?>
