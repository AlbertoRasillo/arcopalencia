<?PHP
  function cleanData(&$str)
    {
     $str = preg_replace("/\t/", "\\t", $str);
     $str = preg_replace("/\r?\n/", "\\n", $str);
     if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
  function downloadXls()
    {
     // filename for download
     $filename = "arcopalencia_" . date('YmdHis') . ".xls";

     header("Content-Disposition: attachment; filename=\"$filename\"");
     header("Content-Type: application/vnd.ms-excel");
    }
?>
