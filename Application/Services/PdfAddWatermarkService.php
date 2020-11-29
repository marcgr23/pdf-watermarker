<?php

include_once( dirname(__FILE__) . '/CoordinatesCalculatorService.php');
include_once( dirname(__FILE__) . '/../../Domain/ObjectModel/WatermarkCoordinates.php');
include_once( dirname(__FILE__) . '/../../Domain/Watermark.php');
include_once( dirname(__FILE__) . '/../../Domain/Interfaces/PdfAddWatermarkServiceInterface.php');

use \setasign\Fpdi\Fpdi;

class PdfAddWatermarkService implements PdfAddWatermarkServiceInterface {
	
	private const WATERMARK_RESOLUTION = -96;
    private Fpdi $pdfInstance;
	private CoordinatesCalculatorService $coordinatesService;
	private Watermark $watermark;

    public function __construct (Fpdi &$pdfInstance, Watermark $watermark) {
        $this->pdfInstance = $pdfInstance;
		$this->coordinatesService = new CoordinatesCalculatorService($this->pdfInstance); //DEBATIBLE
		$this->watermark = $watermark;
    }

    public function execute (int $pageNumber) : void {
		$templateId = $this->pdfInstance->importPage($pageNumber);
		$watermarkCoords = $this->coordinatesService->execute($this->watermark, $templateId);

		if ( $this->watermark->usedAsBackground() ) {															
			$this->addWatermarkAsBackGround($templateId, $watermarkCoords);
		}
		else {
			$this->addWatermarkAsForeground($templateId, $watermarkCoords);
		}
	}
	
	private function addWatermarkAsBackground(string $templateId, WatermarkCoordinates $watermarkCoordinates) : void {
		$this->pdfInstance->Image($this->watermark->getFilePath(),$watermarkCoordinates->getX(),$watermarkCoordinates->getY(),self::WATERMARK_RESOLUTION);
		$this->pdfInstance->useTemplate($templateId);
	}

	private function addWatermarkAsForeground(string $templateId, WatermarkCoordinates $watermarkCoordinates) : void {
		$this->pdfInstance->useTemplate($templateId);
		$this->pdfInstance->Image($this->watermark->getFilePath(),$watermarkCoordinates->getX(),$watermarkCoordinates->getY(),self::WATERMARK_RESOLUTION);
	}
}