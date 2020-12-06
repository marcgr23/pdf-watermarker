<?php

include_once( dirname(__FILE__) . '/../Domain/Document.php' );

class SavePDFDocument implements SaveDocumentInterface {
    private const OUTPUT_FILE_VALUE   = "F";

    public function execute(Document $document) : void {
        $document->pdfInstance->Output(self::OUTPUT_FILE_VALUE, $document->pathHandler->getDestinyPath());
    }
}