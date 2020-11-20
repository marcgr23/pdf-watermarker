<?php

include './CoordinatesCalculatorService.php';

class AddWatermarkService {

    private $pdfInstance;
    private $coordinatesService;

    public function __construct ($pdfInstance) {
        $this->pdfInstance = $pdfInstance;
		// $this->coordinatesService = new CoordinatesCalculatorService($this->pdfInstance);
    }

    public function addWatermark ($watermark,  int $pageNumber,  bool $watermark_visible = true) {
		$templateId = $this->pdfInstance->importPage($pageNumber);
		$templateDimension = $this->pdfInstance->getTempdlateSize($templateId);
		$watermarkCoords = $watermark->getCoordinates($templateDimension);
				
		if ( $watermark_visible ) {
			if ( $this->_watermark->usedAsBackground() ) {															
				$this->pdfInstance->Image($this->_watermark->getFilePath(),$watermarkCoords[0],$watermarkCoords[1],-96);
				$this->pdfInstance->useTemplate($templateId);
			}
			else {
				$this->pdfInstance->useTemplate($templateId);
				$this->pdfInstance->Image($this->_watermark->getFilePath(),$watermarkCoords[0],$watermarkCoords[1],-96);
			}
		}
		else {
			$this->pdfInstance->useTemplate($templateId);
		}
    }
}