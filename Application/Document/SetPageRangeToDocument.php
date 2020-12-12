<?php

include_once( dirname(__FILE__) . '/../../../Domain/Document.php');
include_once( dirname(__FILE__) . '/../../../Domain/ObjectModel/DocumentPage.php');
include_once( dirname(__FILE__) . '/../../../Domain/GetTotalPagesFromDocumentInterface.php');

class SetPageRangeToDocumentService {
    private SetPageRangeToDocument $setPageRangeToDocumentService;

    public function __construct(GetTotalPagesFromDocumentInterface $getTotalPagesFromDocumentService) {
        $this->setPageRangeToDocumentService = new SetPageRangeToDocument($getTotalPagesFromDocumentService);
    }

    public function execute(Range $range, Document &$document) : void {
        $this->setPageRangeToDocumentService->execute($range, $document);
    }
}