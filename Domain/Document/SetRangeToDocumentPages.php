<?php

include_once( dirname(__FILE__) . '/../ObjectModel/Document/DocumentPage.php');

class SetRangeToDocumentPages {

    private GetTotalPagesFromDocumentInterface $getTotalPagesFromDocument;

    public function __construct(GetTotalPagesFromDocumentInterface $getTotalPagesFromDocument) {
        $this->getTotalPagesFromDocument = $getTotalPagesFromDocument;
    }

    public function execute(Range $range, Document &$document) : void {
        $totalPages = $this->getTotalPagesFromDocument->execute($document);
    
        $end = $range->getRangeEnd() !== 0 ? $range->getRangeEnd() : $totalPages;
    
        for ($ctr = 1; $ctr <= $totalPages; $ctr++ ) {
            $isWithinRange = $ctr >= $range->getRangeStart() && $ctr <= $end;
            $document->pages[] = new DocumentPage($isWithinRange, $ctr);
        }
    }
}