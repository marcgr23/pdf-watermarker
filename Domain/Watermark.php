<?php
/**
 * pdfwatermark.php
 * 
 * This class defines properties of a watermark
 * @author Binarystash <binarystash01@gmail.com>
 * @version 1.1.1
 * @license https://opensource.org/licenses/MIT MIT
 */

include_once( dirname(__FILE__) . '/../Application/Interfaces/ImagePrepareInterface.php');

class Watermark { //DEBATIBLE
	private $file;
	private $height;
	private $width;
	private $position;
	private $asBackground;
	private ImagePrepareInterface $image_prepare;
	
	function __construct($file, ImagePrepareInterface $image_prepare) {
		$this->image_prepare = $image_prepare;
		$this->file = $this->prepareImage($file);
		$this->getImageSize( $this->file );
		$this->position = 'center';
		$this->asBackground = false;
	}
	
	private function prepareImage() : string {
		return $this->image_prepare->doPrepare();
	}

	private function getImageSize($image) : void {
		$imageSize = getimagesize($image);
		$this->width = $imageSize[0];
		$this->height = $imageSize[1];
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

	public function getPosition() : string {
		return $this->position;
	}
}