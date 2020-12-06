<?php

interface AddWatermarkServiceInterface {
    public function execute (Document &$document, DocumentPage $page) : void;
}
?>