<?php

include_once( dirname(__FILE__) . '/../Domain/DocumentManagement/DocumentFactoryInterface.php');
include_once( dirname(__FILE__) . '/../Infrastructure/DocumentManagement/Pdf/PdfControllerFactory.php');

include_once( dirname(__FILE__) . '/../Domain/ObjectModel/DocumentManagement/Watermark.php');
include_once( dirname(__FILE__) . '/../Infrastructure/Image/SetupPngImageService.php');
include_once( dirname(__FILE__) . '/../Infrastructure/Image/SetupJpgImageService.php');

class PDFWatermarker_test extends PHPUnit_Framework_TestCase
{
  public $watermark;
  public $watermarker;
  public $output;
  public $output_multiple;
  public DocumentFactoryInterface $factory;
  public PdfDocument $document;
  public PdfDocument $document_multiple;
  const DIRECTORY_SEPARATOR = '/';

  protected $_assets_directory;

  function setUp() {
    $this->_assets_directory = dirname(__FILE__) . self::DIRECTORY_SEPARATOR . ".." . self::DIRECTORY_SEPARATOR . "assets" . self::DIRECTORY_SEPARATOR;
    $this->factory = new PdfControllerFactory();
    $this->watermark = new Watermark( $this->_assets_directory . "star.png",
                                      new SetupPngImageService($this->_assets_directory . "star.png"));
    $this->output =  $this->_assets_directory . "test-output.pdf";
    $this->output_multiple =  $this->_assets_directory . "test-output-multiple.pdf";
    $input = $this->_assets_directory . "test.pdf";
    $input_multiple = $this->_assets_directory . "test-multipage.pdf";    
    $this->watermarker = $this->factory->create($input, $this->output, $this->watermark);
    $this->watermarker->setPageRange(new Range());
    $this->watermarker_multiple = $this->factory->create($input_multiple, $this->output_multiple, $this->watermark);
  }

  public function testDefaultOptions() {
    $this->watermarker->applyWatermarksToDocument();
    $this->watermarker->saveChangesToDocument();
    $this->assertTrue( file_exists($this->output) === true );
    $this->assertTrue( filesize( $this->_assets_directory . "output-default-position.pdf") === filesize($this->output) );
  }

  public function testDefaultOptionsWithJPG() {
    $watermark_jpg = new Watermark( $this->_assets_directory . 'star.jpg', new JpgImage($this->_assets_directory . "star.jpg"));
    $watermarker_jpg = $this->factory->createDocument($this->_assets_directory . 'test.pdf', $this->output, $watermark_jpg);
  
    $watermarker_jpg->setPageRangesToDocument(1);
    $watermarker_jpg->applyWatermarksToDocument();
    $watermarker_jpg->saveChangesToDocument();
    $this->assertTrue( file_exists($this->output) === true );
    $this->assertTrue( filesize( $this->_assets_directory . 'output-from-jpg.pdf') === filesize($this->output) );
  }

  public function testTopRightPosition() {
    $this->watermark->setPosition('topright');
    $this->watermarker->applyWatermarksToDocument(); 
    $this->watermarker->saveChangesToDocument();
    $this->assertTrue( file_exists($this->output) === true );
    $this->assertTrue( filesize( $this->_assets_directory . 'output-topright-position.pdf') === filesize($this->output) );
  }

  public function testTopLeftPosition() {
    $this->watermark->setPosition('topleft');
    $this->watermarker->applyWatermarksToDocument(); 
    $this->watermarker->saveChangesToDocument(); 
    $this->assertTrue( file_exists($this->output) === true );
    $this->assertTrue( filesize( $this->_assets_directory . 'output-topleft-position.pdf') === filesize($this->output) );
  }

  public function testBottomRightPosition() {
    $this->watermark->setPosition('bottomright');
    $this->watermarker->applyWatermarksToDocument(); 
    $this->watermarker->saveChangesToDocument(); 
    $this->assertTrue( file_exists($this->output) === true );
    $this->assertTrue( filesize( $this->_assets_directory . 'output-bottomright-position.pdf') === filesize($this->output) );
  }

  public function testBottomLeftPosition() {
    $this->watermark->setPosition('bottomleft');
    $this->watermarker->applyWatermarksToDocument(); 
    $this->watermarker->saveChangesToDocument(); 
    $this->assertTrue( file_exists($this->output) === true );
    $this->assertTrue( filesize( $this->_assets_directory . 'output-bottomleft-position.pdf') === filesize($this->output) );
  }

  public function testAsBackground() {
    $this->watermark->setAsBackground();
    $this->watermarker->applyWatermarksToDocument(); 
    $this->watermarker->saveChangesToDocument(); 
    $this->assertTrue( file_exists($this->output) === true );
    $this->assertTrue( filesize( $this->_assets_directory . 'output-as-background.pdf') === filesize($this->output) );
  }
	
	public function testSpecificPages() {
		$this->watermarker_multiple->setPageRangesToDocument(3,5);
    $this->watermarker_multiple->applyWatermarksToDocument(); 
    $this->watermarker_multiple->saveChangesToDocument();
    $this->assertTrue( file_exists($this->output_multiple) === true );
		$this->assertTrue( filesize( $this->_assets_directory . 'output-multipage.pdf') === filesize($this->output_multiple) );
  }
}