<?php

include_once( dirname(__FILE__) . '/../Domain/Watermark.php');
include_once( dirname(__FILE__) . '/../Domain/PDFDocument.php');
include_once( dirname(__FILE__) . '/../Domain/ObjectModel/DocumentPathHandler.php');
include_once( dirname(__FILE__) . '/../Domain/ObjectModel/Range.php');

include_once(dirname(__FILE__) . '/Services/SetPageRangeToDocumentService.php');
include_once(dirname(__FILE__) . '/Services/ApplyWatermarkToDocumentService.php');
include_once(dirname(__FILE__) . '/Services/SaveChangesToDocumentService.php');

class DocumentController {
	private PDFDocument $pdfDocument;
	private Watermark $watermark;
	
	private SetPageRangeToDocumentService $setPageRangeToDocumentService;
	private ApplyWatermarkToDocumentService $applyWatermarkToDocumentService;
	private SaveChangesToDocumentService $saveChangesToDocumentService;
	
	public function __construct(Watermark $watermark,
								DocumentPathHandler $pathHandler) {
		$this->$pdfDocument = new PDFDocument($pathHandler);
		$this->$watermark = $watermark;
		$this->$setPageRangeToDocumentService = new SetPageRangeToDocumentService();
		$this->$applyWatermarkToDocumentService = new ApplyWatermarkToDocumentService($this->$document);
		$this->$saveChangesToDocumentService = new SaveChangesToDocumentService($this->$document);
	}
	
	public function setPageRange(Range $range, PDFDocument &$pdfDocument) : void {
		$this->$setPageRangeToDocumentService->execute($range, $pdfDocument);
	}

	public function applyWatermarksToDocument(PDFDocument &$pdfDocument): void {
		$this->$applyWatermarkToDocumentService->execute($pdfDocument);
	}
	
	public function saveDocument(PDFDocument $pdfDocument) : void {
		$this->saveChangesToDocumentService->execute($pdfDocument);
	}
}
?>
