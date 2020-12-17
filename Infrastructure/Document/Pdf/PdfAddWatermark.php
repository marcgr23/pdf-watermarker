<?php

include_once( dirname(__FILE__) . '/../../../Domain/Coordinates/CoordinatesCalculator.php');
include_once( dirname(__FILE__) . '/../../../Domain/ObjectModel/Document/Document.php');
include_once( dirname(__FILE__) . '/../../../Domain/ObjectModel/Document/Watermark.php');

class PdfAddWatermark implements AddWatermarkInterface {
	
	private const WATERMARK_RESOLUTION = -96;
	private CoordinatesCalculatorInterface $coordinatesService;
	private Watermark $watermark;

	public function __construct (Watermark $watermark,
								 CoordinatesCalculatorInterface $coordinatesService) {
		$this->coordinatesService = $coordinatesService;
		$this->watermark = $watermark;
    }

    public function execute (Document &$document, DocumentPage $page) : void {
		$templateId = $document->pdfInstance->importPage($page->getPageNumber());
		$watermarkCoords = $this->coordinatesService->execute($this->watermark, $templateId, $document);

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