<?php

include_once( dirname(__FILE__) . '/../../Domain/PDFDocument.php');

class SaveChangesToDocumentService {

    private const OUTPUT_FILE_VALUE   = "F";

    public function __construct() {

    }
    
    public function execute(PDFDocument $pdfDocument) : void {
        
        $pdfDocument->pdfInstance->Output(self::OUTPUT_FILE_VALUE, $pdfDocument->$pathHandler->getDestinyPath());
    }
}