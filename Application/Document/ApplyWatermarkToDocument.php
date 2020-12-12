<?php

include_once( dirname(__FILE__) . '/../../Domain/Document/ApplyWatermarkToDocument.php');
include_once( dirname(__FILE__) . '/../../Domain/ObjectModel/Document/Document.php');
include_once( dirname(__FILE__) . '/../../Domain/Document/GetTotalPagesFromDocumentInterface.php');
include_once( dirname(__FILE__) . '/../../Domain/Document/ImportPageInterface.php');
include_once( dirname(__FILE__) . '/../../Domain/Document/AddWatermarkServiceInterface.php');

class ApplyWatermarkToDocument {
    private ApplyWatermarkToDocument $applyWatermarkToDocument;

    public function __construct(AddWatermarkServiceInterface $addWatermarkService,
                                AddWatermarkServiceInterface $addWatermarkInvisibleService,
                                GetTotalPagesFromDocumentInterface $getTotalPagesFromDocumentService,
                                ImportPageInterface $importPageService) {
        $this->applyWatermarkToDocument = new ApplyWatermarkToDocument( $addWatermarkService,
                                                                        $addWatermarkInvisibleService,
                                                                        $getTotalPagesFromDocumentService,
                                                                        $importPageService);
    }
    
    public function execute(Document &$document) : void {
        $this->applyWatermarkToDocument->execute($document);
    }
}