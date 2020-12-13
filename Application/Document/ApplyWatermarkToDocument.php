<?php

include_once( dirname(__FILE__) . '/../../Domain/ObjectModel/Document/Document.php');
include_once( dirname(__FILE__) . '/../../Domain/Document/ApplyWatermarkToDocumentForEachPage.php');

class ApplyWatermarkToDocument {
    private ApplyWatermarkToDocumentForEachPage $applyWatermarkToDocumentForEachPage;

    public function __construct(ApplyWatermarkToDocumentForEachPage $applyWatermarkToDocumentForEachPage) {
        $this->applyWatermarkToDocumentForEachPage = $applyWatermarkToDocumentForEachPage;
    }
    
    public function execute(Document &$document) : void {
        $this->applyWatermarkToDocumentForEachPage->execute($document);
    }
}