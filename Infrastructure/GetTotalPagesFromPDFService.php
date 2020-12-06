<?php

class GetTotalPagesFromPDFService {
    public function getTotalPages(Document $document) {
        return $document->pdfInstance->setSourceFile($document->pathHandler->getOriginPath());
    }
}