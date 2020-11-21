<?php

interface DocumentHandlerInterface {

    public function applyWatermarksToDocument();

    public function setPageRangesToDocument(int $startPage = 1, int $endPage = null);

    public function saveChangesToDocument();
}
?>