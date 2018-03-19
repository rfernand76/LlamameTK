<?php
// Include the main TCPDF library (search for installation path).
require_once('../global/php-pdf/tcpdf/tcpdf.php');
require_once("../global/virtualQueueIni.php");
$cfg = VirtualQueueIni::getInstance();

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Ricardo Fernandez');
$pdf->SetTitle('icket de atención');
$pdf->SetSubject('Virtual Queue');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set margins
$LEFT = 5;
$TOP = 0;
$RIGHT = 3;
$pdf->SetMargins($LEFT, $TOP, $RIGHT);

// set font
$pdf->SetFont('times', 'BI', 12);

// add a page
$pdf->AddPage();

//parametros
$datos = $_GET["datos"];
$parametros = json_decode($datos);
$nomFila = $parametros->fil_nombre;
$numero = $parametros->inicio+1;
$cantidadReserva = $parametros->cantidadReserva;
$tokens = $parametros->tokensList;
$fil_nemo = $parametros->fil_nemo;
$seg_list = $parametros->seg_remoto;
$letra = $parametros->letra;

$tokensList = explode(":", $tokens);
$seg_remoto  = explode(":", $seg_list);

$top = 5;

$style = array(
	'border' => 2,
	'vpadding' => 'auto',
	'hpadding' => 'auto',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false, //array(255,255,255)
	'module_width' => 1, // width of a single module in points
	'module_height' => 1 // height of a single module in points
);

for($i=0; $i<$cantidadReserva; $i++){
    $txt = "$nomFila
$letra $numero
Puede utilizar el siguiente enlase para realizar seguimiento desde su smartphone
";
    
    $pdf->SetY($top);
    $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
    //$pdf->Image('../global/temp/test.png', 87, ($top+18), 35, 35, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
    
    $token = $tokensList[$i+1];
    $remoto = $seg_remoto[$i+1];
    $url = $cfg->getMobile_server_primary() . "?nemo=$fil_nemo&ut=$numero&token=$token&seg_codigo=$remoto";
    $pdf->write2DBarcode($url, 'QRCODE,Q', 87, ($top+17), 42, 42, $style, 'N');
    //$pdf->Write(0, $url, '', 0, 'C', true, 0, false, false, 0);
    
    $numero++;
    $top = $top+70;
    
    if($top > 250){
        $top = 5;
        $pdf->AddPage();
    }
}

// print a block of text using Write()

//

            
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('reserva', 'D');

//============================================================+
// END OF FILE
//============================================================+