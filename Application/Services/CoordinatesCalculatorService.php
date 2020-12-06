<?php

include_once( dirname(__FILE__) . '/../../Domain/ObjectModel/Coordinates.php');
include_once( dirname(__FILE__) . '/../../Domain/Watermark.php');
include_once( dirname(__FILE__) . '/../../Domain/Document.php');
include_once( dirname(__FILE__) . '/../../Domain/Interfaces/CoordinatesCalculatorInterface.php');

class PdfCoordinatesCalculatorService implements CoordinatesCalculatorInterface {
	private Document $document;
	private const WIDTH_COLUMN_NAME   = 'width';
    private const HEIGHT_COLUMN_NAME  = 'height';

    public function __construct (Document $document) {
		$this->document = $document;
    }

    public function execute(Watermark $watermark, string $templateId) : Coordinates {
		$templateDimension = $this->document->pdfInstance->getTemplateSize($templateId);
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

	private function setTopLeft() : Coordinates {
		return new Coordinates(0,0);
	}

	private function setTopRight($templateDimensionW, $wWidth) : Coordinates {
		return new Coordinates($templateDimensionW - $wWidth,0);
	}

	private function setBottomRight($templateDimension, $wWidth, $wHeight) : Coordinates {
		return new Coordinates($templateDimension[self::WIDTH_COLUMN_NAME] - $wWidth, $templateDimension[self::HEIGHT_COLUMN_NAME] - $wHeight);
	}

	private function setBottomLeft($templateDimensionH, $wHeight) : Coordinates {
		return new Coordinates(0, $templateDimensionH - $wHeight);
	}

	private function setCenter($templateDimension, $wWidth, $wHeight) : Coordinates {
		return new Coordinates(( $templateDimension[self::WIDTH_COLUMN_NAME] - $wWidth ) / 2, ( $templateDimension[self::HEIGHT_COLUMN_NAME] - $wHeight ) / 2);
	}
}