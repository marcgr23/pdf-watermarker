<?php

class DocumentFactoryPdf implements DocumentFactory {

    public function createDocument(string $originPath, string $destinyPath, Watermark $watermark) : DocumentHandlerInterface {
        
        return $documentInstance = new PdfDocument(
            new DocumentPathHandler($originPath, $destinyPath),
            new PDFI(),
            new AddWatermarkPDFService($pdfInstance, $watermark),
            new AddWatermarkInvisibleService($pdfInstance)
        );
    }
}