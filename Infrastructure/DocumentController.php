<?php

include_once( dirname(__FILE__) . '/../Domain/Watermark.php');
include_once( dirname(__FILE__) . '/../Domain/Document.php');
include_once( dirname(__FILE__) . '/../Domain/ObjectModel/Range.php');

include_once(dirname(__FILE__) . '/../Domain/Interfaces/SetPageRangeToDocumentService.php');
include_once(dirname(__FILE__) . '/../Domain/Interfaces/ApplyWatermarkToDocumentService.php');
include_once(dirname(__FILE__) . '/../Domain/Interfaces/SaveChangesToDocumentService.php');

class DocumentController {
	private SetPageRangeToDocumentService $setPageRangeToDocumentService;
	private ApplyWatermarkToDocumentService $applyWatermarkToDocumentService;
	private SaveChangesToDocumentService $saveChangesToDocumentService;
	
	public function __construct(ApplyWatermarkToDocumentService $applyWatermarkToDocumentService,
								SetPageRangeToDocumentService $setPageRangeToDocumentService,
								SaveChangesToDocumentService $saveChangesToDocumentService) {
		$this->applyWatermarkToDocumentService = $applyWatermarkToDocumentService;
		$this->setPageRangeToDocumentService = $setPageRangeToDocumentService;
		$this->saveChangesToDocumentService = $saveChangesToDocumentService;
	}
	
	public function setPageRange(Range $range, Document &$document) : void {
		$this->setPageRangeToDocumentService->execute($range, $document);
	}

	public function applyWatermarksToDocument(Document &$document): void {
		$this->applyWatermarkToDocumentService->execute($document);
	}
	
	public function saveDocument(Document $document) : void {
		$this->saveChangesToDocumentService->execute($document);
	}
}
?>
