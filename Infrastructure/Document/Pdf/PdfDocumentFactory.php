<?php

include_once( dirname(__FILE__) . '/../../../Domain/ObjectModel/Document/DocumentPathHandler.php');
include_once( dirname(__FILE__) . '/../../../Domain/Document/DocumentFactoryInterface.php');
include_once( dirname(__FILE__) . '/PdfDocument.php');

class PdfDocumentFactory implements DocumentFactoryInterface {

    public function create(string $originPath, string $destinyPath) : Document {
        $pathHandler = new DocumentPathHandler($originPath, $destinyPath);
        return new PdfDocument($pathHandler); 
    }
}