<?php

include_once( dirname(__FILE__) . '/../Domain/ObjectModel/Document/Watermark.php');
include_once( dirname(__FILE__) . '/../Domain/Image/SetupPngImage.php');
include_once( dirname(__FILE__) . '/../Domain/Image/SetupJpgImage.php');

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
			new SetupPngImage($this->_assets_directory . "star.png"));

		$this->watermarkJpg = new Watermark( $this->_assets_directory . "star.png",
			new SetupJpgImage($this->_assets_directory . "star.jpg"));

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
		$this->assertTrue( $this->watermark->getImageHeight() == 200 );
	}
	
	public function testGetWidth() {
		$this->assertTrue( $this->watermark->getImageWidth()== 200 );
	}

	public function testPrepareImagePng() {
		$image = new Image($this->_assets_directory . 'star.png');

  		$this->assertSame('png', $image->getExtension());
	}

	public function testPrepareImageJpg() {
		$image = new Image($this->_assets_directory . 'star.jpg');

  		$this->assertSame('jpg', $image->getExtension());
	}

	public function testPrepareImageInvalidImage() {
		$this->setExpectedException("Exception", "UnknownImageFormat");
		$image = new Image($this->_assets_directory . 'star.tif');
	}
	
}