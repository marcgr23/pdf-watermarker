<?php

class SetPageRangeToDocument {

    private GetTotalPagesFromDocumentInterface $getTotalPagesFromDocumentService;

    public function __construct(GetTotalPagesFromDocumentInterface $getTotalPagesFromDocumentService) {
        $this->getTotalPagesFromDocumentService = $getTotalPagesFromDocumentService;
    }

    public function execute(Range $range, Document &$document) : void {
        $totalPages = $this->getTotalPagesFromDocumentService->execute($document);
    
        $end = $range->getRangeEnd() !== null ? $range->getRangeEnd() : $totalPages;
    
        for ($ctr = 1; $ctr <= $totalPages; $ctr++ ) {
            $isWithinRange = $ctr >= $range->getRangeStart() && $ctr <= $end;
            $document->pages[] = new DocumentPage($isWithinRange, $ctr);
        }
    }
}