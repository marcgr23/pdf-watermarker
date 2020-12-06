<?php



interface CoordinatesCalculatorInterface {

    public function execute(Watermark $watermark, string $templateId) : Coordinates;
}
?>