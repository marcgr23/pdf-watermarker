<?php

include_once( dirname(__FILE__) . '/../../Image/ImagePrepareInterface.php');
include_once( dirname(__FILE__) . '/../Image/Image.php');

class Watermark {

	const DEFAULT_POSITION = 'center';
	
	private string $position;
	private bool $asBackground;
	private Image $image;
	
	function __construct(string $filePath) {
		$this->image = new Image ($filePath);
		$this->position = self::DEFAULT_POSITION;
		$this->asBackground = false;
	}

	public function getHeight() : float {
		return $this->image->getCalculatedHeight();
	}
	
	public function getWidth() : float {
		return $this->image->getCalculatedWidth();
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

	public function getPosition() : string {
		return $this->position;
	}

	public function getFilePath() : string {
		return $this->image->getFilePath();
	}
}