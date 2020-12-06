<?php

include_once( dirname(__FILE__) . '/../../Domain/Interfaces/PdfAddWatermarkServiceInterface.php');

class PdfAddWatermarkInvisibleService implements PdfAddWatermarkServiceInterface {
    // public function __construct () {
    //     $this->pdfInstance = $pdfInstance;
    // }

    public function execute (Document &$document, int $pageNumber) : void {
		$templateId = $this->pdfInstance->importPage($pageNumber);
		$this->pdfInstance->useTemplate($templateId);
	}
}