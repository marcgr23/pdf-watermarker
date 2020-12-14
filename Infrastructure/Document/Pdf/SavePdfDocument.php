<?php

include_once( dirname(__FILE__) . '/../../../Domain/Document/SaveDocumentInterface.php' );
include_once( dirname(__FILE__) . '/../../../Domain/ObjectModel/Document/Document.php' );

class SavePdfDocument implements SaveDocumentInterface {
    private const OUTPUT_FILE_VALUE   = "F";

    public function execute(Document $document) : void {
        $document->pdfInstance->Output(self::OUTPUT_FILE_VALUE, $document->pathHandler->getDestinyPath());
    }
}