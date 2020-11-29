<?php

use setasign\Fpdi\Tcpdf\Fpdi;

class DocumentFactoryPdf implements DocumentFactory {

    public function createDocument(string $originPath, string $destinyPath, Watermark $watermark) : DocumentHandlerInterface {
        $pdfInstance = new FPDI();

        return $documentInstance = new PdfDocument(
            new DocumentPathHandler($originPath, $destinyPath),
            $pdfInstance,
            new PdfAddWatermarkService($pdfInstance, $watermark),
            new PdfAddWatermarkInvisibleService($pdfInstance)
        );
    }
}