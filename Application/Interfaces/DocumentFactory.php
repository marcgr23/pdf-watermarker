<?php

interface DocumentFactory {
    public function createDocument(string $originPath, string $destinyPath, Watermark $watermark) : DocumentHandlerInterface;
}