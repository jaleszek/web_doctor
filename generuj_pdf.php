<?php 
require_once('html2pdf/html2fpdf.php'); 
ob_start(); 
include_once('pdf_temp.html'); 
$htmlbuffer = ob_get_contents(); 
ob_end_clean(); 
$pdf = new HTML2FPDF('P','mm','A4');  
$pdf->AddPage(); 
$pdf->UseCSS(true);  
$htmlbuffer = iconv("UTF-8", "ISO8859-2", $htmlbuffer); 

$pdf->WriteHTML($htmlbuffer); 
$data = date('j F Y, G:i');
$pdf->Output("file".$data.".pdf", "F"); 
$pdf->Output("file".$data.".pdf", "D"); 

?> 