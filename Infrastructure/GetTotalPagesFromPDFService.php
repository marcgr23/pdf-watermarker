<?php

class GetTotalPagesFromPDFService implements GetTotalPagesFromDocumentInterface {
    public function execute(Document $document) : int {
        return $document->pdfInstance->setSourceFile($document->pathHandler->getOriginPath());
    }
}