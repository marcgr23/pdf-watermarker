<?php
/**
 * pdfwatermark.php
 * 
 * This class defines properties of a watermark
 * @author Binarystash <binarystash01@gmail.com>
 * @version 1.1.1
 * @license https://opensource.org/licenses/MIT MIT
 */

 include_once '';

class Watermark { //DEBATIBLE
	private $file;
	private $height;
	private $width;
	private $position;
	private $asBackground;
	private ImagePrepareInterface $image_prepare;
	
	function __construct($file, ImagePrepareInterface $image_prepare) {
		$this->file = $this->prepareImage($file);
		$this->getImageSize( $this->file );
		$this->image_prepare = $image_prepare;
		$this->position = 'center';
		$this->asBackground = false;
	}
	
	private function prepareImage() : string {
		return $this->image_prepare->doPrepare();
	}

	private function getImageSize($image) : void {
		$imageSize = getimagesize($image);
		$this->_width = $imageSize[0];
		$this->_height = $imageSize[1];
	}

	public function getCalculatedHeight() : float {
		return ($this->getHeight()/96)*25.4;
	}
	
	public function getCalculatedWidth() : float {
		return ($this->getWidth()/96)*25.4;
	}

	public function setPosition($position) : void {
		$this->position = $position;
	}
	
	public function setAsBackground() : void {
		$this->asBackground = true;
	}
	
	public function setAsOverlay() : void {
		$this->asBackground = false;
	}
	
	public function usedAsBackground() : bool {
		return $this->asBackground;
	}
	
	public function getFilePath() : string {
		return $this->file;
	}
	
	public function getHeight() : float {
		return $this->height;
	}
	
	public function getWidth() : float {
		return $this->width;
	}
}