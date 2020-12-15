<!DOCTYPE html>
<html>
    <body>
        <form action="" method="post">
            <label for="pdf">Seleccione un documento PDF:</label>
            <input type="file" id="pdf" name="pdf">
            <label for="watermark">Seleccione una imagen para la marca de agua:</label>
            <input type="file" id="watermark" name="watermark">

            <label for="range-min">Seleccione el límite inferior del rango:</label>
            <input type="number" id="range-min" name="range-min">
            <label for="range-max">Seleccione el límite superior del rango:</label>
            <input type="number" id="range-max" name="range-max">

            <input type="radio" id="jpg" name="jpg" value="jpg">
            <label for="jpg">jpg</label><br>
            <input type="radio" id="png" name="png" value="png">
            <label for="png">png</label><br>

            <input type="submit" value="Submit">
        </form>
    </body>
</html>

<?php

include_once( dirname(__FILE__) . '/Domain/Document/DocumentFactoryInterface.php');
include_once( dirname(__FILE__) . '/Domain/Document/DocumentControllerFactoryInterface.php');
include_once( dirname(__FILE__) . '/Infrastructure/Document/Pdf/PdfControllerFactory.php');
include_once( dirname(__FILE__) . '/Infrastructure/Document/Pdf/PdfDocumentFactory.php');

include_once( dirname(__FILE__) . '/Domain/ObjectModel/Document/Watermark.php');
include_once( dirname(__FILE__) . '/Domain/Image/SetupPngImage.php');
include_once( dirname(__FILE__) . '/Domain/Image/SetupJpgImage.php');

$rangeStart = 1;

if (isset($_POST['pdf']) && isset($_POST['watermark']) && isset($_POST['watermark'])) {

    if (isset($_POST['jpg'])) {
        $imagePreparer = new SetupPngImage();
    }
    if (isset($_POST['png'])) {

    }

        $factory = new PdfControllerFactory();
        $documentFactory = new PdfDocumentFactory();

}