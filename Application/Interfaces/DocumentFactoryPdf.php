<?php

class DocumentFactoryPdf implements DocumentFactory {

    public function createDocument(string $originPath, string $destinyPath, Watermark $watermark) : DocumentHandlerInterface {
        
        $pdfInstance = new PDFI();

        $addWatermarkService = new AddWatermarkPDFService($pdfInstance, $watermark);
        $addWatermarkServiceInvisible = new AddWatermarkInvisibleService($pdfInstance);
        $documentPathHandlerInstance = new DocumentPathHandler($originPath, $destinyPath);
        
        return $documentInstance = new PdfDocument(
            $documentPathHandlerInstance,
            $pdfInstance,
            $addWatermarkService,
            $addWatermarkServiceInvisible
        );
    }
}