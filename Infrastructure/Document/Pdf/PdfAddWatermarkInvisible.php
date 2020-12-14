<?php

include_once( dirname(__FILE__) . '/../../../Domain/Document/AddWatermarkInterface.php');

class PdfAddWatermarkInvisible implements AddWatermarkInterface {
    public function execute (Document &$document, DocumentPage $page) : void {
      $templateId = $document->pdfInstance->importPage($page->getPageNumber());
      $document->pdfInstance->useTemplate($templateId);
    }
}