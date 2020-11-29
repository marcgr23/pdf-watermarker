<?php

include './CoordinatesCalculatorService.php';

class PdfAddWatermarkInvisibleService implements PdfAddWatermarkServiceInterface {
    private FPDI $pdfInstance;

    public function __construct (FPDI &$pdfInstance) {
        $this->pdfInstance = $pdfInstance;
    }

    public function execute (int $pageNumber) : void {
		$templateId = $this->pdfInstance->importPage($pageNumber);
		$this->pdfInstance->useTemplate($templateId);
	}
}