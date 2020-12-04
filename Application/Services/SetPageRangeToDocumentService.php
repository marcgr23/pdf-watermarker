<?php

include_once( dirname(__FILE__) . '/../../Domain/PDFDocument.php');
include_once( dirname(__FILE__) . '/DocumentPage.php');
include_once( dirname(__FILE__) . '/GetTotalPagesFromPDFService.php');
use \setasign\Fpdi\Fpdi;

class SetPageRangeToDocumentService {
    private GetTotalPagesFromPDFService $getTotalPagesFromPDFService;

    public function __construct() {
        $this->getTotalPagesFromPDFService = new GetTotalPagesFromPDFService();
    }

    public function execute(Range $range, PDFDocument &$pdfDocument) : void {
        $end = $range->getRangeEnd() !== null ? $range->getRangeEnd() : $this->getTotalPagesFromPDFService->getTotalPages($pdfDocument->pdfInstance);
        
		for ($ctr = 1; $ctr <= $this->getTotalPagesFromPDFService->getTotalPages($pdfDocument->pdfInstance); $ctr++ ) {
            $isWithinRange = $ctr >= $range->getRangeStart() && $ctr <= $end;
            $pdfDocument->specificPages[] = new DocumentPage($isWithinRange, $ctr);
        }
    }
}