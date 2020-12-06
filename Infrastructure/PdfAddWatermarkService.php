<?php

include_once( dirname(__FILE__) . '/CoordinatesCalculatorService.php');
include_once( dirname(__FILE__) . '/../../Domain/ObjectModel/Coordinates.php');
include_once( dirname(__FILE__) . '/../../Domain/Watermark.php');
include_once( dirname(__FILE__) . '/../../Domain/Interfaces/PdfAddWatermarkServiceInterface.php');

class PdfAddWatermarkService implements PdfAddWatermarkServiceInterface {
	
	private const WATERMARK_RESOLUTION = -96;
	private CoordinatesCalculatorService $coordinatesService;
	private Watermark $watermark;

    public function __construct (Watermark $watermark) {
		$this->coordinatesService = new CoordinatesCalculatorService($this->pdfInstance);
		$this->watermark = $watermark;
    }

    public function execute (Document &$document, int $pageNumber) : void {
		$templateId = $this->pdfInstance->importPage($pageNumber);
		$watermarkCoords = $this->coordinatesService->execute($this->watermark, $templateId);

		if ( $this->watermark->usedAsBackground() ) {															
			$this->addWatermarkAsBackGround($templateId, $watermarkCoords, $document);
		}
		else {
			$this->addWatermarkAsForeground($templateId, $watermarkCoords, $document);
		}
	}
	
	private function addWatermarkAsBackground(string $templateId, Coordinates $watermarkCoordinates, Document &$document) : void {
		$document->pdfInstance->Image($this->watermark->getFilePath(),$watermarkCoordinates->getX(),$watermarkCoordinates->getY(),self::WATERMARK_RESOLUTION);
		$document->pdfInstance->useTemplate($templateId);
	}

	private function addWatermarkAsForeground(string $templateId, Coordinates $watermarkCoordinates, Document &$document) : void {
		$document->pdfInstance->useTemplate($templateId);
		$document->pdfInstance->Image($this->watermark->getFilePath(),$watermarkCoordinates->getX(),$watermarkCoordinates->getY(),self::WATERMARK_RESOLUTION);
	}
}