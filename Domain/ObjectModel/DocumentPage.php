<?php

class DocumentPage {

    private bool $isWatermarkVisible;
    private int $pageNumber;

    function __construct(bool $isWatermarkVisible, int $pageNumber) {
        $this->isWatermarkVisible = $isWatermarkVisible;
        $this->pageNumber = $pageNumber;
    }

    public function isWatermarkVisible() {
        return $this->isWatermarkVisible;
    }
}