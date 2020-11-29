<?php

use \setasign\Fpdi\Fpdi;
include_once( dirname(__FILE__) . '/../../Domain/ObjectModel/WatermarkCoordinates.php');

class CoordinatesCalculatorService {
	private FPDI $pdfInstance;
	private const WIDTH_COLUMN_NAME   = 'width';
    private const HEIGHT_COLUMN_NAME  = 'height';

    public function __construct (FPDI $pdfInstance) {
		$this->pdfInstance = $pdfInstance;
    }

    public function execute($watermark, $templateId) : WatermarkCoordinates {
		$templateDimension = $this->pdfInstance->getTemplateSize($templateId);
		$wWidth = $watermark->getCalculatedWidth();
		$wHeight = $watermark->getCalculatedHeight();

		switch( $watermark->getPosition() ) {
			case 'topleft': 
				return $this->setTopLeft();
			case 'topright':
				return $this->setTopRight($templateDimension[self::WIDTH_COLUMN_NAME], $wWidth);
			case 'bottomright':
				return $this->setBottomRight($templateDimension, $wWidth, $wHeight);
			case 'bottomleft':
				return $this->setBottomLeft($templateDimension[self::HEIGHT_COLUMN_NAME], $wHeight);
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
		return new WatermarkCoordinates($templateDimension[self::WIDTH_COLUMN_NAME] - $wWidth, $templateDimension[self::HEIGHT_COLUMN_NAME] - $wHeight);
	}

	private function setBottomLeft($templateDimensionH, $wHeight) : WatermarkCoordinates {
		return new WatermarkCoordinates(0, $templateDimensionH - $wHeight);
	}

	private function setCenter($templateDimension, $wWidth, $wHeight) : WatermarkCoordinates {
		return new WatermarkCoordinates(( $templateDimension[self::WIDTH_COLUMN_NAME] - $wWidth ) / 2, ( $templateDimension[self::HEIGHT_COLUMN_NAME] - $wHeight ) / 2);
	}
}