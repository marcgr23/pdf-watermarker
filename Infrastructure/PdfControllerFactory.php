<?php

include_once( dirname(__FILE__) . '/DocumentController.php' );

class PdfControllerFactory implements DocumentFactoryInterface {
    public function create(string $originPath, string $destinationPath, string $watermarkImagePath) : DocumentController {

    }
}