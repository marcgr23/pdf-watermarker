<?php

include_once( dirname(__FILE__) . '/../Document.php');

interface GetTotalPagesFromDocumentInterface {

    public function execute(Document $document) : int; 
}
?>