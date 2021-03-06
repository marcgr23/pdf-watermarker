<?php

include_once( dirname(__FILE__) . '/../../../Domain/ObjectModel/Document/DocumentPathHandler.php');
include_once( dirname(__FILE__) . '/../../../Domain/ObjectModel/Document/Range.php');

require_once('vendor/autoload.php');
use \setasign\Fpdi\Fpdi;

class PdfDocument extends Document {
    public Fpdi $pdfInstance;

    public function __construct(DocumentPathHandler $pathHandler) {
        $this->pdfInstance = new Fpdi();
        $this->pdfInstance->setSourceFile($pathHandler->getOriginPath());
        parent::__construct($pathHandler);
    }
}