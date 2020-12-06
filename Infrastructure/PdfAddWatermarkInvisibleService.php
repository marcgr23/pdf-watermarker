<?php

include_once( dirname(__FILE__) . '/../../Domain/Interfaces/PdfAddWatermarkServiceInterface.php');

class PdfAddWatermarkInvisibleService implements AddWatermarkServiceInterface {
    public function execute (Document &$document, DocumentPage $page) : void {
      $templateId = $this->pdfInstance->importPage($page->getPageNumber());
      $this->pdfInstance->useTemplate($templateId);
    }
}