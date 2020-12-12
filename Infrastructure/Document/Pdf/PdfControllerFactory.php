<?php

include_once( dirname(__FILE__) . '/DocumentController.php' );
include_once( dirname(__FILE__) . '/../Application/Services/Document/ApplyWatermarkToDocument.php' );
include_once( dirname(__FILE__) . '/../Application/Services/Document/SaveChangesToDocument.php' );
include_once( dirname(__FILE__) . '/../Application/Services/Document/SetPageRangeToDocument.php' );

class PdfControllerFactory implements DocumentFactoryInterface {
    public function create( string $originPath,
                            string $destinationPath,
                            Watermark $watermark) : DocumentController {
        return new DocumentController(
            new ApplyWatermarkToDocumentService(
                new PdfAddWatermarkService(
                    $watermark,
                    new CoordinatesCalculatorService()
                ),
                new PdfAddWatermarkInvisibleService(),
                new GetTotalPagesFromPDFService(),
                new ImportPageToPDFService()
            ),
            new SetPageRangeToDocumentService(
                new GetTotalPagesFromPDFService()
            ),
            new SaveChangesToDocumentService(
                new SavePDFDocument()
            )
        );
    }
}