<?php

include_once( dirname(__FILE__) . '/ObjectModel/DocumentPathHandler.php');
include_once( dirname(__FILE__) . '/ObjectModel/Range.php');
use \setasign\Fpdi\Fpdi;

class PDFDocument extends Document {
    public Fpdi $pdfInstance;

    public function __construct(DocumentPathHandler $pathHandler, Range $range) {
        $this->pdfInstance = new Fpdi($pathHandler->getOriginPath());
        parent::__construct($pathHandler, $range);
    }
}