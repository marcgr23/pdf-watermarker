<?php

class DocumentPathHandler {

    private $originDocumentPath;
    private $destinyDocumentPath;

    public function __construct (string $originDocumentPath,
                                 string $destinyDocumentPath) {
        $this->originDocumentPath = $originDocumentPath;
        $this->destinyDocumentPath = $destinyDocumentPath;
    }

    public function getOriginPath() : string {
        return $this->originDocumentPath;
    }

    public function getDestinyPath() : string {
        return $this->destinyDocumentPath;
    }
}