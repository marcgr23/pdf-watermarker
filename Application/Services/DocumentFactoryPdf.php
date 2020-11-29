<?php

use \setasign\Fpdi\Fpdi;
include_once( dirname(__FILE__) . '/../../Domain/ObjectModel/DocumentPathHandler.php');
include_once( dirname(__FILE__) . '/../Interfaces/ImagePrepareInterface.php');
include_once( dirname(__FILE__) . '/PdfAddWatermarkService.php');
include_once( dirname(__FILE__) . '/PdfAddWatermarkInvisibleService.php');

class DocumentFactoryPdf implements DocumentFactory {

    public function createDocument(string $originPath, string $destinyPath, Watermark $watermark) : DocumentHandlerInterface {
        $pdfInstance = new Fpdi();

        return new PdfDocument(
            new DocumentPathHandler($originPath, $destinyPath),
            $pdfInstance,
            new PdfAddWatermarkService($pdfInstance, $watermark),
            new PdfAddWatermarkInvisibleService($pdfInstance)
        );
    }
}