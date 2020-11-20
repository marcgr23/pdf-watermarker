<?php

class CoordinatesCalculatorService {
    private $pdfInstance;

    public function __construct ($pdfInstance) {
		$this->pdfInstance = $pdfInstance;
    }

    public function calculate($watermark, $templateId): array {
		$templateDimension = $this->pdfInstance->getTempdlateSize($templateId);
		// $wWidth = $watermark->getWidth(); //in mm
		// $wHeight = $watermark->getHeight(); //in mm
		
		// //One possible improvement would be adding a system for using relative coordinates
		// //with percentages for x and y instead of fixed positions
		// switch( $this->_watermark->getPosition() ) {
		// 	case 'topleft': 
		// 		$x = 0;
		// 		$y = 0;
		// 		break;
		// 	case 'topright':
		// 		$x = $templateDimension['w'] - $wWidth;
		// 		$y = 0;
		// 		break;
		// 	case 'bottomright':
		// 		$x = $templateDimension['w'] - $wWidth;
		// 		$y = $templateDimension['h'] - $wHeight;
		// 		break;
		// 	case 'bottomleft':
		// 		$x = 0;
		// 		$y = $templateDimension['h'] - $wHeight;
		// 		break;
		// 	default:
		// 		$x = ( $templateDimension['w'] - $wWidth ) / 2 ;
		// 		$y = ( $templateDimension['h'] - $wHeight ) / 2 ;
		// 		break; 
		// }
		
		return array($x,$y);
	}
}