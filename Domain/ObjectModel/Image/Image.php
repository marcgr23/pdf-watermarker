<?php

include_once( dirname(__FILE__) . '/../../Image/ImagePrepareInterface.php');
include_once( dirname(__FILE__) . '/../../Image/SetupPngImage.php');
include_once( dirname(__FILE__) . '/../../Image/SetupJpgImage.php');

class Image {

    const IMAGE_WIDTH = 0;
	const IMAGE_HEIGHT = 1;
	const JPG = 'jpg';
	const PNG = 'png';
	const EXTENSION_ARRAY_NAME = 'extension';
    
	private string $filePath;
	private int $height;
	private int $width;
	private string $extension;

    function __construct(string $filePath) {
		$this->initializeExtension($filePath);
		$imagePrepare = $this->setImagePrepare();
		$this->filePath = $this->doPrepare($imagePrepare);
		$this->setImageSize($this->filePath);
	}

    private function setImageSize(string $filePath) : void {
		$imageSize = getimagesize($filePath);
		$this->width = $imageSize[self::IMAGE_WIDTH];
		$this->height = $imageSize[self::IMAGE_HEIGHT];
    }
    
    public function getCalculatedHeight() : float {
		return ($this->height/self::DPI)*self::INCHES;
	}
	
	public function getCalculatedWidth() : float {
		return ($this->width/self::DPI)*self::INCHES;
    }
    
    public function getFilePath() : string {
		return $this->filePath;
	}

	private function initializeExtension(string $path) : void {
		$partes_ruta = pathinfo($path);
		$this->extension = strtolower($partes_ruta[self::EXTENSION_ARRAY_NAME]);
	}

	public function doPrepare(ImagePrepareInterface $genericPreparer) : string {
		$genericPreparer->doPrepare();
	}

	private function setImagePreparer () : ImagePrepareInterface{
		switch($this->extension):
			case self::JPG:
				return new SetupJpgImage($this->filePath);
			case self::PNG:
				return new SetupPngImage($this->filePath);
			
		// return $genericPreparer;
	}
}