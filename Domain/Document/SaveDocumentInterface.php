<?php

include_once( dirname(__FILE__) . '/../Document/SaveDocumentInterface.php' );

interface SaveDocumentInterface {

    public function execute(Document $document) : void;
}