<?php

include_once( dirname(__FILE__) . '/../ObjectModel/Document/Watermark.php');

interface DocumentControllerFactoryInterface {
    public function create(string $origin_path, string $destination_path, Watermark $watermark) : DocumentController;
}