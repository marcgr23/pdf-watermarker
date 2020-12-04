<?php

include_once( dirname(__FILE__) . '/ObjectModel/DocumentPathHandler.php');
include_once( dirname(__FILE__) . '/ObjectModel/Range.php');
use \setasign\Fpdi\Fpdi;

class PDFDocument {
    public Fpdi $pdfInstance;
    public DocumentPathHandler $pathHandler;
    public $specificPages;

    public function __construct(DocumentPathHandler $pathHandler, Range $range) {
        $this->pdfInstance = new Fpdi($pathHandler->getOriginPath());
        $this->pathHandler = $pathHandler;
        $this->specificPages = array();
    }
}