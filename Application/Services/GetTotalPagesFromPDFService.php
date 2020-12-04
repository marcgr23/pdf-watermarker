<?php

use \setasign\Fpdi\Fpdi;

class GetTotalPagesFromPDFService {
    public function getTotalPages(FPDI $pdfInstance) {
        return $pdfInstance->setSourceFile($this->pathHandler->getOriginPath());
    }
}