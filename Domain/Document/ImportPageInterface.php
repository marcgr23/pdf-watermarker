<?php

interface ImportPageInterface {

    public function execute(DocumentPage $page, Document &$document) : void;
}