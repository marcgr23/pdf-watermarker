<?php

include_once( dirname(__FILE__) . '/../Domain/ObjectModel/Document/Watermark.php');
include_once( dirname(__FILE__) . '/../Domain/ObjectModel/Document/Document.php');
include_once( dirname(__FILE__) . '/../Domain/ObjectModel/Document/Range.php');

include_once(dirname(__FILE__) . '/../Application/Document/SetPageRangeToDocument.php');
include_once(dirname(__FILE__) . '/../Application/Document/ApplyWatermarkToDocument.php');
include_once(dirname(__FILE__) . '/../Application/Document/SaveChangesToDocument.php');

class DocumentController {
	private SetPageRangeToDocument $setPageRangeToDocument;
	private ApplyWatermarkToDocument $applyWatermarkToDocument;
	private SaveChangesToDocument $saveChangesToDocument;
	
	public function __construct(ApplyWatermarkToDocument $applyWatermarkToDocument,
								SetPageRangeToDocument $setPageRangeToDocument,
								SaveChangesToDocument $saveChangesToDocument) {
		$this->applyWatermarkToDocument = $applyWatermarkToDocument;
		$this->setPageRangeToDocument = $setPageRangeToDocument;
		$this->saveChangesToDocument = $saveChangesToDocument;
	}
	
	public function setPageRange(Range $range, Document &$document) : void {
		$this->setPageRangeToDocument->execute($range, $document);
	}

	public function applyWatermarksToDocument(Document &$document): void {
		$this->applyWatermarkToDocument->execute($document);
	}
	
	public function saveDocument(Document $document) : void {
		$this->saveChangesToDocument->execute($document);
	}
}
?>
