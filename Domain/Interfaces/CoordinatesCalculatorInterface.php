<?php



interface CoordinatesCalculatorInterface {

    public function execute(Watermark $watermark, string $templateId, Document $document) : Coordinates;
}
?>