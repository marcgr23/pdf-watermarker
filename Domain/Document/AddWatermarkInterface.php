<?php

interface AddWatermarkInterface {
    public function execute (Document &$document, DocumentPage $page) : void;
}
?>