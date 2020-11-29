<?php

include_once( dirname(__FILE__) . '/../../Domain/Interfaces/PdfAddWatermarkServiceInterface.php');

use \setasign\Fpdi\Fpdi;

class PdfAddWatermarkInvisibleService implements PdfAddWatermarkServiceInterface {
    private Fpdi $pdfInstance;

    public function __construct (Fpdi &$pdfInstance) {
        $this->pdfInstance = $pdfInstance;
    }

    public function execute (int $pageNumber) : void {
		$templateId = $this->pdfInstance->importPage($pageNumber);
		$this->pdfInstance->useTemplate($templateId);
	}
}