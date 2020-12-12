<?php

interface DocumentFactoryInterface {
    public function create(string $origin_path, string $destination_path, Watermark $watermark) : DocumentController;
}