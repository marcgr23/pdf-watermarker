<?php

include_once( dirname(__FILE__) . '/DocumentPathHandler.php');

abstract class Document {
    public DocumentPathHandler $pathHandler;
    public $pages;

    public function __construct(DocumentPathHandler $pathHandler) {
        $this->pathHandler = $pathHandler;
        $this->pages = array();
    }
}
?>