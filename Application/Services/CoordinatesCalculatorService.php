<?php

include '../../Domain/ObjectModel/WatermarkCoordinates.php';

class CoordinatesCalculatorService {
    private FPDI $pdfInstance;

    public function __construct (FPDI $pdfInstance) {
		$this->pdfInstance = $pdfInstance;
    }

    public function execute($watermark, $templateId) : WatermarkCoordinates {
		$templateDimension = $this->pdfInstance->getTempdlateSize($templateId);
		$wWidth = $watermark->getWidth();
		$wHeight = $watermark->getHeight();

		switch( $this->watermark->getPosition() ) {
			case 'topleft': 
				return $this->setTopLeft();
			case 'topright':
				return $this->setTopRight($templateDimension['w'], $wWidth);
			case 'bottomright':
				return $this->setBottomRight($templateDimension, $wWidth, $wHeight);
			case 'bottomleft':
				return $this->setBottomLeft($templateDimension['h'], $wHeight);
			default:
				return $this->setCenter($templateDimension, $wWidth, $wHeight); 
		}
	}

	private function setTopLeft() : WatermarkCoordinates {
		return new WatermarkCoordinates(0,0);
	}

	private function setTopRight($templateDimensionW, $wWidth) : WatermarkCoordinates {
		return new WatermarkCoordinates($templateDimensionW - $wWidth,0);
	}

	private function setBottomRight($templateDimension, $wWidth, $wHeight) : WatermarkCoordinates {
		return new WatermarkCoordinates($templateDimension['w'] - $wWidth, $templateDimension['h'] - $wHeight);
	}

	private function setBottomLeft($templateDimensionH, $wHeight) : WatermarkCoordinates {
		return new WatermarkCoordinates(0, $templateDimensionH - $wHeight);
	}

	private function setCenter($templateDimension, $wWidth, $wHeight) : WatermarkCoordinates {
		return new WatermarkCoordinates(( $templateDimension['w'] - $wWidth ) / 2, ( $templateDimension['h'] - $wHeight ) / 2);
	}
}