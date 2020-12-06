<?php

interface DocumentFactoryInterface {
    public function create(string $origin_path, string $destination_path, string $watermark_image_path) : DocumentController;
}