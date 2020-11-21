<?php

include 'Domain/Pdf.php';
include './AddWatermarkService.php';
include './AddWatermarkInvisibleService.php';
include './CoordinatesCalculatorService.php';

class DocumentController {
	
	// private AddWatermarkServiceInterface $watermarkService;
	private DocumentHandlerInterface $document;
	
	public function __construct(
								// string $originalPdf, 
								// string $newPdf, 
								DocumentHandlerInterface $document
								// AddWatermarkServiceInterface $addWatermarkService
								) {
		
		$this->document = $document;
		// $this->documentPathHandler = new DocumentPathHandler($originalPdf, $newPdf);

		//SE NECESITA UN ELEMENTO QUE NOS PERMITA CONSTRUIR NUESTRAS INSTANCIAS DE TIPO 
		//DocumentHandlerInterface

		$this->validateAssets();
	}
	
	private function validateAssets(): void {
		if ( !file_exists( $this->originalPdf ) ) {
			throw new Exception("Inputted PDF file doesn't exist"); 
		}
		else if ( !file_exists( $this->watermark->getFilePath() ) ) {
			throw new Exception("Watermark doesn't exist.");
		}
	}
	
	public function applyWatermarksToDocument(): void {
		
		$this->document->applyWatermarksToDocument();
	}
	
	public function setPageRange(int $startPage=1, int $endPage=null) : void {
		
		$this->document->setPageRangesToDocument($startPage, $endPage);
	}
	
	public function saveDocument() : void {
		
		$this->document->saveChangesToDocument();
	}
}
?>
