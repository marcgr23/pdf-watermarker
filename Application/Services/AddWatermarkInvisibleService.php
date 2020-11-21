<?php

include './CoordinatesCalculatorService.php';

class AddWatermarkInvisibleService {

    private PDFI $pdfInstance;

    public function __construct (PDFI $pdfInstance) {
        $this->pdfInstance = $pdfInstance;
    }

    public function execute (int $pageNumber) {
		$templateId = $this->pdfInstance->importPage($pageNumber);
		$this->pdfInstance->useTemplate($templateId);
	}
}