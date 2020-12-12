<?php

include_once( dirname(__FILE__) . '/../Domain/ObjectModel/DocumentManagement/Watermark.php');
include_once( dirname(__FILE__) . '/../Infrastructure/Image/SetupPngImageService.php');
include_once( dirname(__FILE__) . '/../Infrastructure/Image/SetupJpgImageService.php');

$parent_directory = dirname(__FILE__);

class PDFWatermark_test extends PHPUnit_Framework_TestCase
{
	public $watermark;
	public $watermarkJpg;
    public $output;
	
	protected $_assets_directory;

	const DIRECTORY_SEPARATOR = '/';

    function setUp() {
		
		$this->_assets_directory = dirname(__FILE__) . self::DIRECTORY_SEPARATOR . ".." . self::DIRECTORY_SEPARATOR . "assets" . self::DIRECTORY_SEPARATOR;
		
		$this->watermark = new Watermark( $this->_assets_directory . "star.png",
			new SetupPngImageService($this->_assets_directory . "star.png"));

		$this->watermarkJpg = new Watermark( $this->_assets_directory . "star.png",
			new SetupJpgImageService($this->_assets_directory . "star.jpg"));

    }
	
    public function testSetPosition() {
		$this->watermark->setPosition('bottomleft');
		$this->assertTrue( $this->watermark->getPosition() == 'bottomleft' );
    }
	
	public function testSetAsBackground() {
		$this->watermark->setAsBackground();
		$this->assertTrue( $this->watermark->usedAsBackground() === true );
	}
	
	public function testSetAsOverlay() {
		$this->watermark->setAsBackground();
		$this->watermark->setAsOverlay();
		$this->assertTrue( $this->watermark->usedAsBackground() === false );
	}
	
	public function testGetFilePath() {
		$this->assertTrue( file_exists($this->watermark->getFilePath()) === true );
	}
	
	public function testGetHeight() {
		$this->assertTrue( $this->watermark->getHeight() == 200 );
	}
	
	public function testGetWidth() {
		$this->assertTrue( $this->watermark->getWidth()== 200 );
	}

	public function testPrepareImagePng() {
		$class = new ReflectionClass('Watermark');
		$method = $class->getMethod('prepareImage');
		$method->setAccessible(true);

  		$fileExtension = substr($method->invokeArgs($this->watermark, [ $this->_assets_directory . 'star.png']), -4);

  		$this->assertSame('.png', $fileExtension);
	}

	public function testPrepareImageJpg() {
		$class = new ReflectionClass('Watermark');
		$method = $class->getMethod('prepareImage');
		$method->setAccessible(true);

  		$fileExtension = substr($method->invokeArgs($this->watermarkJpg, [ $this->_assets_directory . 'star.jpg']), -4);

  		$this->assertSame('.jpg', $fileExtension);
	}

	public function testPrepareImageInvalidImage() {
		$class = new ReflectionClass('Watermark');
		$method = $class->getMethod('prepareImage');
		$method->setAccessible(true);

  		$fileExtension = $method->invokeArgs($this->watermark, [ $this->_assets_directory . 'star.tif']);
	}
	
}