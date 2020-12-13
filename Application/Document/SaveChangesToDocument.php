<?php

include_once( dirname(__FILE__) . '/../../Domain/ObjectModel/Document/Document.php');
include_once( dirname(__FILE__) . '/../../Domain/Document/SaveDocumentInterface.php');

class SaveChangesToDocument {
    private SaveDocumentInterface $saveDocument;

    public function __construct(SaveDocumentInterface $saveDocument) {
        $this->saveDocument = $saveDocument;
    }

    public function execute(Document $document) : void {
        $this->saveDocument->execute($document);
    }
}