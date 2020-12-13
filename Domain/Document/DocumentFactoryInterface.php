<?php

interface DocumentFactoryInterface {
    public function create(string $originPath, string $destinationPath) : Document;
}