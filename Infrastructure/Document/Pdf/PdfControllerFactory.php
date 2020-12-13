<?php

include_once( dirname(__FILE__) . '/../../DocumentController.php' );
include_once( dirname(__FILE__) . '/../../../Application/Document/ApplyWatermarkToDocument.php' );
include_once( dirname(__FILE__) . '/../../../Application/Document/SaveChangesToDocument.php' );
include_once( dirname(__FILE__) . '/../../../Application/Document/SetPageRangeToDocument.php' );


class PdfControllerFactory implements DocumentControllerFactoryInterface {
    public function create( string $originPath,
                            string $destinationPath,
                            Watermark $watermark) : DocumentController {
        return new DocumentController(
            new ApplyWatermarkToDocument(
                new ApplyWatermarkToDocumentForEachPage(
                    new PdfAddWatermark(
                        $watermark,
                        new CoordinatesCalculator()
                    ),
                    new PdfAddWatermarkInvisible(),
                    new GetTotalPagesFromPdf(),
                    new ImportPageToPdf()
                )
            ),
            new SetPageRangeToDocument(
                new SetRangeToDocumentPages(
                    new GetTotalPagesFromPdf()
                )
            ),
            new SaveChangesToDocument(
                new SavePdfDocument()
            )
        );
    }
}