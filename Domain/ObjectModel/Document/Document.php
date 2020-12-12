<?php

include_once( dirname(__FILE__) . '/ObjectModel/DocumentPathHandler.php');
include_once( dirname(__FILE__) . '/ObjectModel/Range.php');

abstract class Document {
    public DocumentPathHandler $pathHandler;
    public $pages;

    public function __construct(DocumentPathHandler $pathHandler, Range $range) {
        $this->pathHandler = $pathHandler;
        $this->pages = array();
    }
}
?>