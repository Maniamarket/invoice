<?php

/**
 * @copyright Copyright &copy;2014 Giandomenico Olini
 * @company Gogodigital - Wide ICT Solutions 
 * @website http://www.gogodigital.it
 * @package yii2-tcpdf
 * @github https://github.com/cinghie/yii2-tcpdf
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @tcpdf library 6.0.075
 * @tcpdf documentation http://www.tcpdf.org/docs.php
 * @tcpdf examples http://www.tcpdf.org/examples.php
 */
// http://www.ibm.com/developerworks/ru/library/os-tcpdf/index.html
const K_PATH_IMAGES = 'images/';
// Load Component Yii2 TCPDF 
\Yii::$app->get('tcpdf');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Gogogital.it');
$pdf->SetTitle('Yii2 TCPDF Example');
$pdf->SetSubject('Yii2 TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Invoice in Pdf', 'Test Page', array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
//$html = "<h1>Yii2 TCPDF Works Fine!</h1>";
// логотип компании
if (!empty($model->company->logo)) {
    $logo = 'images/companies/'.$model->company->logo;
    $pdf->Image($logo, '15', '25', '20', '0', '', '', '', true, 150);
}
//echo $logo;
$html = $this->context->renderPartial('/invoice/template/'.$template, ['model' => $model, 'isTranslit'=>$isTranslit]);

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

if(empty($model->is_pay)) {
// ---------------------------------------------------------

    $ImageW = 180; //WaterMark Size
    $ImageH = 180;

    $pdf->setPage( 1 ); //WaterMark Page

    $myPageWidth = $pdf->getPageWidth();
    $myPageHeight = $pdf->getPageHeight();
    $myX = ( $myPageWidth / 2 ) - 90;  //WaterMark Positioning
    $myY = ( $myPageHeight / 2 ) -90;

    $pdf->SetAlpha(0.29);
    $pdf->Image(K_PATH_IMAGES.'xmark.png', $myX, $myY, $ImageW, $ImageH, '', '', '', true, 150);

    /*$pdf->setPage( 2 );

    $myPageWidth = $pdf->getPageWidth();
    $myPageHeight = $pdf->getPageHeight();
    $myX = ( $myPageWidth / 2 ) - 50;
    $myY = ( $myPageHeight / 2 ) -40;

    $pdf->SetAlpha(0.09);
    $pdf->Image(K_PATH_IMAGES.'xmark.png', $myX, $myY, $ImageW, $ImageH, '', '', '', true, 150);*/

    //Likewise can be added for all pages after writing all pages.

    $pdf->SetAlpha(1); //Reset Alpha Setings
}
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('yii2_tcpdf_example.pdf', 'I');

/*$js = 'print(true);';
$pdf->IncludeJS($js);
$pdf->Output($pdffile, 'F');*/


//============================================================+
// END OF FILE
//============================================================+

// Close Yii2
\Yii::$app->end();

?>