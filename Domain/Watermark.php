<?php
/**
 * pdfwatermark.php
 * 
 * This class defines properties of a watermark
 * @author Binarystash <binarystash01@gmail.com>
 * @version 1.1.1
 * @license https://opensource.org/licenses/MIT MIT
 */

class Watermark { //DEBATIBLE
	private $file;
	private $_height;
	private $_width;
	private $_position;
	private $_asBackground;
	
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

	public function setPosition($position) {
		$this->_position = $position;
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
	
	public function getFilePath() {
		return $this->file;
	}
	
	public function getHeight() {
		return $this->height;
	}
	
	public function getWidth() {
		return $this->_width;
	}
}