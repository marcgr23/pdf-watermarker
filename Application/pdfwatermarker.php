<?php

/**
 * pdfwatermarker.php
 * 
 * This class applies PDFWatermark to the file
 * @author Binarystash <binarystash01@gmail.com>
 * @version 1.1.1
 * @license https://opensource.org/licenses/MIT MIT
 */

include 'Domain/Pdf.php';
include './AddWatermarkService.php';
include './CoordinatesCalculatorService.php';

class PDFWatermarker {
	
	private $_originalPdf;
	private $_newPdf;
	private $pdf;
	private $_watermark;
	private $_specificPages;
	private $watermarkService;
	
	public function __construct($originalPdf,$newPdf,$watermark) {
		$this->_originalPdf = $originalPdf;
		$this->_newPdf = $newPdf;
		$this->_tempPdf = new FPDI();
		$this->pdf = new Pdf($originalPdf, $newPdf);
		$this->_watermark = $watermark;
		$this->_specificPages = array();
		$this->watermarkService = new AddWatermarkService($this->_tempPdf);
		
		$this->validateAssets();
	}
	
	private function validateAssets(): void {
		
		if ( !file_exists( $this->_originalPdf ) ) {
			throw new Exception("Inputted PDF file doesn't exist"); 
		}
		else if ( !file_exists( $this->_watermark->getFilePath() ) ) {
			//According to the "Tell Don't Ask principle", method calls like
			//this one should return directly if the watermark file exists instead
			//of the path of the file associated to the watermark
			throw new Exception("Watermark doesn't exist.");
		}
		
	}
	
	private function updatePDF(): void {
		
		$totalPages = $this->pdf->getTotalPages();
		
		for($ctr = 1; $ctr <= $totalPages; $ctr++){
			
			$this->pdf->importPage($ctr);
			
			if ( in_array($ctr, $this->_specificPages ) || empty( $this->_specificPages ) ) {
				$this->watermarkPage($ctr);
			}
			else {
				$this->watermarkPage($ctr, false);
			}
		}
	}
	
	//AddWhatermarkService (FPDI, whatermark)
	//WatermarkCoordinatesS

	// private function watermarkPage($page_number, $watermark_visible = true): void {
		
	// 	$templateId = $this->pdf->importPage($page_number);
	// 	$templateDimension = $this->pdf->getTemplateSize($templateId);
		
	// 	$wWidth = $this->_watermark->getWidth(); //in mm
	// 	$wHeight = $this->_watermark->getHeight(); //in mm
		
	// 	$watermarkCoords = $this->calculateWatermarkCoordinates( 	$wWidth, 
	// 																$wHeight, 
	// 																$templateDimension);
							
	// 	if ( $watermark_visible ) {
	// 		if ( $this->_watermark->usedAsBackground() ) {															
	// 			$this->pdf->Image($this->_watermark->getFilePath(),$watermarkCoords[0],$watermarkCoords[1],-96);
	// 			$this->pdf->useTemplate($templateId);
	// 		}
	// 		else {
	// 			$this->pdf->useTemplate($templateId);
	// 			$this->pdf->Image($this->_watermark->getFilePath(),$watermarkCoords[0],$watermarkCoords[1],-96);
	// 		}
	// 	}
	// 	else {
	// 		$this->pdf->useTemplate($templateId);
	// 	}
	// }
	
	// private function calculateWatermarkCoordinates( $wWidth, $wHeight, $templateDimension ): array {
	// 	//One possible improvement would be adding a system for using relative coordinates
	// 	//with percentages for x and y instead of fixed positions
	// 	switch( $this->_watermark->getPosition() ) {
	// 		case 'topleft': 
	// 			$x = 0;
	// 			$y = 0;
	// 			break;
	// 		case 'topright':
	// 			$x = $templateDimension['w'] - $wWidth;
	// 			$y = 0;
	// 			break;
	// 		case 'bottomright':
	// 			$x = $templateDimension['w'] - $wWidth;
	// 			$y = $templateDimension['h'] - $wHeight;
	// 			break;
	// 		case 'bottomleft':
	// 			$x = 0;
	// 			$y = $templateDimension['h'] - $wHeight;
	// 			break;
	// 		default:
	// 			$x = ( $templateDimension['w'] - $wWidth ) / 2 ;
	// 			$y = ( $templateDimension['h'] - $wHeight ) / 2 ;
	// 			break;
	// 	}
		
	// 	return array($x,$y);
	// }
	
	public function setPageRange($startPage=1, $endPage=null) {
		
		$end = $endPage !== null ? $endPage : $this->pdf->getTotalPages();
		
		$this->_specificPages = array();
		
		for ($ctr = $startPage; $ctr <= $end; $ctr++ ) {
			$this->_specificPages[] = $ctr;
		}
	}
	
	public function savePdf() {
		$this->updatePDF();
		$this->_tempPdf->Output("F",$this->_newPdf);
		
	}
}
?>
