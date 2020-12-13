<?php

include_once( dirname(__FILE__) . '/../../Domain/PdfAddWatermarkInterface.php');

class PdfAddWatermarkInvisible implements AddWatermarkInterface {
    public function execute (Document &$document, DocumentPage $page) : void {
      $templateId = $this->pdfInstance->importPage($page->getPageNumber());
      $this->pdfInstance->useTemplate($templateId);
    }
}