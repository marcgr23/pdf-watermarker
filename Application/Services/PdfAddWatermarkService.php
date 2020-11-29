<?php

include './CoordinatesCalculatorService.php';
include '../../Domain/ObjectModel/WatermarkCoordinates.php';
include '../../Domain/Watermark.php';

class PdfAddWatermarkService implements PdfAddWatermarkServiceInterface {
	
	private const WATERMARK_RESOLUTION = -96;
    private FPDI $pdfInstance;
	private CoordinatesCalculatorService $coordinatesService;
	private Watermark $watermark;

    public function __construct (FPDI &$pdfInstance, Watermark $watermark) {
        $this->pdfInstance = $pdfInstance;
		$this->coordinatesService = new CoordinatesCalculatorService($this->pdfInstance); //DEBATIBLE
		$this->watermark = $watermark;
    }

    public function execute (int $pageNumber) : void {
		$templateId = $this->pdfInstance->importPage($pageNumber);
		$templateDimension = $this->pdfInstance->getTemplateSize($templateId);
		$watermarkCoords = $this->coordinatesService->execute($this->watermark, $templateDimension);

		if ( $this->watermark->usedAsBackground() ) {															
			$this->addWatermarkAsBackGround($templateId, $watermarkCoords);
		}
		else {
			$this->addWatermarkAsForeground($templateId, $watermarkCoords);
		}
	}
	
	private function addWatermarkAsBackground(int $templateId, WatermarkCoordinates $watermarkCoordinates) : void {
		$this->pdfInstance->Image($this->watermark->getFilePath(),$watermarkCoordinates->getX(),$watermarkCoordinates->getY(),self::WATERMARK_RESOLUTION);
		$this->pdfInstance->useTemplate($templateId);
	}

	private function addWatermarkAsForeground(int $templateId, WatermarkCoordinates $watermarkCoordinates) : void {
		$this->pdfInstance->useTemplate($templateId);
		$this->pdfInstance->Image($this->watermark->getFilePath(),$watermarkCoordinates->getX(),$watermarkCoordinates->getY(),self::WATERMARK_RESOLUTION);
	}
}