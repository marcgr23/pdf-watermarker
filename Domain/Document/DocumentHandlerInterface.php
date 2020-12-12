<?php

interface DocumentHandlerInterface {

    public function applyWatermarksToDocument() : void;

    public function setPageRangesToDocument(int $startPage = 1, int $endPage = null) : void;

    public function saveChangesToDocument() : void;
}
?>