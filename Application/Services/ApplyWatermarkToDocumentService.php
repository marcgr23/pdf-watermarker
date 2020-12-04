<?php

include_once( dirname(__FILE__) . '/../../Domain/PDFDocument.php');
include_once( dirname(__FILE__) . '/GetTotalPagesFromPDFService.php');
include_once( dirname(__FILE__) . '/PdfAddWatermarkServiceInterface.php');
include_once( dirname(__FILE__) . '/AddWatermarkService.php');
include_once( dirname(__FILE__) . '/AddWatermarkInvisibleService.php');
use \setasign\Fpdi\Fpdi;

class ApplyWatermarkToDocumentService {
    private const WIDTH_COLUMN_NAME   = 'width';
    private const HEIGHT_COLUMN_NAME  = 'height';
    private const ORIENTATION_LANDSCAPE  = "L";
    private const ORIENTATION_PORTRAIT  = "P";

    private PdfAddWatermarkServiceInterface $addWatermarkService;
    private PdfAddWatermarkServiceInterface $addWatermarkInvisibleService;
    private GetTotalPagesFromPDFService $getTotalPagesFromPDF;

    public function __construct() {

        $this->addWatermarkService = new AddWatermarkService();
        $this->addWatermarkInvisibleService = new AddWatermarkInvisibleService();
        $this->getTotalPagesFromPDFService = new GetTotalPagesFromPDFService();
    }
    
    public function execute(PDFDocument &$pdfDocument) : void {
        $totalPages = $this->getTotalPagesFromPDFService->getTotalPages($pdfDocument->$pdfInstance);
		for($ctr = 1; $ctr <= $totalPages; $ctr++) {
			
			$this->importPage($ctr, $pdfDocument);
			
			if ( $pdfDocument->specificPages[$ctr-1]->isWatermarkVisible() ) {
				 $this->addWatermarkService->execute($ctr);
			}
			else {
				$this->addWatermarkInvisibleService->execute($ctr);
			}
		}
    }

    private function importPage(int $page_number, PDFDocument &$pdfDocument) : void {
		$templateId = $pdfDocument->pdfInstance->importPage($page_number);
		$templateDimension = $pdfDocument->pdfInstance->getTemplateSize($templateId);
        
		if ( $templateDimension[self::WIDTH_COLUMN_NAME] > $templateDimension[self::HEIGHT_COLUMN_NAME] ) {
			$orientation = self::ORIENTATION_LANDSCAPE;
		}
		else {
			$orientation = self::ORIENTATION_PORTRAIT;
		}
		
        $pdfDocument->pdfInstance->addPage($orientation, 
                                    array($templateDimension[self::WIDTH_COLUMN_NAME],
                                          $templateDimension[self::HEIGHT_COLUMN_NAME])
        );
	}
}