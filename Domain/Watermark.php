<?php
/**
 * pdfwatermark.php
 * 
 * This class defines properties of a watermark
 * @author Binarystash <binarystash01@gmail.com>
 * @version 1.1.1
 * @license https://opensource.org/licenses/MIT MIT
 */

class Watermark {
	private $file;
	private $_height;
	private $_width;

	private $_position;
	// private $_asBackground;
	
	function __construct($file, $image_prepare) {
		$this->file = $this->prepareImage($file);
		$this->getImageSize( $this->file );
		
		// $this->_position = 'center';
		// $this->_asBackground = false;
	}
	
	private function prepareImage($file) {
		$imagetype = exif_imagetype( $file );

		$this->image_prepare.doPrepare();
			
		return $path;
	}

	private function getImageSize($image) {
		$imageSize = getimagesize($image);
		$this->_width = $imageSize[0];
		$this->_height = $imageSize[1];
	}

	public function getCalculatedHeight() {
		return ($this->getHeight()/96)*25.4;
	}
	
	public function getCalculatedWidth() {
		return ($this->getWidth()/96)*25.4;
	}

	public function setPosition($position, $coordinate_x, $coordinate_y) {
		$this->_position = $position;
		$this->coordinate_x = $coordinate_x;
		$this->coordinate_y = $coordinate_y;
	}
	
	public function setAsBackground() {
		$this->_asBackground = true;
	}
	
	public function setAsOverlay() {
		$this->_asBackground = false;
	}
	
	public function usedAsBackground() {
		return $this->_asBackground;
	}
	
	public function getCoordinates($templateDimension) {
		$wWidth = $this->getWidth(); //in mm
		$wHeight = $this->getHeight(); //in mm

		switch($this->_watermark->getPosition()) {
			case 'topleft': 
				$x = 0;
				$y = 0;
				break;
			case 'topright':
				$x = $templateDimension['w'] - $wWidth;
				$y = 0;
				break;
			case 'bottomright':
				$x = $templateDimension['w'] - $wWidth;
				$y = $templateDimension['h'] - $wHeight;
				break;
			case 'bottomleft':
				$x = 0;
				$y = $templateDimension['h'] - $wHeight;
				break;
			case 'custom':
				$x = ( $templateDimension['w'] - $wWidth ) * $this->getCoordinateX();
				$y = ( $templateDimension['h'] - $wHeight ) * $this->getCoordinateY();
				break;
			case 'custom':
				$x = ( $templateDimension['w'] - $wWidth ) / 2 ;
				$y = ( $templateDimension['h'] - $wHeight ) / 2 ;
				break; 
		}
	}
	
	public function getFilePath() {
		return $this->file;
	}
	
	public function getHeight() {
		return $this->height;
	}
	
	public function getWidth() {
		return $this->_width;
	}

	public function getCoordinateX() {
		return $this->coordinate_x;
	}

	public function getCoordinateY() {
		return $this->coordinate_y;
	}
}