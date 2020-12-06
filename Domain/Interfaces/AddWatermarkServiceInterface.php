<?php

interface AddWatermarkServiceInterface {
    public function execute (Document &$document, int $pageNumber) : void;
}
?>