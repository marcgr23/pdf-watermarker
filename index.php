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
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" class="mt-3" style="width: 40%; margin: auto;">
        <h2 class="mb-3">Pdf-watermarker</h2>

        <div class="mb-3">
          <label for="pdf" class="form-label">Seleccione un documento PDF:</label>
          <input type="file" class="form-control" id="pdf" name="pdf" autocomplete="off" required>
        </div>
        <div class="mb-3">
          <label for="watermark" class="form-label">Seleccione una imagen para la marca de agua:</label>
          <input type="file" class="form-control" id="watermark" name="watermark" autocomplete="off" required>
        </div>
        <div class="mb-3">
          <label for="range-min" class="form-label">Seleccione el límite inferior del rango:</label>
          <input type="number" class="form-control" onkeypress="return onlyNumberKey(event)" id="range-min" name="range-min" autocomplete="off" min=1 required>
        </div>
        <div class="mb-3">
          <label for="range-max" class="form-label">Seleccione el límite superior del rango:</label>
          <input type="number" class="form-control" onkeypress="return onlyNumberKey(event)" id="range-max" name="range-max" autocomplete="off" min=0 required>
        </div>
        <div class="mb-3">
          <label for="range-max" class="form-label">Seleccione la posición de la marca de agua:</label>
          <div>
            <select id = "position-list" name="position-list" class="form-control" required>
              <option custom-attr value = "" selected="selected">Hacer click aquí para mostrar las opciones</option>
              <option value = "Default">Centro</option>
              <option value = "topleft">Superior izquierda</option>
              <option value = "topright">Superior derecha</option>
              <option value = "bottomleft">Inferior izquierda</option>
              <option value = "bottomright">Inferior derecha</option>
            </select>
          </div>
        </div>
        
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
      </form>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script type="text/javascript">
      window.onload = function () {
        list = document.getElementById('position-list');
        list.querySelectorAll('[custom-attr]')[0].selected="selected"
      }

      function onlyNumberKey(evt) {
          var field_number = document.getElementById('range-min').value;
          var ASCIICode = (evt.which) ? evt.which : evt.keyCode;
          if ((ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) || (ASCIICode == 48 && field_number == 0)) {
              return false;
          }
          return true; 
      }
    </script>
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
$position = "default";

if (isset($_FILES["pdf"]) && isset($_FILES["watermark"])) {
    //This block initializes params for the construction of the watermarker
    $documentPath = 'input.pdf';
    move_uploaded_file($_FILES['pdf']['tmp_name'], $documentPath);
    $watermarkPath = basename($_FILES['watermark']['name']);
    move_uploaded_file($_FILES['watermark']['tmp_name'], $watermarkPath);

    $pdfOutput = 'page-output.pdf';
    if (isset($_POST['range-min'])) {
        $rangeStart = $_POST['range-min'];
    }
    if (isset($_POST['range-max'])) {
        $rangeEnd = $_POST['range-max'];
    }
    if (isset($_POST['position-list'])) {
        $position = $_POST['position-list'];
    }

    //This block builds the watermark and the watermarker
    $controllerFactory = new PdfControllerFactory();
    $documentFactory = new PdfDocumentFactory();
    $watermark = new Watermark($watermarkPath);
    $watermark->setPosition($position);
    $document = $documentFactory->create($documentPath, $pdfOutput);
    $watermarker = $controllerFactory->create($documentPath, $pdfOutput, $watermark);

    //This block applies the watermark to the selected PDF
    $watermarker->setPageRange(new Range($rangeStart, $rangeEnd), $document);
    $watermarker->applyWatermarksToDocument($document);
    $watermarker->saveDocument($document);

    //This block allows the user to download the resulting PDF
    header('Content-type: application/pdf');
    header('Content-Disposition: attachment; filename="downloaded.pdf"');
    readfile($pdfOutput);

    //This block ensures that no temp PDF/watermark are left after applying the watermark
    unlink($documentPath);
    unlink($watermarkPath);
    unlink($pdfOutput);
}


