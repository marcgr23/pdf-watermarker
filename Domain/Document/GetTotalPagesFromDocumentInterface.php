<?php

include_once( dirname(__FILE__) . '/../ObjectModel/Document/Document.php');

interface GetTotalPagesFromDocumentInterface {

    public function execute(Document $document) : int; 
}
?>