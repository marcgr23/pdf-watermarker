<?php

include_once( dirname(__FILE__) . '/DocumentController.php' );

interface ImportPageInterface {

    public function execute(DocumentPage $page, Document &$document) : void;
}