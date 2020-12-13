<?php

include_once( dirname(__FILE__) . '/../../Image/ImagePrepareInterface.php');

class Watermark {

	const IMAGE_WIDTH = 0;
	const IMAGE_HEIGHT = 1;
	const DPI = 96;
	const INCHES = 25.4;
	const DEFAULT_POSITION = 'center';
	
	private string $filePath;
	private int $height;
	private int $width;
	private string $position;
	private bool $asBackground;
	private ImagePrepareInterface $imagePrepare;
	
	function __construct(string $filePath, ImagePrepareInterface $imagePrepare) {
		$this->imagePrepare = $imagePrepare;
		$this->filePath = $this->prepareImage($filePath);
		$this->getImageSize( $this->filePath );
		$this->position = self::DEFAULT_POSITION;
		$this->asBackground = false;
	}
	
	private function prepareImage() : string {
		return $this->imagePrepare->doPrepare();
	}

	private function getImageSize(string $filePath) : void {
		$imageSize = getimagesize($filePath);
		$this->width = $imageSize[self::IMAGE_WIDTH];
		$this->height = $imageSize[self::IMAGE_HEIGHT];
	}

	public function getCalculatedHeight() : float {
		return ($this->getHeight()/self::DPI)*self::INCHES;
	}
	
	public function getCalculatedWidth() : float {
		return ($this->getWidth()/self::DPI)*self::INCHES;
	}

	public function setPosition(string $position) : void {
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
		return $this->filePath;
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