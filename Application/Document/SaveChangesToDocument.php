<?php

include_once( dirname(__FILE__) . '/../../../Domain/Document.php');
include_once( dirname(__FILE__) . '/../../../Domain/SaveDocumentInterface.php');

class SaveChangesToDocumentService {
    private SaveDocumentInterface $saveDocumentService;

    public function __construct(SaveDocumentInterface $saveDocumentService) {
        $this->saveDocumentService = $saveDocumentService;
    }

    public function execute(Document $document) : void {
        $this->saveDocumentService->execute($document);
    }
}