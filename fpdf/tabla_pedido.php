<?php
require('fpdf.php');
class PDF extends FPDF
{

// Cabecera de página
function Header()
{
    // Logo
   // $this->Image('logo_pb.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',18);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'Pedido Arco',0,'C');
    // Salto de línea
    $this->Ln(20);
}

function SocioFecha($fecha_socio)
{
    // Arial 12
    $this->SetFont('Arial','',12);
    // Color de fondo

    // Socio y fecha
  
    $this->Cell(30,6,'Nombre Socio: '.utf8_decode($fecha_socio['nombre'])." ".utf8_decode($fecha_socio['apellidos']),0);
    $this->Ln();
    $this->Cell(30,6,'Fecha pedido: '.$fecha_socio['fecha'],0);
    $this->Ln();
    $this->Cell(30,6,'Nº de pedido: '.$fecha_socio['id_cabecera_pedido'],0);
    // Salto de línea
    $this->Ln(15);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Plataforma ArcoPalencia desarrollado por Alberto Rasillo email: alberto.rasillo@gmail.com',0,0,'C');
}

// Tabla simple
function BasicTable($header, $data, $total_pro)
{
	// Cabecera
	foreach($header as $col)
	//Texto de las columnas
    $this->Cell(38,7,$col,1);
	$this->Ln();
	// Datos
       $this->SetFont('Arial','',10);
	   foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(38,6,utf8_decode($col),1);
        $this->Ln();
    }
    $this->Ln();
    $this->Cell(38,6,"Subtotal:",1);
    $this->Cell(38,6,$total_pro.' €',1);

	
}
}
$pdf = new PDF();
// Títulos de las columnas
$header = array('Producto', 'Cantidad', 'Precio', 'Prod. Nom.', 'Prod. Ape.');
// Carga de datos
$fechasocio= unserialize($_GET['fecha_socio_ped']);
$fecha_socio=$fechasocio;
$pedido = unserialize($_GET['pedido']);
$total_pro = unserialize($_GET['total_pro']);
$data = $pedido;
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->SocioFecha($fecha_socio);
$pdf->BasicTable($header,$data,$total_pro);
$pdf->Output();
/*$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,$texto);*/
?>
