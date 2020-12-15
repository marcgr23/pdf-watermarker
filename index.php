<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

  </head>
  <body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="mt-3" style="width: 40%; margin: auto;">
        <h2 class="mb-3">Pdf-watermarker</h2>

        <div class="mb-3">
          <label for="pdf" class="form-label">Seleccione un documento PDF:</label>
          <input type="file" class="form-control" id="pdf" name="pdf">
        </div>
        <div class="mb-3">
          <label for="watermark" class="form-label">Seleccione una imagen para la marca de agua:</label>
          <input type="file" class="form-control" id="watermark" name="watermark">
        </div>
        <div class="mb-3">
          <label for="range-min" class="form-label">Seleccione el límite inferior del rango:</label>
          <input type="number" class="form-control" id="range-min" name="range-min">
        </div>
        <div class="mb-3">
          <label for="range-max" class="form-label">Seleccione el límite superior del rango:</label>
          <input type="number" class="form-control" id="range-max" name="range-max">
        </div>
        
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
      </form>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

  </body>
</html>

<?php

include_once( dirname(__FILE__) . '/Domain/Document/DocumentFactoryInterface.php');
include_once( dirname(__FILE__) . '/Domain/Document/DocumentControllerFactoryInterface.php');
include_once( dirname(__FILE__) . '/Infrastructure/Document/Pdf/PdfControllerFactory.php');
include_once( dirname(__FILE__) . '/Infrastructure/Document/Pdf/PdfDocumentFactory.php');

include_once( dirname(__FILE__) . '/Domain/ObjectModel/Document/Watermark.php');

$rangeStart = 1;
$rangeEnd = 0;
 

var_dump($_POST);
if (isset($_POST['pdf']) && isset($_POST['watermark'])) {
    $controllerFactory = new PdfControllerFactory();
    $documentFactory = new PdfDocumentFactory();
    $documentPath = $_POST['pdf'];
    $watermarkPath = $_POST['watermark'];
    $output = './assets/page-output.pdf';

    if (isset($_POST['range-min'])) {
        $rangeStart = $_POST['range-min'];
    }
    if (isset($_POST['range-max'])) {
        $rangeEnd = $_POST['range-max'];
    }

    $watermark = new Watermark($watermarkPath);
    $document = $documentFactory->create($documentPath, $output);
    $watermarker = $controllerFactory->create($documentPath, $output, $watermark);

    $watermarker->setPageRange(new Range($rangeStart, $rangeEnd), $document);
    $watermarker->applyWatermarksToDocument($document);
    $watermarker->saveDocument($document);

    readfile($output); 
    var_dump('FINAL REACHED');
}


