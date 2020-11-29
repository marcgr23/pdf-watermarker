<?php

interface PdfAddWatermarkServiceInterface {
    public function execute (int $pageNumber) : void;
}
?>